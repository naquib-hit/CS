<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var $invoice
     * 
     */
    private array $invoice;
    private User $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $invoice)
    {
        //
        $this->user = User::find(auth()->id());
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('naquibalatas1987@outlook.com', 'Administrator')
                    ->view('invoices.mails.2')
                    ->with('invoice', $this->invoice);
    }
}
