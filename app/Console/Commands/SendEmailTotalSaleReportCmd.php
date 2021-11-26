<?php

namespace App\Console\Commands;

use App\Enumerations\Mail as MailEnum;
use App\Exports\SalesExport;
use App\Mail\TotalSaleReportMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SendEmailTotalSaleReportCmd extends Command
{
    /** @var string */
    protected $signature = 'total-sale:send';

    /** @var string */
    protected $description = 'Send email report with total sales daily.';

    public function handle(): void
    {
        $fileName = SalesExport::createFileName('csv');
        $path     = 'local/exports/' . $fileName;

        Excel::store(new SalesExport(), $path);

        $realPath = Storage::path($path);

        foreach (MailEnum::SALE_REPORT_RECIPIENTS as $name => $recipient) {
            Mail::to($recipient)->send(new TotalSaleReportMail([
                'path' => $realPath,
                'recipientName' => format_name($name),
            ]));
        }

        Storage::deleteDirectory('local');
    }
}
