<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany};

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

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
     * Insert Invoice's Products
     *
     * @param Invoice $invoice
     * @param array $items
     * @return self
     */
    public function createItems(array $items): self
    {
        $_items = [];
        foreach ($items as $item)
            $_items[$item['value']] = [
                'quantity'      => $item['total'],
                'total_price'   => (Product::find($item['value']))->product_price * $item['total']
            ];
        $this->products()->syncWithoutDetaching($_items);

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
            self::taxes()->syncWithoutDetaching($_taxes);
        }

        return $this;
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
        $invoice->created_by = (int) auth()->id();
        $invoice->save();

        $invoice->createItems($valid['invoice_items'])->createTax($valid['invoice_tax']);

        return $invoice;
    }
}