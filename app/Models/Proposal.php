<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB; // Tambahkan ini
use Carbon\Carbon;

class Proposal extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'no_transaksi', 'user_id', 'it_user', 'company_code','user_request', 'user_status', 'departement', 
        'ext_phone', 'status_barang', 'kategori', 'facility', 'user_note', 'no_asset_user', 'estimated_start_date',
        'estimated_date','action_it_date', 'it_analys', 'file', 'file_it', 'no_asset', 'status_apr', 
        'actiondate_apr', 'status_cr', 'close_date', 'token', 
        'created_at', 'updated_at','last_notified_at'
    ];

    // Relation Many to One
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Fungsi untuk generate nomor transaksi
    public static function generateNoTransaksi()
    {
        return DB::transaction(function () {
            $prefix = 'CR';
            $date = date('Ymd');
            $time = date('His'); // Format waktu HHMMSS

            // Mengunci tabel untuk mencegah race condition
            $lastProposal = self::whereDate('created_at', now()->toDateString())
                ->orderBy('no_transaksi', 'desc')
                ->lockForUpdate()
                ->first();

            if ($lastProposal) {
                $lastNumber = (int) substr($lastProposal->no_transaksi, -4);
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            // Format nomor transaksi dengan padding 4 digit
            $noTransaksi = $prefix . $date . $time . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            return $noTransaksi;
        });
    }
}
