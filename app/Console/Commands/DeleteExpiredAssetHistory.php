<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AssetHistory;

class DeleteExpiredAssetHistory extends Command
{
    protected $signature = 'history:delete-expired';
    protected $description = 'Hapus otomatis asset history yang sudah melewati tanggal retention';

    public function handle()
    {
        $deleted = AssetHistory::whereNotNull('expires_at')
                    ->where('expires_at', '<=', now())
                    ->delete();

        $this->info("Deleted {$deleted} expired history record(s).");
    }
}
