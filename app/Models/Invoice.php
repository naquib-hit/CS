<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany, HasOne};
use App\Traits\CalculationHelperTrait;

class Invoice extends Model
{
    use HasFactory, SoftDeletes, CalculationHelperTrait;

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
        return $this->belongsToMany(Product::class, 'invoice_product', 'invoice_id', 'product_id')->withPivot('quantity', 'total_price');
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
    public function customers(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
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
     * @param array $items
     * @return int
     */
    public function setInvoiceSummary(int $id): int
    {
        $summary = self::find($id)->products()
                        ->get()
                        ->pluck('pivot')
                        ->pluck('total_price')
                        ->reduce(fn ($sum, $curr) => $sum + $curr);
        return $summary;
    }

    /** */
    public function createInvoiceSummary($id): self
    {
        self::invoiceSummary()->create(['invoice_id' => $id, 'total_summary' => self::setInvoiceSummary($id)]);

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
                    'quantity'      => $item['total'],
                    'total_price'   => (Product::find($item['value']))->product_price * $item['total']
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
                self::additionalField()->create([
                    'invoice_id'    => $id,
                    'field_name'    => $field['name'],
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
    public static function getInvoiceByID(int $id): array
    {
        $invoice = self::with(['products', 'customers', 'taxes', 'additionalField', 'invoiceSummary'])->find($id)->toArray();
        $summary = $invoice['invoice_summary']['total_summary'];

        for($i=0;$i<count($invoice['taxes']);$i++)
        {
            $sum = self::setFixedOrPercent('percent', $invoice['taxes'][$i]['tax_amount'],  $invoice['invoice_summary']['total_summary']);
            data_set($invoice, 'taxes.'.$i.'.tax_sum', $sum);
			$summary += $sum;
        }
        //Check discount
        if(!empty($invoice['discount_amount']))
        {
            $discount = self::setFixedOrPercent($invoice['discount_unit'], $invoice['discount_amount'], $invoice['invoice_summary']['total_summary']);
            data_fill($invoice, 'discount_sum', $discount);
			$summary -= $discount;
        }
		// Check Additional Fields
		if(!empty($invoice['additional_field']))
		{
			$afi=0;
			foreach($invoice['additional_field'] as $af)
			{
                $be = self::setFixedOrPercent($af['unit'], $af['field_value'], $invoice['invoice_summary']['total_summary']);
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
    public static function createInvoice(array $valid): self
    {
        $invoice = new self;

        $invoice->invoice_no = $valid['invoice_no'];
        $invoice->customer_id  = $valid['invoice_customer'];
        $invoice->create_date = (new \DateTime($valid['invoice_date']))->format('Y-m-d');
        $invoice->due_date = (new \DateTime($valid['invoice_due']))->format('Y-m-d');
        $invoice->discount_amount = $valid['invoice_discount'];
        $invoice->discount_unit = $valid['discount_unit'];
        $invoice->notes = $valid['invoice_notes'];
        $invoice->po_no = $valid['invoice_po'];
        $invoice->currency = $valid['invoice_currency'];
        $invoice->user_id = (int) auth()->id();
        $invoice->created_by = (int) auth()->id();

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
