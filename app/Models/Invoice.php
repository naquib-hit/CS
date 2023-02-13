<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Traits\{ CalculationHelperTrait, UUIDTrait };
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes, Collection};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany, HasOne};

class Invoice extends Model
{
    use HasFactory, SoftDeletes, CalculationHelperTrait, UUIDTrait;

    // private const AuthID = \Illuminate\Support\Facades\Auth::id();

    //protected $fillable = ['invoice_no', 'create_date', 'due_date', 'notes', 'customer_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $guarded = ['id'];


    /**
     *  Products Relations Definition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'invoice_product', 'invoice_id', 'product_id')
                    ->withPivot('quantity', 'gross_price', 'total_net', 'total_gross');
    }

    /**
     *  Taxes Realation Definition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function taxes(): BelongsToMany
    {
        return $this->belongsToMany(Tax::class, 'invoice_tax', 'invoice_id', 'tax_id');
    }

    /**
     *  Customer Relation Definition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projects(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    /**
     *  User Relationship Definition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     *  InvoiceSummary Relationship Definition
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoiceSummary(): HasOne
    {
        return $this->hasOne(InvoiceSummary::class, 'invoice_id', 'id');
    }

    /**
     * Additional Field Relationship Definiton
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function additionalField(): HasMany
    {
        return $this->hasMany(AdditionalField::class, 'invoice_id', 'id');
    }

    /**
     * Undocumented function
     *
     * @param string $unit
     * @param integer $amount
     * @param integer $percent
     * @return integer
     */
    public static function setFixedOrPercent(string $unit, int $amount, ?int $subtotal): int
    {
        switch($unit)
        {
            case 'fixed': return $amount;
            case 'percent': return self::percentOf($subtotal, $amount);
        }
    }
	
	public static function calculateAdditionalField(int $a, int $b, string $opt): int
	{
		return self::arithmethic($a, $b, $opt);
	}

    /**
     * Insert Invoice's Summary
     *
     * @param string $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function setInvoiceSummary(string $id): Collection
    {
        $summary = Invoice::find($id)->products()->get();
        $summary->tap(function($coll) use ($summary) {
                    $gross = $coll->pluck('pivot')
                                    ->pluck('total_gross')
                                    ->reduce(fn ($sum, $curr) => $sum + $curr);
                    $summary->put('gross_summ', $gross);
                })
                ->tap(function($coll) use ($summary) {
                    $net = $coll->pluck('pivot')
                                    ->pluck('total_net')
                                    ->reduce(fn ($sum, $curr) => $sum + $curr);
                    $summary->put('net_summ', $net);
                });

        return $summary;
    }

    /** */
    public function createInvoiceSummary($id): self
    {
        $sum = self::setInvoiceSummary($id);
        self::invoiceSummary()->updateOrCreate(['invoice_id' => $id], ['net_summary' => $sum->get('net_summ'), 'gross_summary' => $sum->get('gross_summ')]);
        return $this;
    }

    /**
     * Insert Invoice's Products
     *
     * @param array $items
     * @return self
     */
    public function createItems(array $items): self
    {
        $_items = collect($items)->reduce(function ($summary, $item) {
            $summary[$item['value']] =
                [
                    'gross_price'   => $item['price'],
                    'quantity'      => $item['total'],
                    'total_net'     => self::arithmethic((Product::find($item['value']))->product_price, $item['total'], 'x'),
                    'total_gross'   => self::arithmethic($item['price'], $item['total'], 'x')
                ];
            return $summary;
        }, []);

        $this->products()->sync($_items);

        return $this;
    }

    /**
     * Insert Invoice's Taxes
     *
     * @param [type] $invoice
     * @param [type] $taxes
     * @return self
     */
    public function createTax(array $taxes = NULL): self
    {
        if (!empty($taxes)) {
            $_taxes = collect($taxes)->pluck('value');
            self::taxes()->sync($_taxes);
        }

        return $this;
    }

    /**
     * Insert Additional Fields Data
     *
     * @param array $fields
     * @param int $id
     * @return self
     */
    public function createAdditionalFields(array $fields = NULL, $id):self
    {
        if(!empty($fields))
        {
            collect($fields)->each(function ($field) use ($id) { 
                self::additionalField()->updateOrCreate(
                [
                    'invoice_id'    => $id,
                    'field_name'    => $field['name'],
                ],    
                [
                    'field_value'   => $field['value'],
                    'unit'          => $field['unit'],
                    'operation'     => $field['operation']
                ]);       
            });
        }
        return $this;
    }

    /**
     * get An Invoice By ID
     *
     * @return array
     */
    public static function getInvoiceByID(string $id): array
    {
        $invoice = self::with(['products', 'projects', 'projects.customers', 'taxes', 'additionalField', 'invoiceSummary'])->find($id)->toArray();
        $summary = $invoice['invoice_summary']['gross_summary'];

        for($i=0;$i<count($invoice['taxes']);$i++)
        {
            $sum = self::setFixedOrPercent('percent', $invoice['taxes'][$i]['tax_amount'],  $invoice['invoice_summary']['gross_summary']);
            data_set($invoice, 'taxes.'.$i.'.tax_sum', $sum);
			$summary += $sum;
        }
        //Check discount
        if(!empty($invoice['discount_amount']))
        {
            $discount = self::setFixedOrPercent($invoice['discount_unit'], $invoice['discount_amount'], $invoice['invoice_summary']['gross_summary']);
            data_fill($invoice, 'discount_sum', $discount);
			$summary -= $discount;
        }
		// Check Additional Fields
		if(!empty($invoice['additional_field']))
		{
			$afi=0;
			foreach($invoice['additional_field'] as $af)
			{
                $be = self::setFixedOrPercent($af['unit'], $af['field_value'], $invoice['invoice_summary']['gross_summary']);
                data_set($invoice, 'additional_field.'.$afi.'.field_sum', $be);
				$fieldNum = self::calculateAdditionalField($summary, $be, $af['operation']);
				$summary = $fieldNum;
				$afi++;
			}
		}
		
		data_set($invoice, 'last_result', $summary);
        return $invoice;
    }

    /**
     * C For CRUD Invoice
     *
     * @param array $valid
     * @return self
     */
    public static function createInvoice(array $valid, bool $isReccuring = false): self
    {
        $invoice = new self;

        //$invoice->invoice_no = $valid['invoice_no'];
        //$invoice->po_no = $valid['invoice_po'];

        $invoice->project_id  = $valid['invoice_project'];
        $invoice->create_date = (new \DateTime($valid['invoice_date']))->format('Y-m-d');
        $invoice->discount_amount = $valid['invoice_discount'];
        $invoice->discount_unit = $valid['discount_unit'];
        $invoice->notes = $valid['invoice_notes'];
        $invoice->currency = $valid['invoice_currency'];
        $invoice->user_id = (int) auth()->id() ?? 1;
        $invoice->created_by = (int) auth()->id() ?? 1;

        if($isReccuring)
        {
            $invoice->next_date = (new \DateTime($valid['invoice_next']))->format('Y-m-d');
            $invoice->frequency = $valid['invoice_interval'];
            $invoice->is_reccuring = 1;
        }
        else
        {
            $invoice->due_date = (new \DateTime($valid['invoice_due']))->format('Y-m-d');
            $invoice->is_reccuring = 0;
        }

        DB::transaction(function () use ($invoice, $valid) {
            $invoice->save();

            $invoice->createItems($valid['invoice_items'])
                ->createTax($valid['invoice_tax'])
                ->createInvoiceSummary($invoice->id);
            
            if(!empty($valid['additional_input']))
                $invoice->createAdditionalFields($valid['additional_input'], $invoice->id);
        });

        return $invoice;
    }
    /**
     * U For CRUD Invoice
     *
     * @param array $valid
     * @param int $id
     * @return self
     */
    public static function updateInvoice(array $valid, string $id, bool $isReccuring = false): self
    {
        $invoice = self::find($id);

        //$invoice->invoice_no = $valid['invoice_no'];
        //$invoice->po_no = $valid['invoice_po'];

        $invoice->project_id  = $valid['invoice_project'];
        $invoice->create_date = (new \DateTime($valid['invoice_date']))->format('Y-m-d');
        $invoice->discount_amount = $valid['invoice_discount'];
        $invoice->discount_unit = $valid['discount_unit'];
        $invoice->notes = $valid['invoice_notes'];
        $invoice->currency = $valid['invoice_currency'];
        $invoice->user_id = (int) auth()->id();
        $invoice->created_by = (int) auth()->id();

        if($isReccuring)
        {
            $invoice->next_date = (new \DateTime($valid['invoice_next']))->format('Y-m-d');
            $invoice->frequency = $valid['invoice_interval'];
            $invoice->is_reccuring = 1;
        }
        else
        {
            $invoice->due_date = (new \DateTime($valid['invoice_due']))->format('Y-m-d');
            $invoice->is_reccuring = 0;
        }

        DB::transaction(function () use ($invoice, $valid) {
            $invoice->save();

            $invoice->createItems($valid['invoice_items'])
                ->createTax($valid['invoice_tax'])
                ->createInvoiceSummary($invoice->id);
            
            if(!empty($valid['additional_input']))
                $invoice->createAdditionalFields($valid['additional_input'], $invoice->id);
        });

        return $invoice;
    }
}
