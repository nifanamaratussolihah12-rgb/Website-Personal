@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="assetTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="asset-tab" data-bs-toggle="tab" data-bs-target="#asset" type="button" role="tab" aria-controls="asset" aria-selected="true">
                🖥️ Data Asset
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="kategori-tab" data-bs-toggle="tab" data-bs-target="#kategori" type="button" role="tab" aria-controls="kategori" aria-selected="false">
                📂 Kategori Asset
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="type-tab" data-bs-toggle="tab" data-bs-target="#type" type="button" role="tab" aria-controls="type" aria-selected="false">
                🏷️ Type Asset
            </button>
        </li>
    </ul>

    <!-- Konten tiap tab -->
    <div class="tab-content mt-3" id="assetTabsContent">
        <div class="tab-pane fade show active" id="asset" role="tabpanel" aria-labelledby="asset-tab">
            @include('backend.v_asset.partials.data_asset')
        </div>

        <div class="tab-pane fade" id="kategori" role="tabpanel" aria-labelledby="kategori-tab">
            @include('backend.v_asset.partials.data_kategori')
        </div>

        <div class="tab-pane fade" id="type" role="tabpanel" aria-labelledby="type-tab">
            @include('backend.v_asset.partials.data_type_asset')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabKey = 'activeAssetTab'; // pakai satu key aja, biar konsisten

    // 🔁 Saat halaman dimuat, tampilkan tab terakhir yang disimpan
    const activeTab = localStorage.getItem(tabKey);
    if (activeTab) {
        const tabTrigger = document.querySelector(`[data-bs-target="${activeTab}"]`);
        if (tabTrigger) {
            new bootstrap.Tab(tabTrigger).show();
        }
    }

    // 💾 Simpan tab aktif setiap kali user pindah tab
    const tabElements = document.querySelectorAll('button[data-bs-toggle="tab"]');
    tabElements.forEach(el => {
        el.addEventListener('shown.bs.tab', function (e) {
            localStorage.setItem(tabKey, e.target.getAttribute('data-bs-target'));
        });
    });
});
</script>

@endpush
