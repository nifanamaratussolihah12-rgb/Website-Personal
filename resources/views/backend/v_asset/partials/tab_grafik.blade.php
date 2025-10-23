<div class="row">
    <div class="col-12">
        <div class="card mt-3 shadow-sm">
            <div class="card-body">
            <!-- Judul halaman -->
            <h4 class="card-title mb-3">📊 {{ $judul }}</h4>

                {{-- Total Qty --}}
                <div class="p-2 mb-3 rounded-3 bg-light shadow-sm" style="max-width:200px;">
                    <p class="mb-1 fw-semibold text-secondary">Total Qty</p>
                    <h4 class="mb-0 fw-bold text-dark">{{ array_sum($qty->toArray()) }}</h4>
                </div>

                {{-- Chart --}}
                <canvas id="stokChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const grafTab = document.getElementById('grafik'); // id tab grafik
    const stokChartCanvas = document.getElementById('stokChart');

    function initChart() {
        const labels = {!! json_encode($labels) !!};
        const data = {
            labels: labels,
            datasets: [{
                label: 'Qty',
                data: {!! json_encode($qty) !!},
                backgroundColor: 'rgba(183, 51, 34, 0.5)',
                borderColor: 'rgba(91, 15, 95, 1)',
                borderWidth: 1
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                    title: { display: true, text: 'Stok Asset {{ $company }}' }
                },
                scales: { y: { beginAtZero: true } }
            }
        };

        new Chart(stokChartCanvas, config);
    }

    // Render chart saat tab grafik muncul
    grafTab.addEventListener('shown.bs.tab', initChart);

    // Jika tab grafik default aktif
    @if($tab === 'grafik')
        initChart();
    @endif
});
</script>
