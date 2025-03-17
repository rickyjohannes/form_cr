<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItOutput extends Model
{
    use HasFactory;

    protected $connection = 'mysql2'; // Koneksi ke database kedua (po)
    protected $table = 'it_outputs'; // Nama tabel

    protected $fillable = [
        'banfn', 'badat', 'pr_already', 'pr_next', 'ernam', 'erdat',
        'bnfpo', 'matnr1', 'txz011', 'txz02', 'menge1', 'meins1',
        'preis', 'total', 'afnam', 'lifnr', 'mcod1', 'ebeln', 'aedat',
        'ebelp', 'po_already', 'po_next', 'matnr2', 'txz012', 'loekz',
        'menge2', 'meins2', 'netwr', 'waers', 'mblnr', 'grjum', 'grval',
        'belnr', 'budat', 'irjum', 'irval', 'ficlear', 'wrbtr', 'shkzg',
        'xblnr', 'bktxt', 'begrjum', 'begrval', 'beirjum', 'beirval','leadtime_pr',
        'status_pr', 'leadtime_po', 'status_po', 'leadtime_prpo', 'waers_pr'
    ];
}
