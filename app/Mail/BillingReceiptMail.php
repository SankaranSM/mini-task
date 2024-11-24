<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BillingReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $billDetails;
    public $totalWithoutTax;
    public $totalTaxPayable;
    public $netTotal;
    public $roundedNetTotal;
    public $balance;
    public $denominationBreakdown;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->email = $data['email'];
        $this->billDetails = $data['billDetails'];
        $this->totalWithoutTax = $data['totalWithoutTax'];
        $this->totalTaxPayable = $data['totalTaxPayable'];
        $this->netTotal = $data['netTotal'];
        $this->roundedNetTotal = $data['roundedNetTotal'];
        $this->balance = $data['balance'];
        $this->denominationBreakdown = $data['denominationBreakdown'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Billing Receipt Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'layout.emails.billing_receipt',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
