<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class MonitoringStock extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'monitoring_stock'; // Define the table name explicitly
    protected $fillable = [
        'type_barang','spesifikasi_barang', 'barcode','status_transaksi','keterangan','created_at','updated_at'
    ];

}