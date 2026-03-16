<?php
// app/Exports/BranchCompanyExport.php

namespace App\Exports;

use App\Models\BranchCompany;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class BranchCompanyExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    WithTitle,
    WithEvents
{
    protected $bulan;
    protected $tahun;
    protected $data;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->data  = BranchCompany::whereMonth('created_at', $bulan)
                            ->whereYear('created_at', $tahun)
                            ->get();
    }

    public function collection(): Collection
    {
        return $this->data->map(function ($item, $index) {
            return [
                'no'           => $index + 1,
                'nama_cabang'  => $item->name_branch_company,
                'email'        => $item->email_branch_company,
                'alamat'       => $item->address_branch_company,
                'telepon'      => '+62' . $item->phone_number,
                'status'       => ucfirst($item->status),
                'dibuat'       => Carbon::parse($item->created_at)->format('d M Y'),
                'diperbarui'   => Carbon::parse($item->updated_at)->format('d M Y'),
                'keterangan'   => '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Cabang',
            'Email',
            'Alamat',
            'No. Telepon',
            'Status',
            'Dibuat',
            'Diperbarui',
            'Keterangan',
        ];
    }

    public function title(): string
    {
        return 'Data Branch Company';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 28,
            'D' => 38,
            'E' => 20,
            'F' => 14,
            'G' => 16,
            'H' => 16,
            'I' => 24,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $total         = $this->data->count();
                $totalAktif    = $this->data->where('status', 'active')->count();
                $totalInaktif  = $this->data->where('status', 'inactive')->count();
                $namaBulan     = Carbon::create()->month($this->bulan)->format('F');
                $dataStartRow  = 9; // data mulai row 9
                $dataEndRow    = $dataStartRow + $total - 1;
                $lastRow       = $dataEndRow + 2; // footer

                // ── Geser semua data ke bawah dulu (insert rows untuk header) ──
                $sheet->insertNewRowBefore(1, 8);

                // ── ROW 1: Accent bar ─────────────────────────────────────────
                $sheet->mergeCells('A1:I1');
                $sheet->getRowDimension(1)->setRowHeight(8);
                $sheet->getStyle('A1:I1')->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563EB']],
                ]);

                // ── ROW 2: Judul Utama ────────────────────────────────────────
                $sheet->mergeCells('A2:I2');
                $sheet->setCellValue('A2', 'LAPORAN DATA BRANCH COMPANY');
                $sheet->getRowDimension(2)->setRowHeight(46);
                $sheet->getStyle('A2')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 18, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial'],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A8A']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);

                // ── ROW 3: Sub header ─────────────────────────────────────────
                $sheet->mergeCells('A3:C3');
                $sheet->setCellValue('A3', 'PT. MANAGEMENT MRP CORPORATION');
                $sheet->mergeCells('D3:F3');
                $sheet->setCellValue('D3', 'Laporan Bulanan — Branch Company');
                $sheet->mergeCells('G3:I3');
                $sheet->setCellValue('G3', 'Dicetak: ' . now()->format('d F Y'));
                $sheet->getRowDimension(3)->setRowHeight(20);

                $sheet->getStyle('A3:I3')->applyFromArray([
                    'font'      => ['size' => 9, 'color' => ['rgb' => 'DBEAFE'], 'name' => 'Arial'],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E40AF']],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'indent' => 1],
                ]);
                $sheet->getStyle('D3')->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getStyle('G3')->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT, 'indent' => 1],
                ]);

                // ── ROW 4: Spacer ─────────────────────────────────────────────
                $sheet->getRowDimension(4)->setRowHeight(6);
                $sheet->getStyle('A4:I4')->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E2E8F0']],
                ]);

                // ── ROW 5: Filter Info ────────────────────────────────────────
                $sheet->getRowDimension(5)->setRowHeight(20);
                $sheet->mergeCells('A5:B5');
                $sheet->setCellValue('A5', 'Bulan / Tahun');
                $sheet->mergeCells('C5:D5');
                $sheet->setCellValue('C5', $namaBulan . ' ' . $this->tahun);
                $sheet->mergeCells('E5:F5');
                $sheet->setCellValue('E5', 'Total Data');
                $sheet->setCellValue('G5', $total);

                $sheet->getStyle('A5:I5')->applyFromArray([
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DBEAFE']],
                    'font'      => ['size' => 9, 'name' => 'Arial', 'color' => ['rgb' => '1E3A8A']],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'indent' => 1],
                ]);
                $sheet->getStyle('A5')->applyFromArray(['font' => ['bold' => true]]);
                $sheet->getStyle('E5')->applyFromArray(['font' => ['bold' => true]]);
                $sheet->getStyle('G5')->applyFromArray([
                    'font'      => ['bold' => true, 'color' => ['rgb' => '1E3A8A']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // ── ROW 6: Summary Aktif/Inaktif ─────────────────────────────
                $sheet->getRowDimension(6)->setRowHeight(20);
                $sheet->mergeCells('A6:B6');
                $sheet->setCellValue('A6', 'Aktif');
                $sheet->mergeCells('C6:D6');
                $sheet->setCellValue('C6', $totalAktif);
                $sheet->mergeCells('E6:F6');
                $sheet->setCellValue('E6', 'Tidak Aktif');
                $sheet->mergeCells('G6:H6');
                $sheet->setCellValue('G6', $totalInaktif);

                $sheet->getStyle('A6:I6')->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FEF9C3']],
                    'font' => ['bold' => true, 'size' => 9, 'name' => 'Arial', 'color' => ['rgb' => '854D0E']],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'indent' => 1],
                ]);
                $sheet->getStyle('C6:D6')->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DCFCE7']],
                    'font' => ['bold' => true, 'color' => ['rgb' => '166534']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getStyle('G6:H6')->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FEE2E2']],
                    'font' => ['bold' => true, 'color' => ['rgb' => '991B1B']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // ── ROW 7: Spacer ─────────────────────────────────────────────
                $sheet->getRowDimension(7)->setRowHeight(6);
                $sheet->getStyle('A7:I7')->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E2E8F0']],
                ]);

                // ── ROW 8: Table Header ───────────────────────────────────────
                $sheet->getRowDimension(8)->setRowHeight(28);
                $sheet->getStyle('A8:I8')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 10, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial'],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A8A']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                    'borders'   => [
                        'allBorders' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => 'FFFFFF']],
                    ],
                ]);

                // ── DATA ROWS ─────────────────────────────────────────────────
                for ($i = 0; $i < $total; $i++) {
                    $row    = $dataStartRow + $i;
                    $isEven = ($i % 2 === 0);
                    $bgColor = $isEven ? 'F8FAFC' : 'FFFFFF';
                    $item   = $this->data->values()[$i];

                    $sheet->getRowDimension($row)->setRowHeight(22);
                    $sheet->getStyle("A{$row}:I{$row}")->applyFromArray([
                        'font'      => ['size' => 9, 'name' => 'Arial', 'color' => ['rgb' => '1E293B']],
                        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                        'borders'   => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CBD5E1']],
                        ],
                    ]);

                    // Center: No, Status, Tanggal
                    $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("F{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("G{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("H{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    // Status badge warna
                    if ($item->status === 'active') {
                        $sheet->getStyle("F{$row}")->applyFromArray([
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DCFCE7']],
                            'font' => ['bold' => true, 'color' => ['rgb' => '166534']],
                        ]);
                    } else {
                        $sheet->getStyle("F{$row}")->applyFromArray([
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FEE2E2']],
                            'font' => ['bold' => true, 'color' => ['rgb' => '991B1B']],
                        ]);
                    }
                }

                // ── FOOTER ────────────────────────────────────────────────────
                $footerRow = $dataEndRow + 2;
                $sheet->mergeCells("A{$footerRow}:I{$footerRow}");
                $sheet->setCellValue("A{$footerRow}", '© Management MRP Corporation — Dokumen digenerate otomatis oleh sistem');
                $sheet->getRowDimension($footerRow)->setRowHeight(16);
                $sheet->getStyle("A{$footerRow}")->applyFromArray([
                    'font'      => ['size' => 8, 'italic' => true, 'color' => ['rgb' => '64748B'], 'name' => 'Arial'],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E2E8F0']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);

                // ── PRINT SETTINGS ────────────────────────────────────────────
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setFitToPage(true);
                $sheet->getPageSetup()->setFitToWidth(1);
                $sheet->getPageSetup()->setFitToHeight(0);
                $sheet->getPageMargins()->setTop(0.75);
                $sheet->getPageMargins()->setBottom(0.75);
                $sheet->getPageMargins()->setLeft(0.5);
                $sheet->getPageMargins()->setRight(0.5);
                $sheet->freezePane('A9');
                $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 8);
            },
        ];
    }
}
