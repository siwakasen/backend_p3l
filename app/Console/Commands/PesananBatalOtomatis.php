<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;

class PesananBatalOtomatis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:pesanan-batal-otomatis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status pesanan yang melewati batas waktu pembayaran';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $yesterday = Carbon::yesterday()->toDateString();
        $currentDate = Carbon::now()->toDateString();

        DB::table('pesanan')
            ->where('status_transaksi', 'Pesanan Belum Dibayar')
            ->where(function ($query) {
                $query->whereDate('tanggal_pesanan', '=', Carbon::now()->addDay()->toDateString())
                      ->orWhere('tanggal_pesanan', '<', Carbon::now()->toDateString());
            })
            ->update(['status_transaksi' => 'Pesanan Dibatalkan']);
        
        $this->info('Status pesanan berhasil diupdate.');
        return 0;
    }
}
