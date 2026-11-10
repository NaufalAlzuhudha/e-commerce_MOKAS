<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Motorcycle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MotorcycleExportController extends Controller
{
    public function sales(Request $request): StreamedResponse
    {
        $dates = $this->validatedDates($request, 'sales');

        return $this->download(
            Motorcycle::query()
                ->where('status', Motorcycle::STATUS_SOLD)
                ->whereDate('sold_at', '>=', $dates['from_date'])
                ->whereDate('sold_at', '<=', $dates['to_date']),
            'motor-terjual',
            'Motor Terjual',
            $dates
        );
    }

    public function arrivals(Request $request): StreamedResponse
    {
        $dates = $this->validatedDates($request, 'arrivals');

        return $this->download(
            Motorcycle::query()
                ->whereDate('created_at', '>=', $dates['from_date'])
                ->whereDate('created_at', '<=', $dates['to_date'])
                ->orderByDesc('created_at')
                ->orderByDesc('id'),
            'motor-baru-masuk',
            'Motor Baru Masuk',
            $dates
        );
    }

    private function validatedDates(Request $request, string $type): array
    {
        return $request->validate([
            'export_type' => ['required', 'in:'.$type],
            'from_date' => ['required', 'date_format:Y-m-d'],
            'to_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:from_date'],
        ]);
    }

    private function download(Builder $query, string $filename, string $sheetTitle, array $dates): StreamedResponse
    {
        $motorcycles = $query->with('brand')->get();

        return response()->streamDownload(function () use ($motorcycles, $sheetTitle): void {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle($sheetTitle);

            $headers = [
                'ID',
                'Merek',
                'Model',
                'Tahun',
                'Harga (Rp)',
                'Kilometer',
                'Kapasitas Mesin (cc)',
                'Transmisi',
                'Warna',
                'Status',
                'Tanggal Masuk',
                'Tanggal Terjual',
                'Tanggal Dipublikasikan',
                'Deskripsi',
            ];
            $sheet->fromArray($headers, null, 'A1');

            foreach ($motorcycles as $index => $motorcycle) {
                $row = $index + 2;
                $values = [
                    $motorcycle->id,
                    $motorcycle->brand->name,
                    $motorcycle->model,
                    $motorcycle->year,
                    (float) $motorcycle->price,
                    $motorcycle->mileage,
                    $motorcycle->engine_capacity,
                    $motorcycle->transmission,
                    $motorcycle->color,
                    $motorcycle->status,
                    $motorcycle->created_at?->format('Y-m-d H:i:s') ?? '',
                    $motorcycle->sold_at?->format('Y-m-d H:i:s') ?? '',
                    $motorcycle->published_at?->format('Y-m-d H:i:s') ?? '',
                    $motorcycle->description,
                ];

                foreach ($values as $columnIndex => $value) {
                    $cell = $sheet->getCell([$columnIndex + 1, $row]);
                    if (in_array($columnIndex, [0, 3, 4, 5, 6], true)) {
                        $cell->setValueExplicit($value, DataType::TYPE_NUMERIC);
                    } else {
                        $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);
                    }
                }
            }

            $lastColumn = $sheet->getHighestColumn();
            $lastRow = max(1, $motorcycles->count() + 1);
            $sheet->getStyle("A1:{$lastColumn}1")->getFont()->setBold(true);
            $sheet->freezePane('A2');
            $sheet->setAutoFilter("A1:{$lastColumn}{$lastRow}");

            foreach ([
                'A' => 8, 'B' => 18, 'C' => 24, 'D' => 10, 'E' => 18,
                'F' => 15, 'G' => 22, 'H' => 18, 'I' => 16, 'J' => 14,
                'K' => 22, 'L' => 22, 'M' => 26, 'N' => 50,
            ] as $column => $width) {
                $sheet->getColumnDimension($column)->setWidth($width);
            }
            if ($motorcycles->isNotEmpty()) {
                $sheet->getStyle("N2:N{$lastRow}")->getAlignment()->setWrapText(true);
            }

            (new Xlsx($spreadsheet))->save('php://output');
            $spreadsheet->disconnectWorksheets();
        }, "{$filename}-{$dates['from_date']}-{$dates['to_date']}.xlsx", [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
        ]);
    }
}
