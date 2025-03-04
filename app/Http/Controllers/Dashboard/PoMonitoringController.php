<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ItOutput; // Model untuk data PO
use Yajra\DataTables\Facades\DataTables;

class PoMonitoringController extends Controller
{
    public function index()
    {
        $data_po = ItOutput::all(); // Ambil semua data PO dari database kedua

        return view('dashboard.po.index', compact('data_po'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $query = ItOutput::select([
                'id', 'banfn', 'badat', 'pr_already', 'pr_next', 'ernam', 'erdat',
                'bnfpo', 'matnr1', 'txz011', 'txz02', 'menge1', 'meins1', 'preis', 'total',
                'afnam', 'lifnr', 'mcod1', 'ebeln', 'aedat', 'ebelp', 'po_already', 'po_next',
                'matnr2', 'txz012', 'loekz', 'menge2', 'meins2', 'netwr', 'waers', 'mblnr',
                'grjum', 'grval', 'belnr', 'budat', 'irjum', 'irval', 'ficlear', 'wrbtr',
                'shkzg', 'xblnr', 'bktxt', 'begrjum', 'begrval', 'beirjum', 'beirval',
                'created_at', 'updated_at'
            ]);

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->editColumn('loekz', function ($row) {
                    return empty($row->loekz) ? 'Active' : 'Closed';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '';
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at ? $row->updated_at->format('Y-m-d H:i:s') : '';
                })
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">Delete</button>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }
    }

    public function fetchData(Request $request)
    {
        try {
            // Ambil parameter dari request frontend
            $docDateFrom = $request->query('DOC_DATE_FROM');
            $docDateTo = $request->query('DOC_DATE_TO');
            $compCode = $request->query('COMP_CODE');

            // Validasi jika ada parameter kosong
            if (!$docDateFrom || !$docDateTo || !$compCode) {
                return response()->json(["error" => "Missing required parameters"], 400);
            }

            // URL API
            $apiUrl = "http://erpqas-dp.dharmap.com:8001/sap/zapi/ZMM_LIST_PR_PO?sap-client=300&DOC_DATE_FROM={$docDateFrom}&DOC_DATE_TO={$docDateTo}&COMP_CODE={$compCode}";

            $username = 'dpm-einvc';
            $password = 'Einvoice01';

            // Log URL sebelum request
            Log::info("Fetching data from API: " . $apiUrl);

            // Ambil data dari API eksternal dengan autentikasi
            $response = Http::withBasicAuth($username, $password)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ])
                ->timeout(600)
                ->get($apiUrl);

            // Log respons API
            Log::info("API Response Status: " . $response->status());
            Log::info("API Response Body: " . $response->body());

            // Jika request gagal
            if ($response->failed()) {
                Log::error("Failed to fetch data from API: " . $response->status());
                return response()->json([
                    'error' => 'Gagal mengambil data dari API', 
                    'status' => $response->status()
                ], 500);
            }            

            // Ambil data JSON dari API eksternal
            $data = $response->json();

            // Pastikan key `it_output` ada dalam response
            if (!isset($data['it_output'])) {
                Log::error("Format API tidak sesuai: Key 'it_output' tidak ditemukan.");
                return response()->json(["error" => "Format API tidak sesuai"], 500);
            }

            // Simpan data ke database dalam transaksi
            DB::connection('mysql2')->beginTransaction();
            try {
                foreach ($data['it_output'] as $item) {
                    ItOutput::updateOrCreate(
                        ['banfn' => $item['banfn'], 'bnfpo' => $item['bnfpo']],
                        [
                            'badat' => $this->convertDate($item['badat']),
                            'pr_already' => $item['pr_already'],
                            'pr_next' => $item['pr_next'],
                            'ernam' => $item['ernam'],
                            'erdat' => $this->convertDate($item['erdat']),
                            'matnr1' => $item['matnr1'],
                            'txz011' => $item['txz011'],
                            'txz02' => $item['txz02'],
                            'menge1' => $item['menge1'],
                            'meins1' => $item['meins1'],
                            'preis' => $item['preis'],
                            'total' => $item['total'],
                            'afnam' => $item['afnam'],
                            'lifnr' => $item['lifnr'],
                            'mcod1' => $item['mcod1'],
                            'ebeln' => $item['ebeln'],
                            'aedat' => $this->convertDate($item['aedat']),
                            'ebelp' => $item['ebelp'],
                            'po_already' => $item['po_already'],
                            'po_next' => $item['po_next'],
                            'matnr2' => $item['matnr2'],
                            'txz012' => $item['txz012'],
                            'loekz' => $item['loekz'],
                            'menge2' => $item['menge2'],
                            'meins2' => $item['meins2'],
                            'netwr' => $item['netwr'],
                            'waers' => $item['waers'],
                            'mblnr' => $item['mblnr'],
                            'grjum' => $item['grjum'],
                            'grval' => $item['grval'],
                            'belnr' => $item['belnr'],
                            'budat' => $this->convertDate($item['budat']),
                            'irjum' => $item['irjum'],
                            'irval' => $item['irval'],
                            'ficlear' => $item['ficlear'],
                            'wrbtr' => $item['wrbtr'],
                            'shkzg' => $item['shkzg'],
                            'xblnr' => $item['xblnr'],
                            'bktxt' => $item['bktxt'],
                            'begrjum' => $item['begrjum'],
                            'begrval' => $item['begrval'],
                            'beirjum' => $item['beirjum'],
                            'beirval' => $item['beirval'],
                        ]
                    );
                }
                DB::connection('mysql2')->commit();
                Log::info("Data berhasil disimpan ke database kedua.");
                return response()->json(["message" => "Data berhasil disimpan"]);
            } catch (\Exception $e) {
                DB::connection('mysql2')->rollBack();
                Log::error("Database Error: " . $e->getMessage());
                return response()->json(["error" => "Gagal menyimpan data ke database", "message" => $e->getMessage()], 500);
            }
        } catch (\Exception $e) {
            Log::error("Error fetching data: " . $e->getMessage());
            return response()->json(["error" => "Internal Server Error", "message" => $e->getMessage()], 500);
        }
    }

    // Fungsi untuk konversi tanggal agar tidak error
    private function convertDate($date)
    {
        return ($date == '0000-00-00' || empty($date)) ? null : $date;
    }

}
    