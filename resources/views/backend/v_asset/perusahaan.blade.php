@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0 p-3">

    <h5>{{ $company }} - Asset Management</h5>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="assetTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ $tab == 'daftar' ? 'active' : '' }}"
            href="{{ url('backend/asset/perusahaan/' . $company . '?tab=daftar') }}">
            📦 Daftar Asset
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab == 'grafik' ? 'active' : '' }}"
            href="{{ url('backend/asset/perusahaan/' . $company . '?tab=grafik') }}">
            📊 Grafik Stok
            </a>
        </li>
    </ul>

    <!-- Konten tiap tab -->
    <div class="tab-content mt-3" id="assetTabsContent">
    <div class="tab-pane fade {{ $tab == 'daftar' ? 'show active' : '' }}" id="daftar" role="tabpanel" aria-labelledby="daftar-tab">
        @include('backend.v_asset.partials.tab_daftar', ['asset' => $asset])
    </div>

    <div class="tab-pane fade {{ $tab == 'grafik' ? 'show active' : '' }}" id="grafik" role="tabpanel" aria-labelledby="grafik-tab">
        @include('backend.v_asset.partials.tab_grafik', [
            'labels' => $labels,
            'qty' => $qty,
            'company' => $company,
            'judul' => $judul
        ])
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabKey = 'activeAssetTab';

    // Tampilkan tab terakhir yang disimpan
    const activeTab = localStorage.getItem(tabKey);
    if (activeTab) {
        const tabTrigger = document.querySelector(`[data-bs-target="${activeTab}"]`);
        if (tabTrigger) {
            new bootstrap.Tab(tabTrigger).show();
        }
    }

    // Simpan tab aktif setiap pindah
    const tabElements = document.querySelectorAll('button[data-bs-toggle="tab"]');
    tabElements.forEach(el => {
        el.addEventListener('shown.bs.tab', function (e) {
            localStorage.setItem(tabKey, e.target.getAttribute('data-bs-target'));
        });
    });
});
</script>
@endpush
