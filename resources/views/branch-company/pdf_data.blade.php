{{-- resources/views/pdf/branch-company-letterhead.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $branch->name_branch_company }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #2d2d2d;
            background: #fff;
        }

        /* ===================== LETTERHEAD HEADER ===================== */
        .letterhead-header {
            width: 100%;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 14px;
            margin-bottom: 6px;
        }

        .header-inner {
            width: 100%;
        }

        .header-left {
            display: inline-block;
            width: 15%;
            vertical-align: middle;
        }

        .header-center {
            display: inline-block;
            width: 64%;
            vertical-align: middle;
            text-align: center;
        }

        .header-right {
            display: inline-block;
            width: 18%;
            vertical-align: middle;
            text-align: right;
        }

        .company-logo {
            width: 65px;
            height: 65px;
            object-fit: contain;
        }

        .logo-placeholder {
            width: 70px;
            height: 70px;
            background: #e8f0fe;
            border: 2px dashed #2563eb;
            border-radius: 8px;
            display: inline-block;
            text-align: center;
            line-height: 70px;
            font-size: 10px;
            color: #2563eb;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .company-tagline {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
            letter-spacing: 0.5px;
        }

        .company-contact {
            font-size: 9.5px;
            color: #475569;
            margin-top: 6px;
            line-height: 1.6;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .status-active {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .accent-bar {
            width: 100%;
            height: 4px;
            margin-top: 6px;
            background: linear-gradient(to right, #1e3a8a, #2563eb, #60a5fa, #e0f2fe);
        }

        /* ===================== DOCUMENT INFO ===================== */
        .doc-meta {
            width: 100%;
            margin: 16px 0 10px;
        }

        .doc-meta-left {
            display: inline-block;
            width: 60%;
            vertical-align: top;
        }

        .doc-meta-right {
            display: inline-block;
            width: 38%;
            vertical-align: top;
            text-align: right;
        }

        .doc-title {
            font-size: 14px;
            font-weight: bold;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-left: 4px solid #2563eb;
            padding-left: 8px;
        }

        .doc-subtitle {
            font-size: 10px;
            color: #64748b;
            margin-top: 3px;
            padding-left: 12px;
        }

        .doc-number-box {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 6px 12px;
            display: inline-block;
            text-align: center;
            background: #f8fafc;
        }

        .doc-number-label {
            font-size: 8px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .doc-number-value {
            font-size: 12px;
            font-weight: bold;
            color: #1e3a8a;
            margin-top: 2px;
        }

        /* ===================== CONTENT AREA ===================== */
        .content-area {
            margin-top: 16px;
            min-height: 420px;
        }

        .section-title {
            font-size: 10px;
            font-weight: bold;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
            margin-bottom: 10px;
        }

        /* Info Grid */
        .info-grid {
            width: 100%;
            margin-bottom: 16px;
        }

        .info-grid td {
            padding: 5px 8px;
            vertical-align: top;
            font-size: 10.5px;
        }

        .info-label {
            color: #64748b;
            width: 150px;
            font-size: 10px;
        }

        .info-separator {
            color: #94a3b8;
            width: 10px;
        }

        .info-value {
            color: #1e293b;
            font-weight: 500;
        }

        /* Detail Card */
        .detail-card {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px 14px;
            margin-bottom: 12px;
            background: #fafbfc;
        }

        .detail-card-title {
            font-size: 10px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        /* ===================== SIGNATURE AREA ===================== */
        .signature-area {
            margin-top: 40px;
            width: 100%;
        }

        .signature-box {
            display: inline-block;
            width: 30%;
            text-align: center;
            vertical-align: top;
            margin-right: 3%;
        }

        .signature-line {
            border-top: 1px solid #334155;
            margin-top: 50px;
            padding-top: 6px;
        }

        .signature-name {
            font-size: 10px;
            font-weight: bold;
            color: #1e293b;
        }

        .signature-title {
            font-size: 9px;
            color: #64748b;
            margin-top: 2px;
        }

        /* ===================== FOOTER ===================== */
        .letterhead-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 2px solid #2563eb;
            padding: 8px 20px;
            background: #fff;
        }

        .footer-inner {
            width: 100%;
            font-size: 8.5px;
            color: #94a3b8;
        }

        .footer-left {
            display: inline-block;
            width: 60%;
            vertical-align: middle;
        }

        .footer-right {
            display: inline-block;
            width: 38%;
            vertical-align: middle;
            text-align: right;
        }

        /* ===================== PAGE WRAPPER ===================== */
        .page-wrapper {
            padding: 20px 30px 70px 30px;
        }

        /* Table umum */
        .table-content {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 10px;
        }

        .table-content thead tr {
            background: #1e3a8a;
            color: #fff;
        }

        .table-content thead th {
            padding: 7px 10px;
            text-align: left;
            font-size: 9.5px;
            letter-spacing: 0.3px;
        }

        .table-content tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .table-content tbody td {
            padding: 6px 10px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
        }
    </style>
</head>

<body>

    {{-- ===================== FOOTER FIXED ===================== --}}
    <div class="letterhead-footer">
        <div class="footer-inner">
            <div class="footer-left">
                {{ $branch->address_branch_company }}
            </div>
            <div class="footer-right">
                {{ $branch->email_branch_company }} &nbsp;|&nbsp; +62{{ $branch->phone_number }}
            </div>
        </div>
    </div>

    {{-- ===================== PAGE CONTENT ===================== --}}
    <div class="page-wrapper">

        {{-- LETTERHEAD HEADER --}}
        <div class="letterhead-header">
            <div class="header-inner">
                {{-- Logo --}}
                <div class="header-left">
                    {{-- BENAR - pakai public_path() --}}
                    @if ($logoBase64)
                        <img src="{{ $logoBase64 }}" class="company-logo">
                    @else
                        <div class="logo-placeholder">LOGO</div>
                    @endif
                </div>

                {{-- Nama Perusahaan --}}
                <div class="header-center">
                    <div class="company-name">{{ $branch->name_branch_company }}</div>
                    <div class="company-tagline">Branch Company &mdash; Official Document</div>
                    <div class="company-contact">
                        {{ $branch->address_branch_company }}<br>
                        {{ $branch->email_branch_company }} &nbsp;&bull;&nbsp; +62{{ $branch->phone_number }}
                    </div>
                </div>

                {{-- Status --}}
                <div class="header-right">
                    <span class="status-badge {{ $branch->status == 'active' ? 'status-active' : 'status-inactive' }}">
                        {{ ucfirst($branch->status) }}
                    </span>
                    <br><br>
                    <div style="font-size:9px; color:#94a3b8;">
                        {{ \Carbon\Carbon::now()->format('d M Y') }}
                    </div>
                </div>
            </div>
            <div class="accent-bar"></div>
        </div>

        {{-- DOCUMENT META --}}
        <div class="doc-meta">
            <div class="doc-meta-left">
                <div class="doc-title">{{ $docTitle ?? 'Profil Cabang Perusahaan' }}</div>
                <div class="doc-subtitle">{{ $docSubtitle ?? 'Dokumen Resmi Cabang' }}</div>
            </div>
            <div class="doc-meta-right">
                <div class="doc-number-box">
                    <div class="doc-number-label">No. Dokumen</div>
                    <div class="doc-number-value">
                        {{ $docNumber ?? 'DOC-' . str_pad($branch->id, 4, '0', STR_PAD_LEFT) }}</div>
                </div>
            </div>
        </div>

        {{-- ===================== CONTENT AREA ===================== --}}
        <div class="content-area">

            {{-- Informasi Cabang --}}
            <div class="section-title">Informasi Cabang</div>
            <div class="detail-card">
                <table class="info-grid">
                    <tr>
                        <td class="info-label">Nama Cabang</td>
                        <td class="info-separator">:</td>
                        <td class="info-value">{{ $branch->name_branch_company }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Email</td>
                        <td class="info-separator">:</td>
                        <td class="info-value">{{ $branch->email_branch_company }}</td>
                        <td class="info-label">No. Telepon</td>
                        <td class="info-separator">:</td>
                        <td class="info-value">+62{{ $branch->phone_number }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Alamat</td>
                        <td class="info-separator">:</td>
                        <td class="info-value" colspan="3">{{ $branch->address_branch_company }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Terdaftar Sejak</td>
                        <td class="info-separator">:</td>
                        <td class="info-value">{{ \Carbon\Carbon::parse($branch->created_at)->format('d F Y') }}</td>
                        <td class="info-label">Terakhir Diperbarui</td>
                        <td class="info-separator">:</td>
                        <td class="info-value">{{ \Carbon\Carbon::parse($branch->updated_at)->format('d F Y') }}</td>
                    </tr>
                </table>
            </div>

            {{-- Konten Dinamis (opsional) --}}
            @isset($content)
                <div class="section-title" style="margin-top:16px;">Keterangan</div>
                <div class="detail-card">
                    <p style="line-height:1.8; color:#334155;">{{ $content }}</p>
                </div>
            @endisset

            {{-- Tabel Opsional (misal: list supplier / item per cabang) --}}
            @isset($tableData)
                <div class="section-title" style="margin-top:16px;">{{ $tableTitle ?? 'Data Terkait' }}</div>
                <table class="table-content">
                    <thead>
                        <tr>
                            @foreach ($tableHeaders as $header)
                                <th>{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tableData as $row)
                            <tr>
                                @foreach ($row as $cell)
                                    <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endisset

        </div>

        {{-- SIGNATURE AREA --}}
        <div class="signature-area">
            <div class="signature-box">
                <div class="signature-line">
                    <div class="signature-name">{{ $signerName ?? '( __________________ )' }}</div>
                    <div class="signature-title">{{ $signerTitle ?? 'Dibuat Oleh' }}</div>
                </div>
            </div>
            <div class="signature-box">
                <div class="signature-line">
                    <div class="signature-name">( __________________ )</div>
                    <div class="signature-title">Disetujui Oleh</div>
                </div>
            </div>
            <div class="signature-box">
                <div class="signature-line">
                    <div class="signature-name">( __________________ )</div>
                    <div class="signature-title">Mengetahui</div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
