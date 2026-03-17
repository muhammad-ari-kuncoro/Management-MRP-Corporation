<?php

namespace App\Exports;

use App\Models\Items;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ItemExport implements
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
        $this->data  = Items::with('branchCompany')
                            ->whereMonth('created_at', $bulan)
                            ->whereYear('created_at', $tahun)
                            ->get();
    }

    public function collection(): Collection
    {
        return $this->data->map(function ($item, $index) {
            return [
                'no'                              => $index + 1, // ✅ fix $item + 1 → $index + 1
                'kode_item'                       => $item->kode_item,
                'name_item'                       => $item->name_item,
                'spesification'                   => $item->spesification,
                'type'                            => $item->type,
                'qty'                             => $item->qty,
                'weight_item'                     => $item->weight_item,
                'price_item'                      => 'Rp ' . number_format($item->price_item, 0, ',', '.'),
                'harga_pokok_penjualan'           => 'Rp ' . number_format($item->hpp, 0, ',', '.'),
                'category'                        => $item->category,
                'status_item'                     => $item->status_item, // ✅ fix duplikat key 'type'
                'name_branch_company'             => $item->branchCompany->name_branch_company ?? '-',
                'address_branch_company'          => $item->branchCompany->address_branch_company ?? '-',
                'minim_stok'                      => $item->minim_stok,
                'konversion_items_carbon'         => $item->konversion_items_carbon,
                'dibuat'                          => Carbon::parse($item->created_at)->format('d M Y'),
                'diperbarui'                      => Carbon::parse($item->updated_at)->format('d M Y'),
                'keterangan'                      => $item->description ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Barang / Item',
            'Nama Barang / Item',
            'Spesifikasi Barang',
            'Type',
            'Quantity',
            'Berat Barang / Item',
            'Harga Barang / Item',
            'Harga Pokok Penjualan',
            'Kategori Barang / Item',
            'Tipe Barang / Item',
            'Nama Cabang Perusahaan',
            'Alamat Cabang Perusahaan',
            'Minim Stok Barang / Item',
            'Konversi Barang / Item Per Carbon',
            'Dibuat',
            'Diperbarui',
            'Keterangan',
        ];
    }

    public function title(): string
    {
        return 'Data Item Barang';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 20,  // Kode Item
            'C' => 28,  // Nama Item
            'D' => 30,  // Spesifikasi
            'E' => 16,  // Type
            'F' => 12,  // Quantity
            'G' => 18,  // Berat
            'H' => 20,  // Harga
            'I' => 22,  // HPP
            'J' => 20,  // Kategori
            'K' => 18,  // Status Item
            'L' => 26,  // Nama Cabang
            'M' => 34,  // Alamat Cabang
            'N' => 18,  // Minim Stok
            'O' => 28,  // Konversi Carbon
            'P' => 14,  // Dibuat
            'Q' => 14,  // Diperbarui
            'R' => 26,  // Keterangan
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }

    public function registerEvents(): array
    {
        $lastCol = 'R';

        return [
            AfterSheet::class => function (AfterSheet $event) use ($lastCol) {
                $sheet        = $event->sheet->getDelegate();
                $total        = $this->data->count();
                $namaBulan    = Carbon::create()->month($this->bulan)->format('F');
                $dataStartRow = 9;
                $dataEndRow   = $dataStartRow + $total - 1;

                // ── Insert header rows ────────────────────────────────────────
                $sheet->insertNewRowBefore(1, 8);

                // ── ROW 1: Accent bar ─────────────────────────────────────────
                $sheet->mergeCells("A1:{$lastCol}1");
                $sheet->getRowDimension(1)->setRowHeight(8);
                $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563EB']],
                ]);

                // ── ROW 2: Judul Utama ────────────────────────────────────────
                $sheet->mergeCells("A2:{$lastCol}2");
                $sheet->setCellValue('A2', 'LAPORAN DATA ITEM BARANG');
                $sheet->getRowDimension(2)->setRowHeight(46);
                $sheet->getStyle('A2')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 18, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial'],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A8A']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);

                // ── ROW 3: Sub header ─────────────────────────────────────────
                $sheet->mergeCells('A3:E3');
                $sheet->setCellValue('A3', 'PT. MANAGEMENT MRP CORPORATION');
                $sheet->mergeCells('F3:K3');
                $sheet->setCellValue('F3', 'Laporan Bulanan — Data Item Barang');
                $sheet->mergeCells("L3:{$lastCol}3");
                $sheet->setCellValue('L3', 'Dicetak: ' . now()->format('d F Y'));
                $sheet->getRowDimension(3)->setRowHeight(20);

                $sheet->getStyle("A3:{$lastCol}3")->applyFromArray([
                    'font'      => ['size' => 9, 'color' => ['rgb' => 'DBEAFE'], 'name' => 'Arial'],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E40AF']],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getStyle('A3')->applyFromArray([
                    'font'      => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'indent' => 1],
                ]);
                $sheet->getStyle('F3')->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getStyle('L3')->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT, 'indent' => 1],
                ]);

                // ── ROW 4: Spacer ─────────────────────────────────────────────
                $sheet->getRowDimension(4)->setRowHeight(6);
                $sheet->getStyle("A4:{$lastCol}4")->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E2E8F0']],
                ]);

                // ── ROW 5: Filter Info ────────────────────────────────────────
                $sheet->getRowDimension(5)->setRowHeight(20);
                $sheet->mergeCells('A5:C5');
                $sheet->setCellValue('A5', 'Bulan / Tahun');
                $sheet->mergeCells('D5:F5');
                $sheet->setCellValue('D5', $namaBulan . ' ' . $this->tahun);
                $sheet->mergeCells('G5:I5');
                $sheet->setCellValue('G5', 'Total Data');
                $sheet->mergeCells('J5:K5');
                $sheet->setCellValue('J5', $total);

                $sheet->getStyle("A5:{$lastCol}5")->applyFromArray([
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DBEAFE']],
                    'font'      => ['size' => 9, 'name' => 'Arial', 'color' => ['rgb' => '1E3A8A']],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'indent' => 1],
                ]);
                $sheet->getStyle('A5')->applyFromArray(['font' => ['bold' => true]]);
                $sheet->getStyle('G5')->applyFromArray(['font' => ['bold' => true]]);
                $sheet->getStyle('J5')->applyFromArray([
                    'font'      => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // ── ROW 6: Summary Stok ───────────────────────────────────────
                $totalMinim  = $this->data->where('qty', '<=', 'minim_stok')->count();
                $totalAman   = $total - $totalMinim;

                $sheet->getRowDimension(6)->setRowHeight(20);
                $sheet->mergeCells('A6:C6');
                $sheet->setCellValue('A6', 'Stok Aman');
                $sheet->mergeCells('D6:F6');
                $sheet->setCellValue('D6', $totalAman);
                $sheet->mergeCells('G6:I6');
                $sheet->setCellValue('G6', 'Stok Minim');
                $sheet->mergeCells('J6:K6');
                $sheet->setCellValue('J6', $totalMinim);

                $sheet->getStyle("A6:{$lastCol}6")->applyFromArray([
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FEF9C3']],
                    'font'      => ['bold' => true, 'size' => 9, 'name' => 'Arial', 'color' => ['rgb' => '854D0E']],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'indent' => 1],
                ]);
                $sheet->getStyle('D6:F6')->applyFromArray([
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DCFCE7']],
                    'font'      => ['bold' => true, 'color' => ['rgb' => '166534']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getStyle('J6:K6')->applyFromArray([
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FEE2E2']],
                    'font'      => ['bold' => true, 'color' => ['rgb' => '991B1B']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // ── ROW 7: Spacer ─────────────────────────────────────────────
                $sheet->getRowDimension(7)->setRowHeight(6);
                $sheet->getStyle("A7:{$lastCol}7")->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E2E8F0']],
                ]);

                // ── ROW 8: Table Header ───────────────────────────────────────
                $sheet->getRowDimension(8)->setRowHeight(32);
                $sheet->getStyle("A8:{$lastCol}8")->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 9, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial'],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A8A']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                    'borders'   => [
                        'allBorders' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => 'FFFFFF']],
                    ],
                ]);

                // ── DATA ROWS ─────────────────────────────────────────────────
                for ($i = 0; $i < $total; $i++) {
                    $row     = $dataStartRow + $i;
                    $isEven  = ($i % 2 === 0);
                    $bgColor = $isEven ? 'F8FAFC' : 'FFFFFF';
                    $item    = $this->data->values()[$i];

                    $sheet->getRowDimension($row)->setRowHeight(22);
                    $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                        'font'      => ['size' => 9, 'name' => 'Arial', 'color' => ['rgb' => '1E293B']],
                        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                        'borders'   => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CBD5E1']],
                        ],
                    ]);

                    // Center: No, Qty, Dibuat, Diperbarui
                    foreach (['A', 'F', 'P', 'Q'] as $centerCol) {
                        $sheet->getStyle("{$centerCol}{$row}")
                              ->getAlignment()
                              ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }

                    // Right align: Harga, HPP
                    foreach (['H', 'I'] as $rightCol) {
                        $sheet->getStyle("{$rightCol}{$row}")
                              ->getAlignment()
                              ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    }

                    // Stok minim badge warna
                    if ($item->qty <= $item->minim_stok) {
                        $sheet->getStyle("F{$row}")->applyFromArray([
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FEE2E2']],
                            'font' => ['bold' => true, 'color' => ['rgb' => '991B1B']],
                        ]);
                    } else {
                        $sheet->getStyle("F{$row}")->applyFromArray([
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DCFCE7']],
                            'font' => ['bold' => true, 'color' => ['rgb' => '166534']],
                        ]);
                    }
                }

                // ── FOOTER ────────────────────────────────────────────────────
                $footerRow = $dataEndRow + 2;
                $sheet->mergeCells("A{$footerRow}:{$lastCol}{$footerRow}");
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
