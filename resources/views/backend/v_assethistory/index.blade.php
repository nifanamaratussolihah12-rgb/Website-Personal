@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
  <div class="card-body">
    <h4 class="card-title mb-3">📜 History</h4>
    <hr>

    @php
        use App\Models\AssetHistory;
        use Carbon\Carbon;

        $user = auth()->user();

        $ownerRole = match($user->role) {
            1 => 'it',
            2 => 'ga',
            default => null
        };

        // Ambil history terakhir yang belum expired (berdasarkan waktu paling dekat)
        $lastHistory = AssetHistory::where('user_id', $user->id)
            ->whereNotNull('expires_at')
            ->where('expires_at', '>', now())
            ->orderBy('expires_at', 'asc') // paling cepat kadaluwarsa
            ->first();

        $totalSeconds = 0;
        if ($lastHistory) {
            $totalSeconds = Carbon::parse($lastHistory->expires_at)->diffInSeconds(now());
        }
    @endphp

    @if($lastHistory)
        <div class="alert alert-info mb-3">
            <i class="bi bi-clock-history me-2"></i>
            History akan dihapus otomatis dalam 
            <strong id="countdownText"></strong>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            let totalSeconds = {{ $totalSeconds }};
            const countdownEl = document.getElementById('countdownText');

            function updateCountdown() {
                if (totalSeconds <= 0) {
                    countdownEl.textContent = 'sebentar lagi...';
                    return;
                }

                const days = Math.floor(totalSeconds / (24 * 60 * 60));
                const hours = Math.floor((totalSeconds % (24 * 60 * 60)) / (60 * 60));
                const minutes = Math.floor((totalSeconds % (60 * 60)) / 60);
                const seconds = totalSeconds % 60;

                let parts = [];
                if (days > 0) parts.push(`${days} hari`);
                if (hours > 0) parts.push(`${hours} jam`);
                if (minutes > 0) parts.push(`${minutes} menit`);
                parts.push(`${seconds} detik`);

                countdownEl.textContent = parts.join(' ');
                totalSeconds--;
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
        </script>
    @endif
    
    <!-- Tabel History -->
    <div class="table-responsive">
        <table id="historyTable" class="table table-hover table-bordered align-middle">
            <thead class="table-custom" style="background-color:#dcdff5ff; color:#000; font-weight:normal; font-size:14px;">
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Asset</th>
                <th class="text-center">User</th>
                <th class="text-center">Tindakan</th>
                <th class="text-center">Status</th>
                <th class="text-center">Deskripsi</th>
               @if(auth()->check() && in_array(auth()->user()->role, [0,1,2]))
                <th class="text-center">Action</th>
                @endif
            </tr>
            </thead>
            <tbody style="font-size:13px;">
            @foreach ($histories as $row)
            <tr>
                <td class="text-center px-3 py-2">{{ $loop->iteration }}</td>
                <td class="px-3 py-2">
                    {{ $row->created_at ? $row->created_at->translatedFormat('d M Y | H:i') : '-' }}
                </td>
                <td class="px-3 py-2">{{ $row->asset->item_name ?? $row->asset->name ?? '-' }}</td>
                <td class="text-center px-3 py-2">{{ $row->user->nama ?? '-' }}</td>
                <td class="text-center px-3 py-2">
                    @php
                        $actionClass = match($row->action) {
                            'created'     => 'badge bg-success bg-opacity-25 text-white',    
                            'updated'     => 'badge bg-info bg-opacity-25 text-white',       
                            'deleted'     => 'badge bg-danger bg-opacity-25 text-white',     
                            'transferred' => 'badge bg-warning bg-opacity-25 text-white',    
                            'maintenance' => 'badge bg-primary bg-opacity-25 text-white',    
                            default       => 'badge bg-secondary bg-opacity-25 text-white'
                        };
                    @endphp
                    <span class="{{ $actionClass }}">{{ ucfirst($row->action) }}</span>
                </td>
                <td class="text-center px-3 py-2">
                    @php
                    $statusClass = match(strtolower($row->status)) {
                        // Ticket-related
                        'open'              => 'badge bg-info text-dark fw-semibold',
                        'in progress'       => 'badge bg-warning text-dark fw-semibold',
                        'troubleshoot'      => 'badge bg-orange text-white fw-semibold',
                        'under maintenance' => 'badge bg-danger text-white fw-semibold',
                        'escalated'         => 'badge bg-purple text-white fw-semibold',
                        'resolved'          => 'badge bg-success text-white fw-semibold',
                        'closed'            => 'badge bg-dark text-white fw-semibold',

                        // Maintenance-related
                        'pending'           => 'badge bg-secondary text-white fw-semibold',
                        'in_progress'       => 'badge bg-warning text-dark fw-semibold',
                        'done'              => 'badge bg-success text-white fw-semibold',
                        'canceled', 'cancelled' => 'badge bg-danger text-white fw-semibold',

                        default             => 'badge bg-light text-dark fw-semibold',
                    };
                    @endphp
                    <span class="{{ $statusClass }}">{{ ucfirst($row->status ?? '-') }}</span>
                </td>
                <td class="px-3 py-2">{{ $row->description ?? '-' }}</td>

                @if(auth()->check() && in_array(auth()->user()->role, [0,1,2]))
                <td class="d-flex justify-content-end px-3 py-2" style="gap: 5px; align-items:center;">
                    <!-- Form Hapus History -->
                    <form method="POST" 
                        action="{{ route('backend.asset-history.destroy', $row->id) }}" 
                        style="display:inline-flex;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm show_confirm" 
                            data-konf-delete="{{ $row->asset->item_name ?? $row->id }}" 
                            title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
                @endif

            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"/>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready(function() {
      $('#historyTable').DataTable({
          ordering: true,
          searching: true,
          pageLength: 10,
          order: [[1, "desc"]],
        //   columnDefs: [
        //       { orderable: true, targets: [0,1] },
        //       { orderable: false, targets: '_all' }
        //   ],
        columnDefs: [
              { orderable: false, targets: -1 } // ❌ kolom terakhir ("Action") aja yang non-sort
          ],
          language: {
              lengthMenu: "Tampilkan _MENU_ data per halaman",
              zeroRecords: "Tidak ada data ditemukan",
              info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
              infoEmpty: "Tidak ada data tersedia",
              infoFiltered: "(disaring dari _MAX_ total data)",
              search: "Search:",
              paginate: {
                  first: "Pertama",
                  last: "Terakhir",
                  next: "›",
                  previous: "‹"
              }
          }
      });
  });
</script>
@endpush
