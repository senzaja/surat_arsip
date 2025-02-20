<?php

namespace App\Exports;

use App\Models\Outgoing;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OutgoingExport implements FromView, WithColumnWidths, WithStyles
{
    /**
     * Mengambil data koleksi dari model Outgoing dan mengurutkannya berdasarkan tanggal terkecil.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $data = Outgoing::orderBy('tanggal', 'asc')->get(); // Mengurutkan berdasarkan tanggal
        return view('transaction.outgoing.table', ['data' => $data]);
    }

    /**
     * Mengatur lebar kolom pada file Excel
     *
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 14,   
            'B' => 22,   
            'C' => 29,   
            'D' => 47,   
            'E' => 50,   
            'F' => 18,
            'G' => 23,
            'H' => 25,
            'I' => 27,
        ];
    }   

    /**
     * Menambahkan border ke seluruh sel data pada worksheet
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Menghitung jumlah baris pada data
        $lastRow = $sheet->getHighestRow();

        // Memberikan border ke seluruh area data dari kolom A sampai E dan baris 1 sampai baris terakhir
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
