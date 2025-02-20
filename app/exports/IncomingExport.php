<?php

namespace App\Exports;

use App\Models\Incoming;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IncomingExport implements FromView, WithColumnWidths, WithStyles
{
    /**
     * Mengambil data dari view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $data = Incoming::all();
        $data = Incoming::orderBy('tanggal_surat_masuk', 'asc')->get();
        $data = Incoming::orderBy('tanggal_pembuatan_surat', 'asc')->get();
        
        return view('transaction.incoming.table', ['data' => $data]);
    }

    /**
     * Mengatur lebar kolom pada file Excel
     *
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 22,   
            'B' => 22,   
            'C' => 22,   
            'D' => 24,   
            'E' => 22,   
            'F' => 60,   
            'G' => 65,   
            'H' => 80,   
            'I' => 82,
        ];
    }

    /**
     * Menambahkan border ke seluruh cell pada worksheet
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Menghitung jumlah baris pada data
        $lastRow = $sheet->getHighestRow();

        // Memberikan border ke seluruh area data (A3 sampai H dengan jumlah baris)
        $sheet->getStyle('A3:I' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], // Warna hitam untuk border
                ],
            ],
        ]);
    }
}
