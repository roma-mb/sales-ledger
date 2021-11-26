<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    public array $headers = ['description', 'value', 'commission'];

    public function collection(): Collection
    {
        $sales           = Sale::createdToday()->select($this->headers)->get();
        $total           = round($sales->sum('value'), 2);
        $totalCommission = round($sales->sum('commission'), 2);

        $sales->add(['TOTAL', $total, $totalCommission]);

        return $sales;
    }

    public function headings(): array
    {
        return array_map('strtoupper', $this->headers);
    }

    public static function createFileName(string $extension): string
    {
        $dateTimeMilliseconds = Carbon::now()->milliseconds;

        return "sale-report-{$dateTimeMilliseconds}.{$extension}";
    }
}
