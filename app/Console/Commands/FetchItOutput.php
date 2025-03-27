<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\ItOutput;
use Carbon\Carbon;

class FetchItOutput extends Command
{
    protected $signature = 'fetch:itoutput';
    protected $description = 'Fetch data IT Output dari API dan simpan ke database kedua (po)';

    public function handle()
    {
        $apiUrl = 'http://erpprd-app1.dharmap.com:8001/sap/zapi/ZMM_LIST_PR_PO?sap-client=300&DOC_DATE_FROM=2025-01-01&DOC_DATE_TO=2030-12-31&COMP_CODE=1100';
        $username = 'dpm-einvc';
        $password = 'Einvoice01';

        // Ambil data dari API eksternal dengan autentikasi
        $response = Http::withBasicAuth($username, $password)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])
            ->timeout(0)
            ->get($apiUrl);

        if ($response->failed()) {
            $this->error('Gagal mengambil data dari API');
            return;
        }

        $data = $response->json();

        if (!isset($data['it_output']) || !is_array($data['it_output'])) {
            $this->error('Format API tidak sesuai atau tidak ada data!');
            return;
        }
        
        $allData = [];
        foreach ($data['it_output'] as $item) {
            $allData[] = [
                'banfn' => $item['banfn'],
                'bnfpo' => $item['bnfpo'],
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
                'leadtime_pr' => $item['leadtime_pr'],
                'status_pr' => $item['status_pr'],
                'leadtime_po' => $item['leadtime_po'],
                'status_po' => $item['status_po'],
                'leadtime_prpo' => $item['leadtime_prpo'],
                'waers_pr' => $item['waers_pr'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (empty($allData)) {
            $this->info('Tidak ada data baru untuk disimpan.');
            return;
        }

        // Simpan data menggunakan chunk untuk mengurangi beban database
        DB::connection('mysql2')->beginTransaction();
        try {
            $chunks = array_chunk($allData, 1000); // Simpan per 1000 record
            foreach ($chunks as $chunk) {
                ItOutput::upsert($chunk, ['banfn', 'bnfpo', 'ebeln', 'ebelp', 'matnr1'], [
                    'badat', 'pr_already', 'pr_next', 'ernam', 'erdat', 'txz011', 'txz02',
                    'menge1', 'meins1', 'preis', 'total', 'afnam', 'lifnr', 'mcod1', 'aedat',
                    'po_already', 'po_next', 'matnr2', 'txz012', 'loekz', 'menge2', 'meins2', 'netwr', 'waers',
                    'mblnr', 'grjum', 'grval', 'belnr', 'budat', 'irjum', 'irval', 'ficlear', 'wrbtr', 'shkzg',
                    'xblnr', 'bktxt', 'begrjum', 'begrval', 'beirjum', 'beirval', 'leadtime_pr',
                    'status_pr', 'leadtime_po', 'status_po', 'leadtime_prpo', 'waers_pr', 'created_at', 'updated_at'
                ]);                     
            }
            DB::connection('mysql2')->commit();
            $this->info('Data berhasil disimpan ke database kedua.');
        } catch (\Exception $e) {
            DB::connection('mysql2')->rollBack();
            $this->error('Error: ' . $e->getMessage());
        }

        \Log::info('fetch:itoutput command finished execution.');
    }

    /**
     * Fungsi untuk konversi tanggal dan handle nilai null
     */
    private function convertDate($date)
    {
        // Jika tanggal kosong atau tidak valid, kembalikan null
        if (empty($date) || $date == '0000-00-00') {
            return null;
        }

        // Coba parsing dengan Carbon, kembalikan null jika error
        try {
            return Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
