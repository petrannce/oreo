<?php

namespace App\Mail;

use App\Models\Billing;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PatientReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $billing;
    public $pdf;

    public function __construct(Billing $billing, $pdf)
    {
        $this->billing = $billing;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Payment Receipt - ' . ($this->billing->patient->fname ?? ''))
                    ->markdown('emails.receipts.patient')
                    ->attachData(
                        $this->pdf->output(),
                        'receipt_' . $this->billing->id . '.pdf',
                        ['mime' => 'application/pdf']
                    );
    }
}
