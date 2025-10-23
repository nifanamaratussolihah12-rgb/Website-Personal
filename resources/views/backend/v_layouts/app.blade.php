<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/icon_AKM.png') }}">
    
    <title>Asset Management System</title>

    <!-- Vendor CSS / Libraries -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/extralibs/multicheck/multicheck.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/style.min.css') }}">

    <!-- Compiled App CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout/topbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/component.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>


<body class="skin-default">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->

    
    <div id="main-wrapper">
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="">
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light"
                            href="javascript:void(0)"
                            data-sidebartype="mini-sidebar">
                            <i class="mdi mdi-menu font-24"></i>
                        </a>
                    </li>
                    </ul>

                    <ul class="navbar-nav float-right">
                        <!-- ========================================================== -->
                        <!-- User profile and search -->
                        <li class="nav-item dropdown">
                        <!-- Notifikasi Lonceng -->
                        @if(auth()->check())
                            @php
                                // base query
                                $baseQuery = \App\Models\Notification::where('user_id', auth()->id())
                                                ->where('is_read', 0)
                                                ->orderBy('created_at', 'desc');

                                // hitung total unread
                                $unreadCount = $baseQuery->count();

                                // ambil data notifikasi sesuai role
                                if (in_array(auth()->user()->role, [0,1,2])) {
                                    // admin → cuma 5 terbaru
                                    $notifications = $baseQuery->take(1)->get();
                                } else {
                                    // user biasa → semua
                                    $notifications = $baseQuery->get();
                                }
                            @endphp

                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownNotif" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: relative; padding: 0 10px;">
                                <i class="fas fa-bell" style="font-size: 20px;"></i>
                                @if($unreadCount > 0)
                                    <span style="
                                        position: absolute;
                                        right: -4px;
                                        background: red;
                                        color: #fff;
                                        font-size: 10px;
                                        width: 16px;
                                        height: 16px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        border-radius: 50%;
                                        font-weight: bold;
                                    ">{{ $unreadCount }}</span>
                                @endif
                            </a>

                            <div class="dropdown-menu dropdown-menu-right animated" aria-labelledby="navbarDropdownNotif" style="width: 320px; max-height: 400px; overflow-y: auto;">
                                <h6 class="dropdown-header">Notifikasi</h6>
                                @forelse($notifications as $notif)
                                    <a href="{{ route('backend.notification.read', $notif->id) }}" 
                                    class="dropdown-item" 
                                    style="white-space: normal; word-wrap: break-word; font-size:12px;">

                                        {{ $notif->message }} <br>
                                        <small class="text-muted">{{ $notif->created_at->format('d M Y H:i') }}</small>
                                    </a>
                                @empty
                                    <span class="dropdown-item">Tidak ada notifikasi baru</span>
                                @endforelse

                                @if($unreadCount > 0 && in_array(auth()->user()->role, [1,2]))
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('backend.notification.clear') }}" method="POST" class="text-right p-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus Semua
                                        </button>
                                    </form>
                                @endif

                                @if($unreadCount > 5 && in_array(auth()->user()->role, [0,1,2]))
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-center text-primary" href="{{ route('backend.notification.index') }}">
                                        Lihat semua notifikasi ({{ $unreadCount }})
                                    </a>
                                @endif
                            </div>
                        @endif


                        <!-- User profile -->
                        <li class="nav-item dropdown">
                            @if(Auth::check())
                                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" 
                                href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    @if (Auth::user()->foto)
                                        <img src="{{ asset('storage/img-user/' . Auth::user()->foto) }}" 
                                            alt="user" class="rounded-circle" width="31">
                                    @else
                                        <i class="fas fa-user-circle" 
                                            style="font-size: 31px; color: #fff;"></i>
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                    @auth
                                        <a class="dropdown-item" href="{{ route('backend.user.show', Auth::user()->id) }}">
                                            <i class="ti-user m-r-5 m-l-5"></i> Profil Saya
                                        </a>
                                    @endauth
                                    <a class="dropdown-item" href="" 
                                    onclick="event.preventDefault(); document.getElementById('keluar-app').submit();">
                                        <i class="fa fa-power-off m-r-5 m-l-5"></i> Keluar
                                    </a>
                                    <div class="dropdown-divider"></div>
                                </div>
                            @else
                                {{-- Kalau belum login, tampilkan icon profil --}}
                                <a class="nav-link text-muted waves-effect waves-dark pro-pic" href="#">
                                    <i class="fas fa-user-circle" 
                                    style="font-size: 28px; color: #6c757d;"></i>
                                </a>
                            @endif
                        </li>
                        <!-- ========================================================== -->
                        <!-- User profile and search -->
                        <!-- ========================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- End Topbar header -->
                                
<!-- Left Sidebar -->
<aside class="left-sidebar" data-sidebarbg="skin5" style="position:fixed; top:0; left:0; bottom:0; height:100vh;">
    <!-- ✅ LOGO AMS -->
    <div class="navbar-header" 
        style="background: linear-gradient(to right, rgb(158, 206, 236), rgb(75, 65, 183));  
        display:flex; 
        align-items:center; 
        height:60px; 
        padding:0 10px;">
        <a class="navbar-brand" href="#" style="display:flex; align-items:center; width:100%; justify-content:flex-start;">
            <!-- Logo icon -->
            <img src="{{ asset('image/icon_AKM.png') }}" 
                alt="logo"
                class="logo-icon" 
                style="height:45px; width:auto; transition: all 0.3s ease;" />

            <!-- Teks AMS -->
            <div class="logo-text" style="font-family: Arial, sans-serif; font-weight:600; line-height:1.1; transition: opacity 0.3s ease, width 0.3s ease;">
                <div style="
                    font-size:37px;
                    font-weight:700;
                    background: linear-gradient(90deg, #f91313ff, #d5af04ff);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    ">
                    AMS
                </div>
                <div style="
                    font-size:10px;
                    font-weight:700;
                    background: linear-gradient(90deg, #f91313ff, #d5af04ff);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    ">
                    Asset Management System
                </div>
            </div>
        </a>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const logoIcon = document.querySelector('.logo-icon');
        const logoText = document.querySelector('.logo-text');

        function adjustLogo() {
            if (document.body.classList.contains('mini-sidebar')) {
                // Shrink logo & hide text
                logoIcon.style.height = '30px'; // lebih kecil
                logoText.style.opacity = '0';
                logoText.style.width = '0';
                logoText.style.overflow = 'hidden';
            } else {
                // Kembali normal
                logoIcon.style.height = '45px';
                logoText.style.opacity = '1';
                logoText.style.width = 'auto';
                logoText.style.overflow = 'visible';
            }
        }

        // saat load halaman
        adjustLogo();

        // saat toggle sidebar
        const toggleBtn = document.querySelector('.sidebartoggler');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                setTimeout(adjustLogo, 200); // delay supaya class mini-sidebar update dulu
            });
        }
    });
    </script>


    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <nav class="sidebar-nav" style="min-height:100vh; padding-top:1rem;">
            <ul id="sidebarnav" class="pt-3" style="list-style:none; padding:0; margin:0;">

                <!-- Dashboard -->
                <li class="sidebar-item {{ request()->routeIs('backend.beranda') ? 'active' : '' }}">
                    <a class="sidebar-link d-flex align-items-center" href="{{ route('backend.beranda') }}" 
                    style="padding:8px 12px; border-radius:8px; font-size:0.9rem; font-weight:500; color:#111010ff; text-decoration:none;">
                        <i class="mdi mdi-view-dashboard me-2 text-white"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <!-- Notifikasi -->
                @if(auth()->check() && in_array(auth()->user()->role, [0,1,2]))
                <li class="sidebar-item">
                    <a href="{{ route('backend.notification.index') }}" 
                    class="sidebar-link d-flex align-items-center" 
                    style="padding:8px 12px; border-radius:8px; font-size:0.9rem; font-weight:500; color:#fff; text-decoration:none; position: relative;">
                        
                        <i class="mdi mdi-bell-ring me-2 text-white" style="position: relative;">
                            @php
                                $unreadCount = \App\Models\Notification::where('user_id', auth()->user()->id)
                                    ->where('is_read',0)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span style="
                                    position: absolute;
                                    top: -6px;   /* geser ke atas icon */
                                    right: -6px; /* geser ke kanan icon */
                                    background:red; 
                                    color:#fff; 
                                    font-size:10px; 
                                    width:18px; 
                                    height:18px; 
                                    display:inline-flex; 
                                    align-items:center; 
                                    justify-content:center; 
                                    border-radius:50%;
                                ">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </i>

                        <span class="hide-menu"> Notifikasi</span>
                    </a>
                </li>
                @endif

                <!-- Manajemen User (Admin Only) -->
                @if(auth()->check() && in_array(auth()->user()->role, [0,1,2]))
                    <li class="sidebar-item {{ request()->routeIs('backend.user.*') ? 'active' : '' }}">
                        <a class="sidebar-link d-flex align-items-center" href="{{ route('backend.user.index') }}" 
                        style="padding:8px 12px; border-radius:8px; font-size:0.9rem; font-weight:500; color:#fff; text-decoration:none;">
                            <i class="mdi mdi-account me-2 text-white"></i>
                            <span class="hide-menu">Employee</span>
                        </a>
                    </li>
                @endif

                <!-- Manajemen Asset -->
                @if(auth()->check() && in_array(auth()->user()->role, [0,1,2]))
                <li class="sidebar-item">
                    <a href="{{ route('backend.asset.index') }}" 
                    class="sidebar-link d-flex align-items-center" style="padding:6px 10px; font-size:0.85rem; color:#fff;">
                        <i class="mdi mdi-database me-2 text-white"></i>
                        <span class="hide-menu">Assets</span>
                    </a>
                </li>
                    
                <!-- Manajemen Asset -->
                {{--
                <li class="sidebar-item has-arrow">
                    <a class="sidebar-link d-flex align-items-center" href="javascript:void(0)" 
                        style="padding:8px 12px; border-radius:8px; font-size:0.9rem; font-weight:500; color:#fff; text-decoration:none;">
                        <i class="mdi mdi-database me-2 text-warning"></i>
                        <span class="hide-menu">Assets</span>
                    </a>
                    <ul class="collapse first-level ps-3" style="list-style:none;">
                        <li class="sidebar-item">
                            <a href="{{ route('backend.asset.import.form') }}" 
                                class="sidebar-link d-flex align-items-center" style="padding:6px 10px; font-size:0.85rem; color:#fff;">
                                <i class="mdi mdi-file-import me-2 text-warning"></i>
                                <span class="hide-menu">Import Asset</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('backend.asset.index') }}" 
                            class="sidebar-link d-flex align-items-center" style="padding:6px 10px; font-size:0.85rem; color:#fff;">
                                <i class="mdi mdi-format-list-bulleted me-2 text-warning"></i>
                                <span class="hide-menu">Daftar Asset</span>
                            </a>
                        </li>
                    </ul>
                </li>
                --}}
                @endif

                <!-- Period Garansi -->
                <li class="sidebar-item {{ request()->routeIs('backend.asset.period-garansi') ? 'active' : '' }}">
                    <a href="{{ route('backend.asset.period-garansi') }}" 
                    class="sidebar-link d-flex align-items-center"
                    style="padding:8px 12px; border-radius:8px; font-size:0.9rem; font-weight:500; color:#fff; text-decoration:none;">
                        <i class="fas fa-clock me-2 text-white" style="font-size: 1.2rem;"></i>
                        <span class="hide-menu">Period Garansi</span>
                    </a>
                </li>

                <!-- Menu untuk role staff -->
                @if(auth()->check() && in_array(auth()->user()->role, [3]))
                <li class="sidebar-item {{ request()->routeIs('backend.beranda') ? 'active' : '' }}">
                    <a href="{{ route('backend.asset.index') }}" 
                        class="sidebar-link d-flex align-items-center" style="padding:6px 10px; font-size:0.85rem; color:#fff;">
                         <i class="mdi mdi-database me-2 text-white"></i>
                        <span class="hide-menu">Assets</span>
                    </a>
                </li>
                @endif

                <!-- Maintanance -->
                <li class="sidebar-item">
                    <a href="{{ route('backend.asset-maintenance.index') }}" 
                    class="sidebar-link d-flex align-items-center" 
                    style="padding:8px 12px; border-radius:8px; font-size:0.9rem; font-weight:500; color:#fff; text-decoration:none;">
                    
                        {{-- Konten utama (icon + text) --}}
                        <span class="d-flex align-items-center" style="gap:6px; position: relative;">
                            <i class="mdi mdi-wrench text-white" style="position: relative;">
                                @php
                                    $user = auth()->user();

                                    $urgentQuery = \App\Models\AssetMaintenance::whereIn('priority', ['Top Urgent', 'Urgent', 'Medium', 'Low'])
                                                        ->where('status', 'pending');

                                    // Filter asset sesuai role user
                                    switch ($user->role) {
                                        case 1: // IT
                                            $urgentQuery->whereHas('asset', function($q) {
                                                $q->where('owner_role', 'it');
                                            });
                                            break;
                                        case 2: // GA
                                            $urgentQuery->whereHas('asset', function($q) {
                                                $q->where('owner_role', 'ga');
                                            });
                                            break;
                                        case 0: case 3: // Super Admin + Staff
                                        default:
                                            break;
                                    }

                                    $urgentCount = $urgentQuery->count();
                                @endphp

                                @if($urgentCount > 0)
                                    <span style="
                                        position: absolute;
                                        top: -6px;
                                        right: -6px;
                                        background:red; 
                                        color:#fff; 
                                        font-size:10px; 
                                        width:18px; 
                                        height:18px; 
                                        display:inline-flex; 
                                        align-items:center; 
                                        justify-content:center; 
                                        border-radius:50%;
                                    ">
                                        {{ $urgentCount }}
                                    </span>
                                @endif
                            </i>
                            <span class="hide-menu">Maintenance</span>
                        </span>
                    </a>
                </li>

                <!-- Ticket -->
                @php
                $user = auth()->user();

                // Status yang dihitung sebagai pending
                $pendingStatuses = ['Open', 'In Progress', 'Troubleshoot', 'Under Maintenance', 'Escalated'];

                // 1️⃣ Hitung Asset Ticket (Ticket)
                $assetTicketQuery = \App\Models\Ticket::whereIn('status', $pendingStatuses);
                switch ($user->role) {
                    case 1: // IT
                        $assetTicketQuery->whereHas('asset', fn($q) => $q->where('owner_role', 'it'));
                        break;
                    case 2: // GA
                        $assetTicketQuery->whereHas('asset', fn($q) => $q->where('owner_role', 'ga'));
                        break;
                }
                $assetTicketCount = $assetTicketQuery->count();

                // 2️⃣ Hitung Service Items (NonAssetTicket)
                $serviceItemQuery = \App\Models\NonAssetTicket::whereIn('status', $pendingStatuses);
                switch ($user->role) {
                    case 1: 
                        $serviceItemQuery->whereHas('asset', fn($q) => $q->where('owner_role', 'it'));
                        break;
                    case 2: 
                        $serviceItemQuery->whereHas('asset', fn($q) => $q->where('owner_role', 'ga'));
                        break;
                }
                $serviceItemCount = $serviceItemQuery->count();

                // 3️⃣ Total notif untuk Ticket parent
                $totalTicketNotif = $assetTicketCount + $serviceItemCount;
                @endphp


                <!-- Ticket Parent -->
                <li class="sidebar-item has-arrow">
                    <a class="sidebar-link d-flex align-items-center" style="padding:8px 12px; border-radius:8px; font-size:0.9rem; font-weight:500; color:#fff; text-decoration:none;">
                        <i class="mdi mdi-ticket-account text-white me-2" style="position: relative;">
                            @if($totalTicketNotif > 0)
                                <span style="position:absolute; top:-6px; right:-6px; background:red; color:#fff; font-size:10px; width:18px; height:18px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%;">
                                    {{ $totalTicketNotif }}
                                </span>
                            @endif
                        </i>
                        <span class="hide-menu">Ticket</span>
                    </a>

                    <ul class="collapse first-level ps-3" style="list-style:none;">
                        <!-- Asset Ticket -->
                        <li class="sidebar-item">
                            <a href="{{ route('backend.ticket.index') }}" class="sidebar-link d-flex align-items-center" style="padding:6px 10px; font-size:0.85rem; color:#fff;">
                                <i class="mdi mdi-desktop-mac text-white me-2" style="position: relative;">
                                    @if($assetTicketCount > 0)
                                        <span style="position:absolute; top:-6px; right:-6px; background:red; color:#fff; font-size:10px; width:16px; height:16px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%;">
                                            {{ $assetTicketCount }}
                                        </span>
                                    @endif
                                </i>
                                <span class="hide-menu">Asset Ticket</span>
                            </a>
                        </li>

                        <!-- Service Items -->
                        <li class="sidebar-item">
                            <a href="{{ route('backend.nonassetticket.index') }}" class="sidebar-link d-flex align-items-center" style="padding:6px 10px; font-size:0.85rem; color:#fff;">
                                <i class="mdi mdi-file-document-edit text-white me-2" style="position: relative;">
                                    @if($serviceItemCount > 0)
                                        <span style="position:absolute; top:-6px; right:-6px; background:red; color:#fff; font-size:10px; width:16px; height:16px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%;">
                                            {{ $serviceItemCount }}
                                        </span>
                                    @endif
                                </i>
                                <span class="hide-menu">Service Items</span>
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- History -->
                @if(auth()->check() && in_array(auth()->user()->role, [0,1,2]))
                <li class="sidebar-item">
                    <a href="{{ route('backend.asset-history.index') }}" 
                    class="sidebar-link d-flex align-items-center" 
                    style="padding:6px 10px; font-size:0.85rem; color:#fff;">
                        <i class="mdi mdi-history me-2 text-white"></i>
                        <span class="hide-menu">History</span>
                    </a>
                </li>
                @endif

                {{-- 
                <!-- Data Master Asset -->
                <li class="sidebar-item has-arrow">
                    <a class="sidebar-link d-flex align-items-center" href="javascript:void(0)" 
                    style="padding:8px 12px; border-radius:8px; font-size:0.9rem; font-weight:500; color:#fff; text-decoration:none;">
                        <i class="mdi mdi-folder-multiple-outline me-2 text-white"></i>
                        <span class="hide-menu">Asset Settings</span>
                    </a>
                    <ul class="collapse first-level ps-3" style="list-style:none;">
                        <li class="sidebar-item">
                            <a href="{{ route('backend.kategori.index') }}" 
                            class="sidebar-link d-flex align-items-center" style="padding:6px 10px; font-size:0.85rem; color:#fff;">
                                <!-- Icon sesuai kategori -->
                                <i class="mdi mdi-tag-outline me-2 text-warning"></i> <!-- contoh default -->
                                <span class="hide-menu">Category</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('backend.typeasset.index') }}" 
                            class="sidebar-link d-flex align-items-center" style="padding:6px 10px; font-size:0.85rem; color:#fff;">
                                <!-- Icon sesuai type asset -->
                                <i class="mdi mdi-laptop me-2 text-warning"></i> <!-- contoh untuk IT asset -->
                                <span class="hide-menu">Type Asset</span>
                            </a>
                        </li>
                    </ul>
                </li>
                --}}

                <li class="sidebar-item has-arrow">
                    <a class="sidebar-link d-flex align-items-center has-arrow" href="javascript:void(0)" 
                    style="padding:8px 12px; border-radius:8px; font-size:0.9rem; font-weight:500; color:#fff; text-decoration:none;">
                        <i class="mdi mdi-domain me-2 text-white"></i> 
                        <span class="hide-menu"> Business Unit</span>
                    </a>
                    <ul class="collapse first-level ps-3" style="list-style:none;">
                        @php $companies = ['AKM','SMM','AKD','BPN','LIN','AGI','ADL','CMT','BDM']; @endphp
                        @foreach($companies as $company)
                            <li class="sidebar-item">
                                <a href="{{ route('backend.asset.perusahaan', $company) }}" 
                                class="sidebar-link d-flex align-items-center" style="padding:6px 10px; font-size:0.85rem; color:#fff;">
                                    <i class="mdi mdi-office-building me-2 text-white"></i>{{ $company }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <!-- Laporan -->
                @php
                // Hitung total pending dari semua tipe dokumen
                $pendingCounts = [
                    'Permintaan Asset IT' => \App\Models\AssetRequest::where('status', 'pending approval')->count(),
                    'Serah Terima Asset IT' => \App\Models\AssetHandoverForm::where('status', 'pending approval')->count(),
                    'Peralihan Asset IT' => \App\Models\AssetTransfer::where('status', 'pending approval')->count(),
                    'Working Order' => \App\Models\WorkingOrder::where('status', 'pending approval')->count(),
                    'Readiness/Kesiapan Instalasi' => \App\Models\InstallReadyForm::where('status', 'pending approval')->count(),
                    'Finding' => \App\Models\Finding::where('status', 'pending approval')->count(),
                    'Permintaan Perbaikan Perangkat IT (F3PIT)' => \App\Models\F3pit::where('status', 'pending approval')->count(),
                    'Permintaan Login Email / Internet' => \App\Models\LoginRequest::where('status', 'pending approval')->count(),
                    'Memo' => \App\Models\Memo::where('status', 'pending approval')->count(),
                ];

                // Total notif untuk parent menu Documents
                $totalDocumentsNotif = array_sum($pendingCounts);
                @endphp

                <!-- Laporan / Documents -->
                <li class="sidebar-item {{ request()->routeIs('backend.asset-handover.index') ? 'active' : '' }}">
                    <a href="{{ route('backend.asset-handover.index') }}" 
                        class="sidebar-link d-flex align-items-center" style="padding:6px 10px; font-size:0.85rem; color:#fff;">
                        <i class="mdi mdi-file-multiple me-2 text-white" style="position: relative;">
                            @if($totalDocumentsNotif > 0)
                                <span style="
                                    position: absolute;
                                    top: -6px;
                                    right: -6px;
                                    background:red; 
                                    color:#fff; 
                                    font-size:10px; 
                                    width:18px; 
                                    height:18px; 
                                    display:inline-flex; 
                                    align-items:center; 
                                    justify-content:center; 
                                    border-radius:50%;
                                ">
                                    {{ $totalDocumentsNotif }}
                                </span>
                            @endif
                        </i>
                        <span class="hide-menu">Documents</span>
                    </a>
                </li>

                <!-- Settings -->
                @if(auth()->check() && in_array(auth()->user()->role, [0,1,2]))
                    <li class="sidebar-item {{ request()->routeIs('backend.settings.*') ? 'active' : '' }}">
                        <a class="sidebar-link d-flex align-items-center" 
                        href="{{ route('backend.settings.index') }}" 
                        style="padding:8px 12px; border-radius:8px; font-size:0.9rem; font-weight:500; color:#fff; text-decoration:none;">                    
                            <i class="mdi mdi-cog-outline me-2 text-white"></i>
                            <span class="hide-menu">Settings</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
<!-- End Sidebar navigation -->
</aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                <p style="font-family: Calibri; font-size:14px; font-weight:300; color:#333232ff; letter-spacing:0.4px; text-shadow:0.5px 0.5px 1px rgba(0,0,0,0.15); margin:0;">
                    AMS PT Adijaya Karya Makmur
                </p>
                <!-- Kanan: tanggal -->
                <p style="font-family: Calibri; font-size:14px; font-weight:400; color:#333232ff; letter-spacing:0.4px; text-shadow:0.5px 0.5px 1px rgba(0,0,0,0.15); margin:0;">
                    {{ \Carbon\Carbon::now()->format('d M Y') }}
                </p>
            </div>

            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('backend/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('backend/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('backend/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('backend/libs/perfect-scrollbar/dist/perfectscrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('backend/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects-->
    <script src="{{ asset('backend/dist/js/waves.js') }}"></script>
    <!--Menu sidebar-->
    <script src="{{ asset('backend/dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript-->
    <script src="{{ asset('backend/dist/js/custom.min.js') }}"></script>

    <!-- DataTable JS -->
    <script src="{{ asset('backend/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
    <script src="{{ asset('backend/extra-libs/DataTables/datatables.min.js') }}"></script>
    <script>
        /****************************************
         *       Basic Table                   *
         ****************************************/
        $('#zero_config').DataTable();
    </script>

    <!-- form keluar app -->
    <form id="keluar-app" action="{{ route('backend.logout') }}" method="POST" class="d-none">
        @csrf
    </form>
    <!-- FORM APP KELUAR END-->
     
    <!-- SweetAlert -->
<script src="{{ asset('sweetalert/sweetalert2.all.min.js') }}"></script>
<!-- End SweetAlert -->

<!-- Konfirmasi Success -->
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}"
    });
</script>
@endif
<!-- End Konfirmasi Success -->

<script type="text/javascript">
    // Konfirmasi delete
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        var konfdelete = $(this).data("konf-delete");
        event.preventDefault();

        Swal.fire({
            title: 'Konfirmasi Hapus Data!',
            html: "Apakah Anda yakin ingin menghapus data <strong>" + konfdelete + "</strong>?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ccc310ff',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, dihapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success')
                    .then(() => {
                        form.submit();
                    });
            }
        });
    });
</script>
  <script>
    function previewFoto() {
      const foto = document.querySelector('input[name="foto"]');
      const fotoPreview = document.querySelector('.foto-preview');
      fotoPreview.style.display = 'block';
      const fotoReader = new FileReader();
      fotoReader.readAsDataURL(foto.files[0]);
      fotoReader.onload = function(fotoEvent) {
        fotoPreview.src = fotoEvent.target.result;
        fotoPreview.style.width = '100%';
      }
    }
  </script>
  <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
  <!-- <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script> -->
  <script>
    ClassicEditor
      .create(document.querySelector('#ckeditor'))
      .catch(error => {
        console.error(error);
      });
  </script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const toggleBtn = document.querySelector('.sidebartoggler');
    const logoIcon = document.querySelector('.navbar-header .logo-icon');
    const logoText = document.querySelector('.navbar-header .logo-text');
    const navbarHeader = document.querySelector('.navbar-header');

    function applySidebarState() {
        if (body.classList.contains('mini-sidebar')) {
            logoIcon.style.height = '30px';
            logoText.style.opacity = '0';
            logoText.style.width = '0';
            logoText.style.overflow = 'hidden';
            navbarHeader.style.height = '50px';
        } else {
            logoIcon.style.height = '45px';
            logoText.style.opacity = '1';
            logoText.style.width = 'auto';
            logoText.style.overflow = 'visible';
            navbarHeader.style.height = '60px';
        }
    }

    // pas load
    if (localStorage.getItem('sidebar') === 'mini') {
        body.classList.add('mini-sidebar');
    } else {
        body.classList.remove('mini-sidebar');
    }

    applySidebarState();

    // saat toggle
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            body.classList.toggle('mini-sidebar');
            localStorage.setItem('sidebar', body.classList.contains('mini-sidebar') ? 'mini' : 'full');
            applySidebarState();
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const setActiveColor = () => {
        document.querySelectorAll('.left-sidebar .sidebar-item.active > .sidebar-link')
            .forEach(link => {
                link.style.backgroundColor = '#9051f6';
                link.style.color = '#fff';
            });
    };

    // Jalankan pertama kali
    setActiveColor();

    // Pantau perubahan class di sidebar
    const sidebar = document.querySelector('.left-sidebar');
    if(sidebar){
        const observer = new MutationObserver(() => {
            setActiveColor();
        });
        observer.observe(sidebar, { attributes: true, subtree: true, attributeFilter: ['class'] });
    }
});
</script>


@stack('scripts')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<link href="https://cdn.materialdesignicons.com/7.2.96/css/materialdesignicons.min.css" rel="stylesheet">

<!-- js bawaan -->
<script src="{{ asset('js/app.js') }}"></script>

<!-- js tambahan -->
<script src="{{ asset('js/formatting.js') }}"></script>

<!-- Bootstrap 5 bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>