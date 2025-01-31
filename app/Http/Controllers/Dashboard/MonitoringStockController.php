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
        $monitoringstock = MonitoringStock::get();
        // Mengambil data hardware dan consumables berdasarkan spesifikasi_barang
        $hardware = MonitoringStock::where('type_barang', 'HARDWARE')
            ->select('spesifikasi_barang', 'status_transaksi') // Mengambil spesifikasi_barang dan status_transaksi
            ->get()
            ->groupBy('spesifikasi_barang'); // Mengelompokkan berdasarkan spesifikasi_barang

        $consumables = MonitoringStock::where('type_barang', 'CONSUMABLE')
            ->select('spesifikasi_barang', 'status_transaksi') // Mengambil spesifikasi_barang dan status_transaksi
            ->get()
            ->groupBy('spesifikasi_barang'); // Mengelompokkan berdasarkan spesifikasi_barang

        // Menghitung jumlah item untuk hardware berdasarkan spesifikasi_barang
        $hardwareCounts = $hardware->map(function ($group) {
            // Memeriksa apakah ada item dengan status_transaksi = 0 dalam grup ini
            $hasStatusTransaksi0 = $group->contains(function ($item) {
                return $item->status_transaksi == 0;
            });

            // Memeriksa apakah ada item dengan status_transaksi = 1 dalam grup ini
            $hasStatusTransaksi1 = $group->contains(function ($item) {
                return $item->status_transaksi == 1;
            });

            // Jika ada status_transaksi = 0, seluruh grup dihitung dan qty dihitung berdasarkan jumlah data dengan status_transaksi = 0
            if ($hasStatusTransaksi0) {
                // Menghitung jumlah data dengan status_transaksi = 0
                return $group->filter(function ($item) {
                    return $item->status_transaksi == 0;
                })->count(); // Menghitung jumlah item dengan status_transaksi = 0
            }

            // Jika tidak ada status_transaksi = 0, maka qty default adalah 0
            if (!$hasStatusTransaksi1) {
                return 0; // Jika tidak ada status_transaksi = 0 dan tidak ada status_transaksi = 1, qty adalah 0
            }

            // Jika hanya ada status_transaksi = 1, maka seluruh grup tidak dihitung (qty = 0)
            return 0; 
        });

        // Menghitung jumlah item untuk consumables berdasarkan spesifikasi_barang
        $consumablesCounts = $consumables->map(function ($group) {
            // Memeriksa apakah ada item dengan status_transaksi = 0 dalam grup ini
            $hasStatusTransaksi0 = $group->contains(function ($item) {
                return $item->status_transaksi == 0;
            });

            // Memeriksa apakah ada item dengan status_transaksi = 1 dalam grup ini
            $hasStatusTransaksi1 = $group->contains(function ($item) {
                return $item->status_transaksi == 1;
            });

            // Jika ada status_transaksi = 0, seluruh grup dihitung dan qty dihitung berdasarkan jumlah data dengan status_transaksi = 0
            if ($hasStatusTransaksi0) {
                // Menghitung jumlah data dengan status_transaksi = 0
                return $group->filter(function ($item) {
                    return $item->status_transaksi == 0;
                })->count(); // Menghitung jumlah item dengan status_transaksi = 0
            }

            // Jika tidak ada status_transaksi = 0, maka qty default adalah 0
            if (!$hasStatusTransaksi1) {
                return 0; // Jika tidak ada status_transaksi = 0 dan tidak ada status_transaksi = 1, qty adalah 0
            }

            // Jika hanya ada status_transaksi = 1, maka seluruh grup tidak dihitung (qty = 0)
            return 0; 
        });

        // Mengirimkan data ke view
        return view('dashboard.monitoringstock.index', compact('hardware', 'consumables', 'hardwareCounts', 'consumablesCounts'));
    }

    public function indexData()
    {
        $monitoringstock = MonitoringStock::get();

        // Mengirimkan data ke view
        return view('dashboard.monitoringstock.indexData', compact('monitoringstock'));
    }

    // Menampilkan halaman Transaksi Scan
    public function transaksi()
    {
        // Definisikan array spesifikasi barang
        // $spesifikasiBarangs = ['PC', 'LAPTOP', 'PRINTER','MOUSE'];
        $spesifikasiBarangs = MonitoringStock::distinct('spesifikasi_barang')->pluck('spesifikasi_barang');
        return view('dashboard.monitoringstock.transaksi', compact('spesifikasiBarangs'));
    }

    public function store(Request $request)
    {
        // Validasi input yang diterima
        $validated = $request->validate([
            'type_barang' => 'required|string|in:HARDWARE,CONSUMABLE',
            'spesifikasi_barang' => 'required|string|max:255',
            'barcode' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);
    
        // Jika spesifikasi barang adalah "Other", gunakan nilai manual yang dimasukkan
        if ($validated['spesifikasi_barang'] === 'other') {
            $validated['spesifikasi_barang'] = $request->other_spesifikasi_barang; // Ambil nilai dari input manual
        }
    
        // Mencari apakah barcode sudah ada di database
        $existingStock = MonitoringStock::where('barcode', $validated['barcode'])->first();
    
        if ($existingStock) {
            // Jika status_transaksi sudah 1, return dengan error
            if ($existingStock->status_transaksi == 1) {
                return redirect()->route('monitoringstock.transaksi')->with('error', 'Status Transaksi Pada Barcode ini Sudah Close!');
            }
    
            // Jika barcode sudah ada dan status_transaksi bukan 1, update status_barang menjadi 1
            $existingStock->update([
                'status_transaksi' => 1,
                'keterangan' => $validated['keterangan'],
                
            ]);
    
            // Mengembalikan ke halaman transaksi dengan pesan sukses
            return redirect()->route('monitoringstock.transaksi')->with('success', 'Status Transaksi Barcode berhasil diClose!');
        } else {
            // Jika barcode belum ada, simpan data baru dengan status_transaksi default 0
            MonitoringStock::create([
                'type_barang' => $validated['type_barang'],
                'spesifikasi_barang' => $validated['spesifikasi_barang'],
                'barcode' => $validated['barcode'],
                'status_transaksi' => 0,  // default value
                'keterangan' => $validated['keterangan'],
            ]);
    
            // Mengembalikan ke halaman transaksi dengan pesan sukses
            return redirect()->route('monitoringstock.transaksi')->with('success', 'Transaksi scan Barcode berhasil disimpan!');
        }
    }

    public function edit(string $id)
    {
        // Mencari data berdasarkan ID
        $monitoringstock = MonitoringStock::findOrFail($id);

        // Menyiapkan data untuk dikirim ke tampilan
        $data = [
            'monitoringstock' => $monitoringstock,
        ];

        // Mengirim data ke tampilan
        return view('dashboard.monitoringstock.edit', $data);
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $validated = $request->validate([
            'type_barang' => 'required|string|max:255',
            'spesifikasi_barang' => 'nullable|string|max:255',
            'barcode' => 'nullable|string|max:255',
            'status_transaksi' => 'required|in:0,1',
            'keterangan' => 'nullable|string',
            'created_at' => 'nullable|string',
            'updated_at' => 'nullable|string',
        ]);

        // Mencari data berdasarkan ID
        $monitoringstock = MonitoringStock::findOrFail($id);

        // Mengupdate data dengan data yang telah divalidasi
        $monitoringstock->update([
            'type_barang' => $validated['type_barang'],
            'spesifikasi_barang' => $validated['spesifikasi_barang'],
            'barcode' => $validated['barcode'],
            'status_transaksi' => $validated['status_transaksi'],
            'keterangan' => $validated['keterangan'],
            'created_at' => $validated['created_at'],
            'updated_at' => $validated['updated_at'],
        ]);

        // Mengirimkan response setelah berhasil mengupdate
        return redirect()->route('indexData.index')->with('success', 'Data Monitoring Stock berhasil disimpan!');
    }

    public function destroy($id)
    {
        // Find the record by ID
        $monitoringstock = MonitoringStock::findOrFail($id);

        // Delete the record
        $monitoringstock->delete();

        // Redirect back with success message
        return redirect()->route('indexData.index')->with('success', 'Data berhasil dihapus');
    }



}
