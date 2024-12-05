<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MonitoringStock;

class MonitoringStockController extends Controller
{
    // Constructor untuk middleware yang memastikan hanya user dengan role 'it' yang bisa mengakses
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || !in_array(auth()->user()->role->name, ['it'])) {
                return redirect('/');
            }
            return $next($request);
        });
    }

    public function index()
    {
        // Mengambil data hardware dan consumables berdasarkan spesifikasi_barang
        $hardware = MonitoringStock::where('type_barang', 'HARDWARE')
        ->where(function($query) {
            $query->where('status_transaksi', '0')   // Kondisi status_barang = 0
                  ->orWhereNull('status_transaksi'); // Atau jika status_barang null
        })
        ->select('spesifikasi_barang')
        ->get()
        ->groupBy('spesifikasi_barang'); // Mengelompokkan berdasarkan spesifikasi_barang

        $consumables = MonitoringStock::where('type_barang', 'CONSUMABLE')
                ->where(function($query) {
                    $query->where('status_transaksi', '0')   // Kondisi status_barang = 0
                        ->orWhereNull('status_transaksi'); // Atau jika status_barang null
                })
                ->select('spesifikasi_barang')
                ->get()
                ->groupBy('spesifikasi_barang'); // Mengelompokkan berdasarkan spesifikasi_barang

        // Menghitung jumlah item per grup
        $hardwareCounts = $hardware->map(function($group) {
            return $group->count(); // Menghitung jumlah item dalam setiap grup hardware
        });

        $consumablesCounts = $consumables->map(function($group) {
            return $group->count(); // Menghitung jumlah item dalam setiap grup consumables
        });

        // Mengirimkan data ke view
        return view('dashboard.monitoringstock.index', compact('hardware', 'consumables', 'hardwareCounts', 'consumablesCounts'));
    }


     // Menampilkan halaman Transaksi Scan
     public function transaksi()
     {
         return view('dashboard.monitoringstock.transaksi');
     }

    public function store(Request $request)
    {
        // Validasi input yang diterima
        $validated = $request->validate([
            'type_barang' => 'required|string|in:HARDWARE,CONSUMABLE',
            'spesifikasi_barang' => 'required|string|max:255',
            'barcode' => 'required|string|max:255',
        ]);
    
        // Mencari apakah barcode sudah ada di database
        $existingStock = MonitoringStock::where('barcode', $validated['barcode'])->first();
    
        if ($existingStock) {
            // Jika barcode sudah ada, update status_barang menjadi 1
            $existingStock->update([
                'status_transaksi' => 1,
                'type_barang' => $validated['type_barang'],
                'spesifikasi_barang' => $validated['spesifikasi_barang'],
            ]);
            
            // Mengembalikan ke halaman transaksi dengan pesan sukses
            return redirect()->route('monitoringstock.transaksi')->with('success', 'Status barang berhasil diperbarui!');
        } else {
            // Jika barcode belum ada, simpan data baru dengan status_barang default 0
            MonitoringStock::create([
                'type_barang' => $validated['type_barang'],
                'spesifikasi_barang' => $validated['spesifikasi_barang'],
                'barcode' => $validated['barcode'],
                'status_transaksi' => 0,  // default value
            ]);
            
            // Mengembalikan ke halaman transaksi dengan pesan sukses
            return redirect()->route('monitoringstock.transaksi')->with('success', 'Transaksi scan berhasil disimpan dengan status default 0!');
        }
    }
     

    
}
