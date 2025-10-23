<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    BerandaController,
    KategoriController,
    LoginController,
    AssetController,
    UserController,
    TypeAssetController,
    FixedController,
    AdditionalGoodsController,
    ConsumableGoodsController,
    AssetCodeMappingController,
    AssetImportController,
    AssetHandoverController,
    AssetHandoverFormController,
    AssetTransferController,
    WorkingOrderController,
    AssetRequestController,
    InstallReadyFormController,
    FindingController,
    F3pitController,
    LoginRequestController,
    NotificationController,
    MemoController,
    ForgotPasswordController,
    AssetMaintenanceController,
    AssetHistoryController,
    SettingController,
    TicketController,
    NonAssetTicketController,
};

Route::view('/', 'welcome');

// Tampilkan form login
Route::get('/backend/login', [LoginController::class, 'loginBackend'])->name('backend.login');

// Proses login (POST)
Route::post('/backend/login', [LoginController::class, 'authenticateBackend'])->name('backend.login.process');

// Logout
Route::post('/backend/logout', [LoginController::class, 'logoutBackend'])->name('backend.logout');

// Password
Route::get('/forgot-password', [LoginController::class, 'forgot_password'])->name('forgot-password');
Route::post('/forgot-password-act', [LoginController::class, 'forgot_password_act'])->name('forgot-password-act');

Route::get('/validasi-forgot-password/{token}', [LoginController::class, 'validasi_forgot_password'])->name('validasi-forgot-password');
// Route untuk men-submit reset password
Route::post('/validasi-forgot-password-act', [LoginController::class, 'validasi_forgot_password_act'])
    ->name('validasi-forgot-password-act');

Route::post('/validasi-forgot-password-act', [LoginController::class, 'validasi_forgot_password_act'])
    ->name('backend.password.update'); // beri nama sekali saja

Route::get('asset/template', [AssetImportController::class, 'downloadTemplate'])
    ->name('asset.template');


// =================== ADMIN ===================
Route::middleware(['auth', 'role:0,1,2,3'])->prefix('backend')->name('backend.')->group(function () {
    
    Route::get('beranda', [BerandaController::class, 'berandaBackend'])->name('beranda');

    // User routes + laporan
    Route::resource('user', UserController::class);
    //Route::get('laporan/formuser', [UserController::class, 'formUser'])->name('laporan.formuser');
    //Route::post('laporan/cetakuser', [UserController::class, 'cetakUser'])->name('laporan.cetakuser');

    // Kategori routes + detail
    Route::resource('kategori', KategoriController::class);
    Route::get('kategori/{id}/detail', [KategoriController::class, 'detail'])->name('kategori.detail');

    // Type Asset routes + detail
    Route::resource('typeasset', TypeAssetController::class);
    Route::get('typeasset/{id}/detail', [TypeAssetController::class, 'detail'])->name('typeasset.detail');

    // Asset routes + import + laporan
    Route::get('asset/daftar/{company}', [AssetController::class, 'daftarPerusahaan'])
    ->name('asset.daftar');
    Route::get('asset/grafik/{company}', [AssetController::class, 'grafikPerusahaan'])
    ->name('asset.grafik');
    Route::get('asset/import', [AssetImportController::class, 'form'])->name('asset.import.form');
    Route::post('asset/import', [AssetImportController::class, 'import'])->name('asset.import');

    Route::get('asset/export', [AssetController::class, 'export'])->name('asset.export');

    // Route untuk daftar asset per perusahaan
    Route::get('asset/perusahaan/{company}', [AssetController::class, 'daftarPerusahaan'])
        ->name('asset.daftarPerusahaan');

    // Route untuk grafik asset per perusahaan
    Route::get('asset/perusahaan/{company}', [AssetController::class, 'grafikPerusahaan'])
        ->name('asset.grafikPerusahaan');

    // Route untuk daftar asset dan grafik (pakai query tab)
    Route::get('asset/perusahaan/{company}', [AssetController::class, 'perusahaan'])
        ->name('asset.perusahaan');

    Route::get('asset/perusahaan/{company}/tab/{tab}', [AssetController::class, 'tabContent'])
    ->name('asset.perusahaan.tab'); // Untuk load tab via Ajax


    Route::get('/asset/akm/{item}', [AssetController::class, 'akmByItem'])
        ->name('asset.akmByItem');

    Route::get('/asset/period-garansi', [AssetController::class, 'periodGaransi'])
        ->name('asset.period-garansi');

    // Route untuk create service / non-physical
    Route::get('asset/create-service', [AssetController::class, 'createService'])
        ->name('asset.create_service');

    // Edit
    Route::get('asset/{id}/edit-service', [AssetController::class, 'editService'])
        ->name('asset.edit_service');

    // Show
    Route::get('asset/{id}/show-service', [AssetController::class, 'showService'])
        ->name('asset.show_service');

    Route::resource('asset', AssetController::class);

    // Ticket routes
    Route::get('/get-asset/{kategori_id}', [TicketController::class, 'getAssetByKategori']);
    Route::get('ticket/{id}/cetak', [TicketController::class, 'cetakTicket'])
        ->name('ticket.cetak');
    Route::resource('ticket', TicketController::class);

    // Non-Asset Ticket routes
    Route::get('nonassetticket/{id}/cetak', [NonAssetTicketController::class, 'cetakNonAssetTicket'])
        ->name('nonassetticket.cetak');
    Route::resource('nonassetticket', NonAssetTicketController::class);

    Route::post('foto-asset/store', [AssetController::class, 'storeFoto'])->name('foto_asset.store');
    Route::delete('foto-asset/{id}', [AssetController::class, 'destroyFoto'])->name('foto_asset.destroy');

    Route::get('laporan/formasset', [AssetController::class, 'formAsset'])->name('laporan.formasset');
    Route::post('laporan/cetakasset', [AssetController::class, 'cetakAsset'])->name('laporan.cetakasset');

    // fixed routes + detail
    Route::resource('fixed', FixedController::class);
    Route::get('fixed/{id}/detail', [FixedController::class, 'detail'])->name('fixed.detail');

    // Additional Goods routes + detail
    Route::resource('additionalgoods', AdditionalGoodsController::class);
    Route::get('additionalgoods/{id}/detail', [AdditionalGoodsController::class, 'detail'])->name('additionalgoods.detail');

    // Consumable Goods routes + detail
    Route::resource('consumablegoods', ConsumableGoodsController::class);
    Route::get('consumablegoods/{id}/detail', [ConsumableGoodsController::class, 'detail'])->name('consumablegoods.detail');

    // Asset Handover (daftar formulir)
    Route::resource('asset-handover', AssetHandoverController::class);
    Route::get('asset-handover/{id}/buat', [AssetHandoverController::class, 'buat'])
        ->name('asset_handover.buat');
    Route::get('laporan/formassethandover', [AssetHandoverController::class, 'formAssetHandover'])
        ->name('laporan.formassethandover');
    Route::post('laporan/cetakassethandover', [AssetHandoverController::class, 'cetakAssetHandover'])
        ->name('laporan.cetakassethandover');

    // Asset Handover Forms (detail, cetak, create form, dll)
    Route::resource('assethandoverforms', AssetHandoverFormController::class);
    Route::get('assethandoverforms/{id}/cetakassethandover', [AssetHandoverFormController::class, 'cetakAssetHandover'])
        ->name('assethandoverforms.cetak');
    Route::get('assethandoverforms/{id}/cetak-safe', [AssetHandoverFormController::class, 'cetakSafe'])
        ->name('assethandoverforms.cetak.safe');

    // Asset Transfer Forms (detail, cetak, create form, dll)
    Route::resource('assettransfer', AssetTransferController::class);
    Route::get('assettransfer/{id}/cetakassettransfer', [AssetTransferController::class, 'cetakAssetTransfer'])
        ->name('assettransfer.cetak');
    Route::get('assettransfer/{id}/cetak-safe', [AssetTransferController::class, 'cetakSafe'])
        ->name('assettransfer.cetak.safe');

    // Working Order (detail, cetak, create form, dll)
    Route::resource('workingorder', WorkingOrderController::class);
    Route::get('workingorder/{id}/cetakworkingorder', [WorkingOrderController::class, 'cetakWorkingOrder'])
        ->name('workingorder.cetak');
    Route::get('workingorder/{id}/cetak-safe', [WorkingOrderController::class, 'cetakSafe'])
        ->name('workingorder.cetak.safe');

    // Asset Request (detail, cetak, create form, dll)
    Route::resource('assetrequest', AssetRequestController::class);
    Route::get('assetrequest/{id}/cetakassetrequest', [AssetRequestController::class, 'cetakAssetRequest'])
        ->name('assetrequest.cetak');
    Route::get('assetrequest/{id}/cetak-safe', [AssetRequestController::class, 'cetakSafe'])
        ->name('assetrequest.cetak.safe');

    // Install Ready Form (CRUD + Cetak)
    Route::resource('installreadyform', InstallReadyFormController::class);
    Route::get('installreadyform/{id}/cetakinstallready', [InstallReadyFormController::class, 'cetakInstallReady'])
        ->name('installreadyform.cetak');
    Route::get('installreadyform/{id}/cetak-safe', [InstallReadyFormController::class, 'cetakSafe'])
        ->name('installreadyform.cetak.safe');

    // Install Ready Form (CRUD + Cetak)
    Route::resource('finding', FindingController::class);
    Route::get('finding/{id}/cetakfinding', [FindingController::class, 'cetakFinding'])
        ->name('finding.cetak'); // route untuk cetak PDF Finding Form
    Route::get('finding/{id}/cetak-safe', [FindingController::class, 'cetakSafe'])
        ->name('finding.cetak.safe');

    // Memo Form (CRUD + Cetak)
    Route::resource('memo', MemoController::class);
    Route::get('memo/{id}/cetakmemo', [MemoController::class, 'cetakMemo'])
        ->name('memo.cetak');
    Route::get('memo/{id}/cetak-safe', [MemoController::class, 'cetakSafe'])
        ->name('memo.cetak.safe');

    // F3PIT (CRUD + Cetak)
    Route::resource('f3pit', F3pitController::class);
    Route::get('f3pit/{id}/cetakf3pit', [F3pitController::class, 'cetakF3pit'])
        ->name('f3pit.cetak'); // route untuk cetak PDF F3PIT
    Route::get('f3pit/{id}/cetak-safe', [F3pitController::class, 'cetakSafe'])
        ->name('f3pit.cetak.safe');

    // Login Request (CRUD + Cetak)
    Route::resource('loginrequest', LoginRequestController::class);
    Route::get('loginrequest/{id}/cetakloginrequest', [LoginRequestController::class, 'cetakLoginRequest'])
        ->name('loginrequest.cetak'); // route untuk cetak PDF Login Request
    Route::get('loginrequest/{id}/cetak-safe', [LoginRequestController::class, 'cetakSafe'])
        ->name('loginrequest.cetak.safe');

    // Notifikasi
    Route::resource('notification', NotificationController::class)
        ->middleware(['auth', 'role:0,1,2']); // hanya super_admin + admin IT/GA

    // User/admin bisa buka detail notifikasi (tanpa middleware role)
    Route::get('/notification/read/{id}', [NotificationController::class, 'read'])
        ->name('notification.read')
        ->middleware('auth');

    // Hapus semua notifikasi (user & admin boleh)
    Route::delete('/notifications/clear', [NotificationController::class, 'clear'])
        ->name('notification.clear')
        ->middleware('auth');

    Route::post('/notifications/clear-all', [NotificationController::class, 'clearAll'])
     ->name('notification.clearAll');

    //ASSET HANDOVER
    Route::prefix('asset-handover')->group(function () {
    Route::get('serah-terima', [AssetHandoverController::class, 'create'])->name('create');
    Route::post('store', [AssetHandoverController::class, 'store'])->name('store');
    Route::get('cetak/{id}', [AssetHandoverController::class, 'cetak'])->name('cetak');  
    });

    // Asset Maintenance
    Route::resource('asset-maintenance', AssetMaintenanceController::class);
    Route::get('asset-maintenance/asset/{id}', [AssetMaintenanceController::class, 'getAsset'])->name('asset-maintenance.getAsset');
    // Kalau mau ada cetak PDF / export bisa ditambah:
    Route::get('asset-maintenance/{id}/cetak', [AssetMaintenanceController::class, 'cetak'])
        ->name('asset-maintenance.cetak');

    Route::resource('asset-history', AssetHistoryController::class);
    
    // Hapus satu history (tombol sampah)
    Route::delete('/asset-history/{assetHistory}', [AssetHistoryController::class, 'destroy'])
        ->name('asset-history.destroy');

    // Global retention: terapkan untuk semua history
    Route::post('/asset-history/apply-retention', [AssetHistoryController::class, 'applyRetention'])
        ->name('asset-history.applyRetention');

    //Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/retention', [SettingController::class, 'applyRetention'])->name('settings.applyRetention');

});









// Route::middleware('auth')->prefix('backend')->name('backend.')->group(function () {

//     Route::get('beranda', [BerandaController::class, 'berandaBackend'])->name('beranda');

//     // User routes + laporan
//     Route::resource('user', UserController::class);
//     Route::get('laporan/formuser', [UserController::class, 'formUser'])->name('laporan.formuser');
//     Route::post('laporan/cetakuser', [UserController::class, 'cetakUser'])->name('laporan.cetakuser');

//     // Kategori routes + detail
//     Route::resource('kategori', KategoriController::class);
//     Route::get('kategori/{id}/detail', [KategoriController::class, 'detail'])->name('kategori.detail');

//     // Type Asset routes + detail
//     Route::resource('typeasset', TypeAssetController::class);
//     Route::get('typeasset/{id}/detail', [TypeAssetController::class, 'detail'])->name('typeasset.detail');

//     // Asset routes + import + laporan
//     Route::get('asset/daftar/{company}', [AssetController::class, 'daftarPerusahaan'])
//     ->name('asset.daftar');
//     Route::get('asset/grafik/{company}', [AssetController::class, 'grafikPerusahaan'])
//     ->name('asset.grafik');
//     Route::get('asset/import', [AssetImportController::class, 'form'])->name('asset.import.form');
//     Route::post('asset/import', [AssetImportController::class, 'import'])->name('asset.import');
//     Route::resource('asset', AssetController::class);

//     Route::post('foto-asset/store', [AssetController::class, 'storeFoto'])->name('foto_asset.store');
//     Route::delete('foto-asset/{id}', [AssetController::class, 'destroyFoto'])->name('foto_asset.destroy');

//     Route::get('laporan/formasset', [AssetController::class, 'formAsset'])->name('laporan.formasset');
//     Route::post('laporan/cetakasset', [AssetController::class, 'cetakAsset'])->name('laporan.cetakasset');

//     // Device routes + detail
//     Route::resource('device', DeviceController::class);
//     Route::get('device/{id}/detail', [DeviceController::class, 'detail'])->name('device.detail');

//     // Additional Goods routes + detail
//     Route::resource('additionalgoods', AdditionalGoodsController::class);
//     Route::get('additionalgoods/{id}/detail', [AdditionalGoodsController::class, 'detail'])->name('additionalgoods.detail');

//     // Consumable Goods routes + detail
//     Route::resource('consumablegoods', ConsumableGoodsController::class);
//     Route::get('consumablegoods/{id}/detail', [ConsumableGoodsController::class, 'detail'])->name('consumablegoods.detail');

//     // Asset Handover (daftar formulir)
//     Route::resource('asset-handover', AssetHandoverController::class);
//     Route::get('asset-handover/{id}/buat', [AssetHandoverController::class, 'buat'])
//         ->name('asset_handover.buat');
//     Route::get('laporan/formassethandover', [AssetHandoverController::class, 'formAssetHandover'])
//         ->name('laporan.formassethandover');
//     Route::post('laporan/cetakassethandover', [AssetHandoverController::class, 'cetakAssetHandover'])
//         ->name('laporan.cetakassethandover');

//     // Asset Handover Forms (detail, cetak, create form, dll)
//     Route::resource('assethandoverforms', AssetHandoverFormController::class);
//     Route::get('assethandoverforms/{id}/cetakassethandover', [AssetHandoverFormController::class, 'cetakAssetHandover'])
//         ->name('assethandoverforms.cetak');
//     Route::get('assethandoverforms/{id}/cetak-safe', [AssetHandoverFormController::class, 'cetakSafe'])
//         ->name('assethandoverforms.cetak.safe');

//     // Asset Transfer Forms (detail, cetak, create form, dll)
//     Route::resource('assettransfer', AssetTransferController::class);
//     Route::get('assettransfer/{id}/cetakassettransfer', [AssetTransferController::class, 'cetakAssetTransfer'])
//         ->name('assettransfer.cetak');
//     Route::get('assettransfer/{id}/cetak-safe', [AssetTransferController::class, 'cetakSafe'])
//         ->name('assettransfer.cetak.safe');

//     // Working Order (detail, cetak, create form, dll)
//     Route::resource('workingorder', WorkingOrderController::class);
//     Route::get('workingorder/{id}/cetakworkingorder', [WorkingOrderController::class, 'cetakWorkingOrder'])
//         ->name('workingorder.cetak');
//     Route::get('workingorder/{id}/cetak-safe', [WorkingOrderController::class, 'cetakSafe'])
//         ->name('workingorder.cetak.safe');

//     // Asset Request (detail, cetak, create form, dll)
//     Route::resource('assetrequest', AssetRequestController::class);
//     Route::get('assetrequest/{id}/cetakassetrequest', [AssetRequestController::class, 'cetakAssetRequest'])
//         ->name('assetrequest.cetak');
//     Route::get('assetrequest/{id}/cetak-safe', [AssetRequestController::class, 'cetakSafe'])
//         ->name('assetrequest.cetak.safe');

//     // Install Ready Form (CRUD + Cetak)
//     Route::resource('installreadyform', InstallReadyFormController::class);
//     Route::get('installreadyform/{id}/cetakinstallready', [InstallReadyFormController::class, 'cetakInstallReady'])
//         ->name('installreadyform.cetak');
//     Route::get('installreadyform/{id}/cetak-safe', [InstallReadyFormController::class, 'cetakSafe'])
//         ->name('installreadyform.cetak.safe');

//     // Install Ready Form (CRUD + Cetak)
//     Route::resource('finding', FindingController::class);
//     Route::get('finding/{id}/cetakfinding', [FindingController::class, 'cetakFinding'])
//         ->name('finding.cetak'); // route untuk cetak PDF Finding Form
//     Route::get('finding/{id}/cetak-safe', [FindingController::class, 'cetakSafe'])
//         ->name('finding.cetak.safe');

//     // F3PIT (CRUD + Cetak)
//     Route::resource('f3pit', F3pitController::class);
//     Route::get('f3pit/{id}/cetakf3pit', [F3pitController::class, 'cetakF3pit'])
//         ->name('f3pit.cetak'); // route untuk cetak PDF F3PIT
//     Route::get('f3pit/{id}/cetak-safe', [F3pitController::class, 'cetakSafe'])
//         ->name('f3pit.cetak.safe');

//     // Login Request (CRUD + Cetak)
//     Route::resource('loginrequest', LoginRequestController::class);
//     Route::get('loginrequest/{id}/cetakloginrequest', [LoginRequestController::class, 'cetakLoginRequest'])
//         ->name('loginrequest.cetak'); // route untuk cetak PDF Login Request
//     Route::get('loginrequest/{id}/cetak-safe', [LoginRequestController::class, 'cetakSafe'])
//         ->name('loginrequest.cetak.safe');
    
    //    Route::prefix('asset-handover')->group(function () {
    //     Route::get('serah-terima', [AssetHandoverController::class, 'create'])->name('create');
    //     Route::post('store', [AssetHandoverController::class, 'store'])->name('store');
    //     Route::get('cetak/{id}', [AssetHandoverController::class, 'cetak'])->name('cetak');  
    //     });

    // Route::resource('asset_code_mappings', AssetCodeMappingController::class)->names([
    // 'index' => 'asset_code_mappings.index',
    // 'create' => 'asset_code_mappings.create',
    // 'store' => 'asset_code_mappings.store',
    // 'edit' => 'asset_code_mappings.edit',
    // 'update' => 'asset_code_mappings.update',
    // 'destroy' => 'asset_code_mappings.destroy',
    // ]);