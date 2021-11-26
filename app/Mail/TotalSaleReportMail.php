<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TotalSaleReportMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    private string $path;

    private string $recipientName;

    public function __construct(array $attributes)
    {
        $this->path          = $attributes['path'] ?? '';
        $this->recipientName = $attributes['recipientName'] ?? '';
    }

    public function build(): TotalSaleReportMail
    {
        return $this->from('noreply@system.com')
            ->subject('Report daily total sales.')
            ->attach($this->path, ['mime' => 'application/csv', ])
            ->markdown('email.total-sale')
            ->with([
                'recipientName' => $this->recipientName,
            ]);
    }
}
