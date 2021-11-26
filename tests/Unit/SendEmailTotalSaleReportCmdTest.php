<?php

namespace Tests\Unit;

use App\Enumerations\Mail as MailEnum;
use App\Exports\SalesExport;
use App\Mail\TotalSaleReportMail;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class SendEmailTotalSaleReportCmdTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        Excel::fake();
        Mail::fake();
    }

    public function test_call_report(): void
    {
        $this->assertIsInt(Artisan::call('total-sale:send'));
    }

    public function test_store_excel(): void
    {
        $fileName = 'test-report.csv';

        Excel::store(new SalesExport(), $fileName);

        Excel::assertStored($fileName, function (SalesExport $export) {
            return $export->headers === ['description', 'value', 'commission'];
        });
    }

    public function test_send_email(): void
    {
        Artisan::call('total-sale:send');

        $recipients = MailEnum::SALE_REPORT_RECIPIENTS;
        $recipient  = array_pop($recipients);

        Mail::assertSent(TotalSaleReportMail::class, function ($mail) use ($recipient) {
            return $mail->hasTo($recipient);
        });
    }
}
