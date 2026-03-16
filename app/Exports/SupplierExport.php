<?php

namespace App\Exports;

use App\Models\Supplier;
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

class SupplierExport implements
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
        $this->data  = Supplier::with('branchCompany')
                            ->whereMonth('created_at', $bulan)
                            ->whereYear('created_at', $tahun)
                            ->get();
    }

    public function collection(): Collection
    {
        return $this->data->map(function ($item, $index) {
            return [
                'no'                   => $index + 1,
                'nama_supplier'        => $item->name_suppliers,
                'nama_panggilan'       => $item->nickname_suppliers,
                'tipe_supplier'        => $item->type_suppliers,
                'no_telepon'           => '+62' . $item->phone_number,
                'email'                => $item->email,
                'alamat'               => $item->address,
                'alamat_pengiriman'    => $item->address_shipping,
                'website'              => $item->website,
                'nama_pic'             => $item->name_pic,
                'no_telpon_pic'        => '+62' . $item->phone_number_pic,
                'posisi_pic'           => $item->position_pic ?? '-',
                'id_regional'          => $item->id_region,
                'kesepakatan_bayar'    => $item->top . ' Hari',
                'batas_kredit'         => 'Rp ' . number_format($item->limit_kredit, 0, ',', '.'),
                'sales'                => $item->sales,
                'metode_pembayaran'    => $item->method_payment,
                'durasi_pengiriman'    => $item->duration_shipping,
                'metode_pengiriman'    => $item->method_shipping,
                'blacklist'            => ucfirst($item->blacklist),
                'nama_branch_company'  => $item->branchCompany->name_branch_company ?? '-',
                'email_branch_company' => $item->branchCompany->email_branch_company ?? '-',
                'merk'                 => $item->brand,
                'bank'                 => $item->bank,
                'no_rekening'          => $item->no_rek,
                'npwp'                 => $item->npwp,
                'siup'                 => $item->siup,
                'dibuat'               => Carbon::parse($item->created_at)->format('d M Y'),
                'diperbarui'           => Carbon::parse($item->updated_at)->format('d M Y'),
                'keterangan'           => '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Supplier',
            'Nama Panggilan',
            'Tipe',
            'No. Telepon',
            'Email',
            'Alamat',
            'Alamat Pengiriman',
            'Website',
            'Nama PIC',
            'No. Telepon PIC',
            'Posisi PIC',
            'ID Regional',
            'Kesepakatan Bayar',
            'Batas Kredit',
            'Sales',
            'Metode Pembayaran',
            'Durasi Pengiriman',
            'Metode Pengiriman',
            'Blacklist',
            'Nama Cabang',
            'Email Cabang',
            'Merk Barang',
            'Bank',
            'No. Rekening',
            'NPWP',
            'SIUP',
            'Dibuat',
            'Diperbarui',
            'Keterangan',
        ];
    }

    public function title(): string
    {
        return 'Data Supplier';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 28,  // Nama Supplier
            'C' => 22,  // Nama Panggilan
            'D' => 16,  // Tipe
            'E' => 18,  // No. Telepon
            'F' => 26,  // Email
            'G' => 34,  // Alamat
            'H' => 34,  // Alamat Pengiriman
            'I' => 24,  // Website
            'J' => 22,  // Nama PIC
            'K' => 18,  // No. Telepon PIC
            'L' => 18,  // Posisi PIC
            'M' => 12,  // ID Regional
            'N' => 16,  // Kesepakatan Bayar
            'O' => 18,  // Batas Kredit
            'P' => 18,  // Sales
            'Q' => 20,  // Metode Pembayaran
            'R' => 18,  // Durasi Pengiriman
            'S' => 20,  // Metode Pengiriman
            'T' => 12,  // Blacklist
            'U' => 26,  // Nama Cabang
            'V' => 26,  // Email Cabang
            'W' => 18,  // Merk
            'X' => 16,  // Bank
            'Y' => 20,  // No. Rekening
            'Z' => 20,  // NPWP
            'AA'=> 20,  // SIUP
            'AB'=> 14,  // Dibuat
            'AC'=> 14,  // Diperbarui
            'AD'=> 22,  // Keterangan
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }

    public function registerEvents(): array
    {
        // Kolom terakhir adalah AD (30 kolom)
        $lastCol = 'AD';

        return [
            AfterSheet::class => function (AfterSheet $event) use ($lastCol) {
                $sheet        = $event->sheet->getDelegate();
                $total        = $this->data->count();
                $totalBl      = $this->data->where('blacklist', 'yes')->count();
                $totalAman    = $this->data->where('blacklist', 'no')->count();
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
                $sheet->setCellValue('A2', 'LAPORAN DATA SUPPLIER');
                $sheet->getRowDimension(2)->setRowHeight(46);
                $sheet->getStyle('A2')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 18, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial'],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A8A']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);

                // ── ROW 3: Sub header ─────────────────────────────────────────
                $sheet->mergeCells('A3:H3');
                $sheet->setCellValue('A3', 'PT. MANAGEMENT MRP CORPORATION');
                $sheet->mergeCells('I3:R3');
                $sheet->setCellValue('I3', 'Laporan Bulanan — Data Supplier');
                $sheet->mergeCells("S3:{$lastCol}3");
                $sheet->setCellValue('S3', 'Dicetak: ' . now()->format('d F Y'));
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
                $sheet->getStyle('I3')->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getStyle('S3')->applyFromArray([
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
                $sheet->mergeCells('D5:G5');
                $sheet->setCellValue('D5', $namaBulan . ' ' . $this->tahun);
                $sheet->mergeCells('H5:J5');
                $sheet->setCellValue('H5', 'Total Data');
                $sheet->mergeCells('K5:L5');
                $sheet->setCellValue('K5', $total);

                $sheet->getStyle("A5:{$lastCol}5")->applyFromArray([
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DBEAFE']],
                    'font'      => ['size' => 9, 'name' => 'Arial', 'color' => ['rgb' => '1E3A8A']],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'indent' => 1],
                ]);
                $sheet->getStyle('A5')->applyFromArray(['font' => ['bold' => true]]);
                $sheet->getStyle('H5')->applyFromArray(['font' => ['bold' => true]]);
                $sheet->getStyle('K5')->applyFromArray([
                    'font'      => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // ── ROW 6: Summary Blacklist ──────────────────────────────────
                $sheet->getRowDimension(6)->setRowHeight(20);
                $sheet->mergeCells('A6:C6');
                $sheet->setCellValue('A6', 'Supplier Aman');
                $sheet->mergeCells('D6:F6');
                $sheet->setCellValue('D6', $totalAman);
                $sheet->mergeCells('G6:I6');
                $sheet->setCellValue('G6', 'Supplier Blacklist');
                $sheet->mergeCells('J6:L6');
                $sheet->setCellValue('J6', $totalBl);

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
                $sheet->getStyle('J6:L6')->applyFromArray([
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

                    // Center: No, ID Regional, Blacklist, Dibuat, Diperbarui
                    foreach (['A', 'M', 'T', 'AB', 'AC'] as $centerCol) {
                        $sheet->getStyle("{$centerCol}{$row}")
                              ->getAlignment()
                              ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }

                    // Blacklist badge warna
                    if ($item->blacklist === 'yes') {
                        $sheet->getStyle("T{$row}")->applyFromArray([
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FEE2E2']],
                            'font' => ['bold' => true, 'color' => ['rgb' => '991B1B']],
                        ]);
                    } else {
                        $sheet->getStyle("T{$row}")->applyFromArray([
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
