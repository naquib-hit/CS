<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany};

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    //protected $fillable = ['invoice_no', 'create_date', 'due_date', 'notes', 'customer_id'];
    protected $attributes = [
        'created_by' => Auth::id()
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];


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
     *  User Relation Definition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function getDiscount()
    {
    }

    /**
     * Insert Products to 
     *
     * @param Invoice $invoice
     * @param array $items
     * @return self
     */
    public static function createItems(Invoice $invoice, array $items): self
    {
        $_items = [];
        foreach ($items as $item)
            $_items[$item['value']] = [
                'quantity'      => $item['total'],
                'total_price'   => (Product::find($item['value']))->product_price * $item['total']
            ];
        $invoice->products()->syncWithoutDetaching($_items);

        return $invoice;
    }

    /**
     * Undocumented function
     *
     * @param [type] $invoice
     * @param [type] $taxes
     * @return self
     */
    public static function createTax(Invoice $invoice = NULL, array $taxes = NULL): self
    {
        if (!empty($taxes)) {
            $_taxes = collect($taxes)->pluck('value');
            $invoice->taxes()->syncWithoutDetaching($_taxes);
        }

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
        $invoice->notes = $valid['invoice_notes'];
        $invoice->user_id = (int) auth()->id();
        $invoice->save();

        self::createItems($invoice, $valid['invoice_items']);
        self::createTax($invoice, $valid['invoice_tax']);

        return $invoice;
    }
}