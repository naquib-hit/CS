<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    private $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $invoice)
    {
        //
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('naquibalatas1987@outlook.com', 'Naquib Alatas')
                    ->markdown('invoices.email')
                    ->with('invoice', $this->invoice)
                    ->attach(public_path('files/invoices/'.str_replace('-', trim(''), $this->invoice['id']).'.pdf'), [
                        'mime'  => 'application/pdf' 
                    ]);
    }
}
