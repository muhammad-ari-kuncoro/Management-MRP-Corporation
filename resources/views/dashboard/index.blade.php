@extends('layouts.layouts_dashboard')
@section('row')

<div class="col-12 col-lg-9">

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg col-md-4">
            <div class="card">
                <div class="card-body px-4 py-4-5 text-center">
                    <div class="stats-icon purple mb-2">
                        <i class="iconly-boldBag"></i>
                    </div>
                    <h6 class="text-muted font-semibold mb-1">Total Items</h6>
                    <h5 class="font-extrabold mb-0">{{ $totalItems ?? 0 }}</h5>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg col-md-4">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="stats-icon blue mb-2">
                        <i class="iconly-boldProfile"></i>
                    </div>
                    <h6 class="text-muted font-semibold mb-1">Total Suppliers</h6>
                    <h5 class="font-extrabold mb-0">{{ $totalSuppliers ?? 0 }}</h5>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg col-md-4">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="stats-icon green mb-2">
                        <i class="iconly-boldDocument"></i>
                    </div>
                    <h6 class="text-muted font-semibold mb-1">Purchase Orders</h6>
                    <h5 class="font-extrabold mb-0">{{ $totalPO ?? 0 }}</h5>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg col-md-4">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="stats-icon orange mb-2">
                        <i class="iconly-boldWork"></i>
                    </div>
                    <h6 class="text-muted font-semibold mb-1">Work Orders</h6>
                    <h5 class="font-extrabold mb-0">{{ $totalWO ?? 0 }}</h5>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg col-md-4">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="stats-icon red mb-2">
                        <i class="iconly-boldHome"></i>
                    </div>
                    <h6 class="text-muted font-semibold mb-1">Branch Companies</h6>
                    <h5 class="font-extrabold mb-0">{{ $totalBranch ?? 0 }}</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart + Recent Work Orders --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Purchase Order Overview</h4>
                </div>
                <div class="card-body">
                    <div id="chart-profile-visit"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h4>Recent Work Orders</h4>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Produk</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentWorkOrders ?? [] as $wo)
                            <tr>
                                <td>{{ $wo->work_order_code }}</td>
                                <td>{{ $wo->product->product_name ?? '-' }}</td>
                                <td>{{ $wo->qty_ordered }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Purchase Orders --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Recent Purchase Orders</h4>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No. PO</th>
                                <th>Tanggal</th>
                                <th>Supplier</th>
                                <th>Grand Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPO ?? [] as $po)
                            <tr>
                                <td>{{ $po->po_no }}</td>
                                <td>{{ $po->po_date }}</td>
                                <td>{{ $po->supplier->name_suppliers ?? '-' }}</td>
                                <td>Rp {{ number_format($po->grand_total, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $badgeClass = match($po->status) {
                                            'done'       => 'bg-success',
                                            'pending'    => 'bg-warning text-dark',
                                            'rejected'   => 'bg-danger',
                                            'waiting_gr' => 'bg-info text-dark',
                                            'draft'      => 'bg-secondary',
                                            default      => 'bg-light text-dark',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $po->status)) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Kolom Kanan --}}
<div class="col-12 col-lg-3">

    {{-- Donut Chart PO Status --}}
    <div class="card mb-4">
        <div class="card-header">
            <h4>Status PO</h4>
        </div>
        <div class="card-body">
            <div id="chart-visitors-profile"></div>
        </div>
    </div>

    {{-- Alert Stok Minimum --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Stok Hampir Habis</h4>
            <span class="badge bg-danger">{{ count($lowStockItems ?? []) }}</span>
        </div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @forelse($lowStockItems ?? [] as $item)
                <li class="list-group-item d-flex justify-content-between align-items-center px-3 py-2">
                    <div>
                        <p class="mb-0 font-semibold" style="font-size: 13px;">{{ $item->name_item }}</p>
                        <small class="text-muted">{{ $item->kd_item }}</small>
                    </div>
                    <span class="badge bg-danger rounded-pill">{{ $item->qty }}</span>
                </li>
                @empty
                <li class="list-group-item text-center text-muted py-3" style="font-size: 13px;">
                    Semua stok aman
                </li>
                @endforelse
            </ul>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    // Override donut chart pakai data real dari controller
    var optionsVisitorsProfile = {
        series: [
            {{ $poByStatus['done'] ?? 0 }},
            {{ $poByStatus['pending'] ?? 0 }},
            {{ $poByStatus['waiting_gr'] ?? 0 }},
            {{ $poByStatus['draft'] ?? 0 }},
            {{ $poByStatus['rejected'] ?? 0 }},
        ],
        labels: ['Done', 'Pending', 'Waiting GR', 'Draft', 'Rejected'],
        colors: ['#28a745', '#ffc107', '#17a2b8', '#6c757d', '#dc3545'],
        chart: {
            type: 'donut',
            width: '100%',
            height: '250px',
        },
        legend: {
            position: 'bottom',
            fontSize: '12px',
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '40%',
                },
            },
        },
    }

    var chartVisitorsProfile = new ApexCharts(
        document.getElementById('chart-visitors-profile'),
        optionsVisitorsProfile
    )
    chartVisitorsProfile.render()
</script>
@endpush
