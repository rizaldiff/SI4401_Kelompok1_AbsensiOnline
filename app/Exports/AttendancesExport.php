<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendancesExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $attendances;

    public function __construct(array $attendances)
    {
        $this->attendances = $attendances;
    }

    public function array(): array
    {
        return $this->attendances;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Pegawai',
            'Tanggal Absen',
            'Jam Datang',
            'Jam Pulang',
            'Status Kehadiran',
            'Keterangan Absen',
            'Titik Lokasi Maps'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text and center.
            1    => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],

            // style all border
            'A1:H1' => ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]],
        ];
    }
}
