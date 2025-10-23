@extends('backend.v_layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body border-top">
                <h5 class="card-title">{{ $judul }}</h5>
                
                <div class="alert alert-secondary" role="alert"
                    style="background-color:#c5adf0ff; color:#1f5130; border-color:#a9e6b7;">
                    <h4 class="alert-heading">Selamat datang, {{ Auth::user()->nama }}</h4>
                    <p class="mb-0 fw-semibold text-dark">
                        Anda telah masuk ke <b>Sistem Management Aset PT Adijaya Karya Makmur</b>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Wrapper putih untuk statistik dan grafik --}}
<div class="card shadow bg-light p-3 mt-3">
    <div class="row mb-4" style="gap:0px;">
        {{-- Total Asset --}}
        <div class="col" style="flex:0 0 23%; max-width:25%;">
            <div class="p-2 rounded-3 shadow-sm" style="background-color:#f1c263ff;">
                <div class="row align-items-center mb-2">
                    <div class="col-4 text-center">
                        <div class="p-2 rounded-circle bg-white shadow-sm" style="font-size: 1.2rem; color:#212529; width:45px; height:45px; display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                    <div class="col-8">
                        <p class="mb-1 fw-semibold" style="font-size:0.8rem; color:#212529;">Total Asset</p>
                        <h4 class="mb-0 fw-bold text-dark" style="font-size:1.2rem;">{{ $totalAsset }}</h4>
                    </div>
                </div>
                <hr class="my-1">
                <div class="d-flex align-items-center" style="font-size:0.85rem;">
                    <i class="fas fa-angle-double-right text-secondary"></i>
                    <a href="{{ route('backend.asset.perusahaan', ['company' => 'AKM']) }}" 
                        class="text-decoration-none text-dark fw-semibold ms-2">
                        More Info
                    </a>
                </div>
            </div>
        </div>

        {{-- Statik QTY khusus unit AKM --}}
        <div class="col" style="flex:0 0 30%; max-width:30%;">
            <div class="p-2 rounded-3 shadow-sm" style="background-color:#c09dd4ff;">
                <div class="row align-items-center mb-2">
                    <div class="col-4 text-center">
                        <div class="p-2 rounded-circle bg-white shadow-sm" 
                            style="font-size: 1.2rem; color:#212529; width:45px; height:45px; display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                    <div class="col-8">
                        <p class="mb-1 fw-semibold" style="font-size:0.8rem; color:#212529;">
                            Total Quantity
                        </p>
                        <h4 class="mb-0 fw-bold text-dark" style="font-size:1.2rem;">
                            {{ $akmItems->sum('total_qty') }}
                        </h4>
                    </div>
                </div>
                <hr class="my-1">
                <div class="d-flex align-items-center" style="font-size:0.85rem; gap:5px;">
                    <select onchange="location = this.value;" class="form-select form-select-sm" 
                            style="max-width:180px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        <option value="{{ route('backend.asset.index') }}">Pilih Item</option>
                        @foreach($akmItems as $item)
                            <option value="{{ route('backend.asset.akmByItem', $item->item_name) }}">
                                {{ $item->item_name }}
                            </option>
                        @endforeach
                    </select>
                     <a href="{{ route('backend.asset.daftar', ['company' => 'AKM']) }}" 
                        class="text-decoration-none text-dark fw-semibold ms-2">
                        More Info
                    </a>
                </div>
            </div>
        </div>

        {{-- Total User (super_admin + admin IT/GA) --}}
        @if(auth()->check() && in_array(auth()->user()->role, [0,1,2]))
            <div class="col" style="flex:0 0 23%; max-width:25%;">
                <div class="p-2 rounded-3 shadow-sm" style="background-color:#59b4f0ff;">
                    <div class="row align-items-center mb-2">
                        <div class="col-4 text-center">
                            <div class="p-2 rounded-circle bg-white shadow-sm" style="font-size:1.2rem; color:#212529; width:45px; height:45px; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col-8">
                            <p class="mb-1 fw-semibold" style="font-size:0.8rem; color:#212529;">Total Employee</p>
                            <h4 class="mb-0 fw-bold text-dark" style="font-size:1.2rem;">{{ $totalUser }}</h4>
                        </div>
                    </div>
                    <hr class="my-1">
                    <div class="d-flex align-items-center" style="font-size:0.85rem;">
                        <i class="fas fa-angle-double-right text-secondary"></i>
                        <a href="{{ route('backend.user.index') }}" class="text-decoration-none text-dark fw-semibold ms-2">
                            More Info
                        </a>
                    </div>
                </div>
            </div>
        @endif 
        
        {{-- Total Qty --}}
        <div class="col" style="flex:0 0 23%; max-width:25%;">
            <div class="p-2 rounded-3 shadow-sm" style="background-color:#a0ba76ff;">
                <div class="row align-items-center mb-2">
                    <div class="col-4 text-center">
                        <div class="p-2 rounded-circle bg-white shadow-sm" style="font-size: 1.2rem; color:#212529; width:45px; height:45px; display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-boxes"></i>
                        </div>
                    </div>
                    <div class="col-8">
                        <p class="mb-1 fw-semibold" style="font-size:0.8rem; color:#212529;">Total QTY Unit</p>
                        <h4 class="mb-0 fw-bold text-dark" style="font-size:1.2rem;">{{ $totalQty }}</h4>
                    </div>
                </div>
                <hr class="my-1">
                @php
                    $companies = ['AKM','SMM','AKD','BPN','LIN','AGI','ADL','CMT','BDM'];
                @endphp
                <div class="d-flex align-items-center" style="font-size:0.85rem; gap:5px;">
                    <select onchange="location = this.value;" class="form-select form-select-sm">
                        <option value="{{ route('backend.asset.index') }}">Unit</option>
                        @foreach($companies as $company)
                            <option value="{{ route('backend.asset.perusahaan', ['company' => $company, 'tab' => 'grafik']) }}">
                                {{ $company }}
                            </option>
                        @endforeach
                    </select>
                    <a href="{{ route('backend.asset.index') }}" class="text-decoration-none text-dark fw-semibold ms-2">
                        More Info
                    </a>
                </div>
            </div>
        </div>
    </div>
 </div>

    {{-- Grafik Asset --}}
<div class="row mt-4">
    {{-- Grafik Asset by Type (Bar Chart) --}}
    <div class="col-md-6">
        <div class="card shadow h-100">
            <div class="card-header text-white text-center" style="background-color:#706480ff;">
                <div class="fw-bold">Asset by Type</div>
            </div>
            <div class="card-body">
                <canvas id="assetTypeChart" style="max-height:280px;"></canvas>
            </div>
        </div>
    </div>

    {{-- Grafik Asset by Category (Donut Chart) --}}
    <div class="col-md-6">
        <div class="card shadow h-100">
            <div class="card-header text-white text-center" style="background-color:#18608dff;">
                <div class="fw-bold">Asset by Category</div>
            </div>
            <div class="card-body d-flex flex-column align-items-center">
                <canvas id="assetCategoryChart" style="max-width:240px; max-height:240px;"></canvas>
                <div id="assetCategoryLegend" class="legend-container mt-2"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // ===== Bar Chart: Asset by Type =====
    const chartType = new Chart(document.getElementById('assetTypeChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($assetByType->keys()) !!},
            datasets: [{
                label: 'Jumlah Asset',
                data: {!! json_encode($assetByType->values()) !!},
                backgroundColor: '#7e61a1ff',
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // ===== Custom Legend for Donut =====
    function customLegend(chart) {
        const data = chart.data;
        let text = '<ul>';
        data.labels.forEach((label, i) => {
            const bgColor = data.datasets[0].backgroundColor[i];
            text += `
                <li style="display:flex; align-items:center; margin-bottom:4px;">
                    <span style="display:inline-block; width:14px; height:14px; background-color:${bgColor}; margin-right:6px; border-radius:3px;"></span>
                    ${label}
                </li>`;
        });
        text += '</ul>';
        return text;
    }

    // ===== Donut Chart: Asset by Category =====
    const chartCat = new Chart(document.getElementById('assetCategoryChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($assetByCategory->keys()) !!},
            datasets: [{
                data: {!! json_encode($assetByCategory->values()) !!},
                backgroundColor: [
                    '#9a2f3f','#9b898d','#618738','#cd6300','#e67575','#bbdc36',
                    '#7d6fda','#7bf181','#8de6ed','#c564b8','#b58849','#6a2950','#3479a4',
                ],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '40%',   // lubang tengah (besar lubang)
            radius: '75%',  // diameter donut (default 100%)
            plugins: { legend: { display: false } }
        }
    });

    // Inject custom legend
    document.getElementById('assetCategoryLegend').innerHTML = customLegend(chartCat);
</script>

<style>
    /* Legend horizontal */
    .legend-container ul {
        display: flex;
        justify-content: center;
        gap: 20px;
        list-style: none;
        padding: 0;
        margin: 0;
        flex-wrap: wrap;
    }
    .legend-container li {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
    }
    .legend-container li span {
        display: inline-block;
        width: 14px;
        height: 14px;
        border-radius: 3px;
    }
</style>

@endsection
