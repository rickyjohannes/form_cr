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

    public function indexChart()
    {
        $data_chart_po = ItOutput::all(); // Ambil semua data PO dari database kedua
    
        return view('dashboard.po.indexChart', compact('data_chart_po'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $query = ItOutput::select([
                'banfn', 'badat', 'pr_already', 'pr_next', 'ernam', 'erdat',
                'bnfpo', 'matnr1', 'txz011', 'txz02', 'menge1', 'meins1',
                'preis', 'total', 'afnam', 'lifnr', 'mcod1', 'ebeln', 'aedat',
                'ebelp', 'po_already', 'po_next', 'matnr2', 'txz012', 'loekz',
                'menge2', 'meins2', 'netwr', 'waers', 'mblnr', 'grjum', 'grval',
                'belnr', 'budat', 'irjum', 'irval', 'ficlear', 'wrbtr', 'shkzg',
                'xblnr', 'bktxt', 'begrjum', 'begrval', 'beirjum', 'beirval','leadtime_pr',
                'status_pr', 'leadtime_po', 'status_po', 'leadtime_prpo', 'waers_pr','created_at', 'updated_at'
            ]);

            // Filter berdasarkan No PR
            if (!empty($request->banfn)) {
                $query->where('banfn', 'like', "%{$request->banfn}%");
            }

            // Filter berdasarkan No PO
            if (!empty($request->ebeln)) {
                $query->where('ebeln', 'like', "%{$request->ebeln}%");
            }

            // Filter tanggal jika tersedia
            if ($request->badat_from && $request->badat_to) {
                $query->whereBetween('badat', [$request->badat_from, $request->badat_to]);
            }

            // Filter berdasarkan Material
            if (!empty($request->matnr1)) {
                $query->where('matnr1', 'like', "%{$request->matnr1}%");
            }

            // Filter berdasarkan Requisnr
            if (!empty($request->afnam)) {
                $query->where('afnam', 'like', "%{$request->afnam}%");
            }
            
            // Filter berdasarkan User SAP
            if (!empty($request->ernam)) {
                $query->where('ernam', 'like', "%{$request->ernam}%");
            }
               
            // DataTables Response
            return DataTables::eloquent($query)
            ->addIndexColumn()
            ->editColumn('badat', function ($row) {
                    return $row->badat ? \Carbon\Carbon::parse($row->badat)->format('d.m.Y') : '';
                })
                ->editColumn('erdat', function ($row) {
                    return $row->erdat ? \Carbon\Carbon::parse($row->erdat)->format('d.m.Y') : '';
                })
                ->editColumn('aedat', function ($row) {
                    return $row->aedat ? \Carbon\Carbon::parse($row->aedat)->format('d.m.Y') : '';
                })
                ->editColumn('budat', function ($row) {
                    return $row->budat == "0000-00-00" ? '' : \Carbon\Carbon::parse($row->budat)->format('d.m.Y');
                })
                ->editColumn('menge1', function ($row) {
                    return number_format($row->menge1, 0, ',', '.');
                })
                ->editColumn('menge2', function ($row) {
                    return number_format($row->menge2, 0, ',', '.');
                })
                ->editColumn('preis', function ($row) {
                    return number_format($row->preis, 0, ',', '.');
                })
                ->editColumn('total', function ($row) {
                    return number_format($row->total, 0, ',', '.');
                })
                ->editColumn('netwr', function ($row) {
                    return number_format($row->netwr, 0, ',', '.');
                })
                ->editColumn('grjum', function ($row) {
                    return number_format($row->grjum, 0, ',', '.');
                })
                ->editColumn('grval', function ($row) {
                    return number_format($row->grval, 0, ',', '.');
                })
                ->editColumn('irjum', function ($row) {
                    return number_format($row->irjum, 0, ',', '.');
                })
                ->editColumn('irval', function ($row) {
                    return number_format($row->irval, 0, ',', '.');
                })
                ->editColumn('wrbtr', function ($row) {
                    return number_format($row->wrbtr, 0, ',', '.');
                })
                ->editColumn('begrjum', function ($row) {
                    return number_format($row->begrjum, 0, ',', '.');
                })
                ->editColumn('begrval', function ($row) {
                    return number_format($row->begrval, 0, ',', '.');
                })
                ->editColumn('beirjum', function ($row) {
                    return number_format($row->beirjum, 0, ',', '.');
                })
                ->editColumn('beirval', function ($row) {
                    return number_format($row->beirval, 0, ',', '.');
                })
                // ->addColumn('action', function ($row) {
                //     return '<button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">Delete</button>';
                // })
                // ->rawColumns(['action'])
                ->toJson();
        }
    }

    public function getChart(Request $request)
    {
        $query = ItOutput::query();

        // Filter berdasarkan No PR
        if (!empty($request->banfn)) {
            $query->where('banfn', 'like', "%{$request->banfn}%");
        }

        // Filter berdasarkan No PO
        if (!empty($request->ebeln)) {
            $query->where('ebeln', 'like', "%{$request->ebeln}%");
        }

        // Filter tanggal jika tersedia
        if ($request->badat_from && $request->badat_to) {
            $query->whereBetween('badat', [$request->badat_from, $request->badat_to]);
        }

        // Filter berdasarkan Material
        if (!empty($request->matnr1)) {
            $query->where('matnr1', 'like', "%{$request->matnr1}%");
        }

        // Filter berdasarkan Requisnr
        if (!empty($request->afnam)) {
            $query->where('afnam', 'like', "%{$request->afnam}%");
        }

        // Filter berdasarkan User SAP
        if (!empty($request->ernam)) {
            $query->where('ernam', 'like', "%{$request->ernam}%");
        }

        // Hitung PR Non Approve
        $PRNonApprove = (clone $query)->where(function ($q) {
            $q->whereNotNull('pr_next')
            ->where('pr_next', '!=', '')
            ->whereNotNull('banfn')
            ->where('banfn', '!=', '');
        })->count();

        // Hitung PR Fully Approve
        $PRApprove = (clone $query)->where(function ($q) {
            $q->whereNull('pr_next')
            ->orWhere('pr_next', '')
            ->whereNotNull('banfn')
            ->where('banfn', '!=', '');
        })->count();

        // Hitung PO Non Approve
        $PONonApprove = (clone $query)->where(function ($q) {
            $q->whereNotNull('po_next')
            ->where('po_next', '!=', '')
            ->whereNotNull('ebeln')
            ->where('ebeln', '!=', '');
        })->count();  

        // Hitung PO Fully Approve
        $POApprove = (clone $query)->where(function ($q) {
            $q->whereNull('po_next')
            ->orWhere('po_next', '')
            ->whereNotNull('ebeln')
            ->where('ebeln', '!=', '');
        })->count();  

        // Total PO (jumlah semua PO)
        $TotalPO = $PONonApprove + $POApprove;

        // Hitung Lead Time hanya untuk nilai yang tidak NULL (0 tetap dihitung)
        $LeadTime = round((clone $query)
            ->whereNotNull('leadtime_prpo')
            ->whereRaw("TRIM(leadtime_prpo) != ''")
            ->selectRaw('ROUND(AVG(CAST(NULLIF(TRIM(leadtime_prpo), "") AS DECIMAL)), 2) AS avg_leadtime')
            ->value('avg_leadtime') ?? 0, 2);

        $LeadTimePR = round((clone $query)->whereNotNull('leadtime_pr')->average('leadtime_pr') ?? 0, 2);
        $LeadTimePO = round((clone $query)->whereNotNull('leadtime_po')->average('leadtime_po') ?? 0, 2);

        // Hitung persentase
        $persentasePRBelumJadiPO = $PRApprove > 0 ? round((($PRApprove - $TotalPO) / $PRApprove) * 100, 2) : 0;
        $persentasePODariPRApprove = $PRApprove > 0 ? round(($TotalPO / $PRApprove) * 100, 2) : 0;
        $persentasePOFullyApprove = $TotalPO > 0 ? round(($POApprove / $TotalPO) * 100, 2) : 0;
        $persentasePOBelumApprove = $TotalPO > 0 ? round(($PONonApprove / $TotalPO) * 100, 2) : 0;

        return response()->json([
            'pr_non_approve' => $PRNonApprove,
            'pr_fully_approve' => $PRApprove,
            'po_non_approve' => $PONonApprove,
            'po_fully_approve' => $POApprove,
            'LeadTime' => $LeadTime,
            'LeadTimePR' => $LeadTimePR,
            'LeadTimePO' => $LeadTimePO,
            'persentase_pr_belum_jadi_po' => $persentasePRBelumJadiPO,
            'persentase_po_dari_pr_approve' => $persentasePODariPRApprove,
            'persentase_po_fully_approve' => $persentasePOFullyApprove,
            'persentase_po_belum_approve' => $persentasePOBelumApprove,
        ]);
    }


    public function getDataChart(Request $request)
    {
        if ($request->ajax()) {
            // Query utama
            $query = ItOutput::select([
                'banfn', 'badat', 'pr_already', 'pr_next', 'ernam', 'erdat',
                'bnfpo', 'matnr1', 'txz011', 'txz02', 'menge1', 'meins1',
                'preis', 'total', 'afnam', 'lifnr', 'mcod1', 'ebeln', 'aedat',
                'ebelp', 'po_already', 'po_next', 'matnr2', 'txz012', 'loekz',
                'menge2', 'meins2', 'netwr', 'waers', 'mblnr', 'grjum', 'grval',
                'belnr', 'budat', 'irjum', 'irval', 'ficlear', 'wrbtr', 'shkzg',
                'xblnr', 'bktxt', 'begrjum', 'begrval', 'beirjum', 'beirval','leadtime_pr',
                'status_pr', 'leadtime_po', 'status_po', 'leadtime_prpo', 'waers_pr','created_at', 'updated_at'
            ]);

            // Filter berdasarkan No PR
            if (!empty($request->banfn)) {
                $query->where('banfn', 'like', "%{$request->banfn}%");
            }

            // Filter berdasarkan No PO
            if (!empty($request->ebeln)) {
                $query->where('ebeln', 'like', "%{$request->ebeln}%");
            }

            // Filter tanggal jika tersedia
            if ($request->badat_from && $request->badat_to) {
                $query->whereBetween('badat', [$request->badat_from, $request->badat_to]);
            }

            // Filter berdasarkan Material
            if (!empty($request->matnr1)) {
                $query->where('matnr1', 'like', "%{$request->matnr1}%");
            }

            // Filter berdasarkan Requisnr
            if (!empty($request->afnam)) {
                $query->where('afnam', 'like', "%{$request->afnam}%");
            }

            // Filter berdasarkan User SAP
            if (!empty($request->ernam)) {
                $query->where('ernam', 'like', "%{$request->ernam}%");
            }

            // DataTables Response
            return DataTables::eloquent($query)
            ->addIndexColumn()
            ->editColumn('badat', function ($row) {
                    return $row->badat ? \Carbon\Carbon::parse($row->badat)->format('d.m.Y') : '';
                })
                ->editColumn('erdat', function ($row) {
                    return $row->erdat ? \Carbon\Carbon::parse($row->erdat)->format('d.m.Y') : '';
                })
                ->editColumn('aedat', function ($row) {
                    return $row->aedat ? \Carbon\Carbon::parse($row->aedat)->format('d.m.Y') : '';
                })
                ->editColumn('budat', function ($row) {
                    return $row->budat == "0000-00-00" ? '' : \Carbon\Carbon::parse($row->budat)->format('d.m.Y');
                })
                ->editColumn('menge1', function ($row) {
                    return number_format($row->menge1, 0, ',', '.');
                })
                ->editColumn('menge2', function ($row) {
                    return number_format($row->menge2, 0, ',', '.');
                })
                ->editColumn('preis', function ($row) {
                    return number_format($row->preis, 0, ',', '.');
                })
                ->editColumn('total', function ($row) {
                    return number_format($row->total, 0, ',', '.');
                })
                ->editColumn('netwr', function ($row) {
                    return number_format($row->netwr, 0, ',', '.');
                })
                ->editColumn('grjum', function ($row) {
                    return number_format($row->grjum, 0, ',', '.');
                })
                ->editColumn('grval', function ($row) {
                    return number_format($row->grval, 0, ',', '.');
                })
                ->editColumn('irjum', function ($row) {
                    return number_format($row->irjum, 0, ',', '.');
                })
                ->editColumn('irval', function ($row) {
                    return number_format($row->irval, 0, ',', '.');
                })
                ->editColumn('wrbtr', function ($row) {
                    return number_format($row->wrbtr, 0, ',', '.');
                })
                ->editColumn('begrjum', function ($row) {
                    return number_format($row->begrjum, 0, ',', '.');
                })
                ->editColumn('begrval', function ($row) {
                    return number_format($row->begrval, 0, ',', '.');
                })
                ->editColumn('beirjum', function ($row) {
                    return number_format($row->beirjum, 0, ',', '.');
                })
                ->editColumn('beirval', function ($row) {
                    return number_format($row->beirval, 0, ',', '.');
                })
                ->toJson();
        }
    }

}
    