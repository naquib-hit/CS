<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class InvoiceObserver
{

    /**
     * Executing the observer after commit transaction
     *
     * @var boolean
     */
    public $afterCommit = TRUE;

    /**
     * Handle the Invoice "saved" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function saved(Invoice $invoice)
    {
        //
        try
        {
            $valid = $invoice->getInvoiceByID($invoice->id);
            Transaction::create([
                'invoice_no'        => $valid['invoice_no'],
                'create_date'       => (new \DateTime($valid['create_date']))->format('Y-m-d'),
                'delivery_status'   => intval($valid['invoice_status']),
                'due_date'          => !empty($valid['due_date']) ? (new \DateTime($valid['due_date']))->format('Y-m-d') : NULL,
                'customer_id'       => $valid['customers']['id'],
                'customer_name'     => $valid['customers']['customer_name'],
                'details'           => json_encode($valid),
                'create_by'         => User::find(auth()->id())->fullname
            ]);
        }
        catch(\Throwable $e)
        {
            Log::error($e->__toString());
        }
       
    }

    /**
     * Handle the Invoice "deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function deleted(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "restored" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function restored(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function forceDeleted(Invoice $invoice)
    {
        //
    }
}
