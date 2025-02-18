<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $role = Auth::user()->role->name;

        if ($role == 'divh') {
            return $this->divh();
        } else if ($role == 'user') {
            return $this->user();
        } else if ($role == 'dh') {
            return $this->dh();
        } else if ($role == 'it') {
            return $this->it();
        }
    }

    private function divh()
    {
        // Existing user and proposal counts
        $divh = User::whereHas('role', fn($query) => $query->where('name', 'divh'))->count();
        $dh = User::whereHas('role', fn($query) => $query->where('name', 'dh'))->count();
        $user = User::whereHas('role', fn($query) => $query->where('name', 'user'))->count();
        $countJeninsPermintaan = Proposal::select('status_barang', DB::raw('COUNT(*) as count'))->groupBy('status_barang')->where('status_apr','fully_approved')->get();
        $countJeninsPermintaanByUser = Proposal::join('users', 'proposals.user_id', '=', 'users.id')
        ->select('users.name', 'proposals.status_barang', DB::raw('COUNT(*) as count'))
        ->groupBy('users.name', 'proposals.status_barang')
        ->get();
        $countJeninsPermintaanByIT = Proposal::select('it_user', 'status_barang', DB::raw('COUNT(*) as count'))
        ->where('status_apr', 'fully_approved')
        ->whereNotNull('it_user') // Menambahkan kondisi untuk memastikan it_user tidak null
        ->groupBy('it_user', 'status_barang')
        ->get();
        $ratingByUserIT = Proposal::select('it_user', DB::raw('AVG(rating_it) as rating'))
        ->whereIn('status_cr', ['Closed','Closed With Delay', 'Auto Close'])
        ->groupBy('it_user')
        ->get();

    //   /  dd($countJeninsPermintaanByIT);

        $proposalCount = Proposal::count();
        $pending = Proposal::whereIn('status_apr', ['pending','partially_approved'])->count();
        $approved = Proposal::where('status_apr', 'fully_approved')->count();
        $rejected = Proposal::where('status_apr', 'rejected')->count();
        $open = Proposal::where('status_cr', 'Open To IT')->count();
        $onprogress = Proposal::whereIn('status_cr', ['ON PROGRESS', 'DELAY'])->count();
        $closed = Proposal::whereIn('status_cr', ['Closed By IT', 'Closed With Delay', 'Closed By IT With Delay', 'Auto Closed', 'Closed','Closed With Delay'])->count();
        
        $account = User::select(DB::raw('COUNT(*) as count'))->groupBy('role_id')->get();
        $proposal = Proposal::select('status_apr', DB::raw('COUNT(*) as count'))->groupBy('status_apr')->get();

        $chartProposal = [
            'labels' => $proposal->pluck('status_apr'),
            'datasets' => [
                [
                    'label' => 'Status CR',
                    'backgroundColor' => ['#343a40', '#39cccc', '#d81b60'],
                    'data' => $proposal->pluck('count')
                ],
            ],
        ];

        $chartAccount = [
            'labels' => ['Divh', 'DH', 'User'],
            'datasets' => [
                [
                    'label' => 'Status CR',
                    'backgroundColor' => ['#343a40', '#39cccc', '#d81b60'],
                    'data' => $account->pluck('count')
                ],
            ],
        ];

        // Get CR counts by user
        $crCounts = $this->crCountsByUserForIT();

        // Prepare the counts for the view
        $count = (object) [
            'divh' => $divh,
            'dh' => $dh,
            'user' => $user,
            'proposal' => $proposalCount,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
            'open' => $open,
            'onprogress' => $onprogress,
            'closed' => $closed
        ];

        $data = [
            'title' => 'Dashboard | DPM',
            'count' => $count,
            'chart1' => $chartAccount,
            'chart2' => $chartProposal,
            'crCounts' => $crCounts,  // Add the CR counts to the data
            'countJeninsPermintaan' => $countJeninsPermintaan,  // Add this line
            'countJeninsPermintaanByUser' => $countJeninsPermintaanByUser,  // Add this line
            'countJeninsPermintaanByIT' => $countJeninsPermintaanByIT,
            'ratingByUserIT' => $ratingByUserIT 
        ];

        return view('dashboard.roles.divh', $data);
    }


    private function dh()
    {
        // Existing user and proposal counts
        $divh = User::whereHas('role', fn($query) => $query->where('name', 'divh'))->count();
        $dh = User::whereHas('role', fn($query) => $query->where('name', 'dh'))->count();
        $user = User::whereHas('role', fn($query) => $query->where('name', 'user'))->count();
        $countJeninsPermintaan = Proposal::select('status_barang', DB::raw('COUNT(*) as count'))->groupBy('status_barang')->where('status_apr','fully_approved')->get();
        $countJeninsPermintaanByUser = Proposal::join('users', 'proposals.user_id', '=', 'users.id')
        ->select('users.name', 'proposals.status_barang', DB::raw('COUNT(*) as count'))
        ->groupBy('users.name', 'proposals.status_barang')
        ->get();
        $countJeninsPermintaanByIT = Proposal::select('it_user', 'status_barang', DB::raw('COUNT(*) as count'))
        ->where('status_apr', 'fully_approved')
        ->whereNotNull('it_user') // Menambahkan kondisi untuk memastikan it_user tidak null
        ->groupBy('it_user', 'status_barang')
        ->get();
        $ratingByUserIT = Proposal::select('it_user', DB::raw('AVG(rating_it) as rating'))
        ->whereIn('status_cr', ['Closed','Closed With Delay', 'Auto Close'])
        ->groupBy('it_user')
        ->get();

    //   /  dd($countJeninsPermintaanByIT);

        $proposalCount = Proposal::count();
        $pending = Proposal::whereIn('status_apr', ['pending','partially_approved'])->count();
        $approved = Proposal::where('status_apr', 'fully_approved')->count();
        $rejected = Proposal::where('status_apr', 'rejected')->count();
        $open = Proposal::where('status_cr', 'Open To IT')->count();
        $onprogress = Proposal::whereIn('status_cr', ['ON PROGRESS', 'DELAY'])->count();
        $closed = Proposal::whereIn('status_cr', ['Closed By IT', 'Closed With Delay', 'Closed By IT With Delay', 'Auto Closed', 'Closed','Closed With Delay'])->count();
        
        $account = User::select(DB::raw('COUNT(*) as count'))->groupBy('role_id')->get();
        $proposal = Proposal::select('status_apr', DB::raw('COUNT(*) as count'))->groupBy('status_apr')->get();

        $chartProposal = [
            'labels' => $proposal->pluck('status_apr'),
            'datasets' => [
                [
                    'label' => 'Status CR',
                    'backgroundColor' => ['#343a40', '#39cccc', '#d81b60'],
                    'data' => $proposal->pluck('count')
                ],
            ],
        ];

        $chartAccount = [
            'labels' => ['Divh', 'DH', 'User'],
            'datasets' => [
                [
                    'label' => 'Status CR',
                    'backgroundColor' => ['#343a40', '#39cccc', '#d81b60'],
                    'data' => $account->pluck('count')
                ],
            ],
        ];

        // Get CR counts by user
        $crCounts = $this->crCountsByUserForIT();

        // Prepare the counts for the view
        $count = (object) [
            'divh' => $divh,
            'dh' => $dh,
            'user' => $user,
            'proposal' => $proposalCount,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
            'open' => $open,
            'onprogress' => $onprogress,
            'closed' => $closed
        ];

        $data = [
            'title' => 'Dashboard | DPM',
            'count' => $count,
            'chart1' => $chartAccount,
            'chart2' => $chartProposal,
            'crCounts' => $crCounts,  // Add the CR counts to the data
            'countJeninsPermintaan' => $countJeninsPermintaan,  // Add this line
            'countJeninsPermintaanByUser' => $countJeninsPermintaanByUser,  // Add this line
            'countJeninsPermintaanByIT' => $countJeninsPermintaanByIT,
            'ratingByUserIT' => $ratingByUserIT 
        ];

        return view('dashboard.roles.dh', $data);
    }

    public function getCrData(Request $request)
    {
        $status = $request->input('status');
        
        // Inisialisasi variabel untuk menyimpan data proposal
        $proposals = [];

        // Sesuaikan query berdasarkan status yang diterima
        switch ($status) {
            case 'Total CR':
                // Ambil data untuk semua proposal
                $proposals = Proposal::all();
                break;
            case 'Total CR Pending':
                // Ambil data proposal dengan status 'pending'
                $proposals = Proposal::whereIn('status_apr', ['pending','partially_approved'])->get();
                break;
            case 'Total CR Approved':
                // Ambil data proposal dengan status 'approved'
                $proposals = Proposal::where('status_apr', 'fully_approved')->get();
                break;
            case 'Total CR Rejected':
                // Ambil data proposal dengan status 'rejected'
                $proposals = Proposal::where('status_apr', 'rejected')->get();
                break;
            case 'Total CR Open To IT':
                // Ambil data proposal yang terbuka untuk IT
                $proposals = Proposal::where('status_cr', 'Open To IT')->get();
                break;
            case 'Total CR ON Progress':
                // Ambil data proposal yang sedang dalam progress
                $proposals = Proposal::whereIn('status_cr', ['ON PROGRESS', 'DELAY'])->get();
                break;
            case 'Total CR Closed':
                // Ambil data proposal yang sudah ditutup
                $proposals = Proposal::whereIn('status_cr', ['Closed By IT', 'Closed With Delay', 'Closed By IT With Delay', 'Auto Closed', 'Closed','Closed With Delay'])->get();
                break;
            default:
                // Jika status tidak dikenali, kirimkan data kosong
                $proposals = [];
                break;
        }

        // Kembalikan data dalam bentuk HTML (bisa disesuaikan)
        return view('dashboard.roles.cr-data', ['proposals' => $proposals]);
    }


    private function it()
    {
        // Existing user and proposal counts
        $divh = User::whereHas('role', fn($query) => $query->where('name', 'divh'))->count();
        $dh = User::whereHas('role', fn($query) => $query->where('name', 'dh'))->count();
        $user = User::whereHas('role', fn($query) => $query->where('name', 'user'))->count();
        $countJeninsPermintaan = Proposal::select('status_barang', DB::raw('COUNT(*) as count'))->groupBy('status_barang')->where('status_apr','fully_approved')->get();
        $countJeninsPermintaanByUser = Proposal::join('users', 'proposals.user_id', '=', 'users.id')
        ->select('users.name', 'proposals.status_barang', DB::raw('COUNT(*) as count'))
        ->groupBy('users.name', 'proposals.status_barang')
        ->get();
        $countJeninsPermintaanByIT = Proposal::select('it_user', 'status_barang', DB::raw('COUNT(*) as count'))
        ->where('status_apr', 'fully_approved')
        ->whereNotNull('it_user') // Menambahkan kondisi untuk memastikan it_user tidak null
        ->groupBy('it_user', 'status_barang')
        ->get();
        $ratingByUserIT = Proposal::select('it_user', DB::raw('AVG(rating_it) as rating'))
        ->whereIn('status_cr', ['Closed','Closed With Delay', 'Auto Close'])
        ->groupBy('it_user')
        ->get();

    //   /  dd($countJeninsPermintaanByIT);

        $proposalCount = Proposal::count();
        $pending = Proposal::whereIn('status_apr', ['pending','partially_approved'])->count();
        $approved = Proposal::where('status_apr', 'fully_approved')->count();
        $rejected = Proposal::where('status_apr', 'rejected')->count();
        $open = Proposal::where('status_cr', 'Open To IT')->count();
        $onprogress = Proposal::whereIn('status_cr', ['ON PROGRESS', 'DELAY'])->count();
        $closed = Proposal::whereIn('status_cr', ['Closed By IT', 'Closed With Delay', 'Closed By IT With Delay', 'Auto Closed', 'Closed','Closed With Delay'])->count();
        
        $account = User::select(DB::raw('COUNT(*) as count'))->groupBy('role_id')->get();
        $proposal = Proposal::select('status_apr', DB::raw('COUNT(*) as count'))->groupBy('status_apr')->get();

        $datatotal = Proposal::get();
        $datapending = Proposal::where('status_apr', 'pending')->get();

        $chartProposal = [
            'labels' => $proposal->pluck('status_apr'),
            'datasets' => [
                [
                    'label' => 'Status CR',
                    'backgroundColor' => ['#343a40', '#39cccc', '#d81b60'],
                    'data' => $proposal->pluck('count')
                ],
            ],
        ];

        $chartAccount = [
            'labels' => ['Divh', 'DH', 'User'],
            'datasets' => [
                [
                    'label' => 'Status CR',
                    'backgroundColor' => ['#343a40', '#39cccc', '#d81b60'],
                    'data' => $account->pluck('count')
                ],
            ],
        ];

        // Get CR counts by user
        $crCounts = $this->crCountsByUserForIT();

        // Prepare the counts for the view
        $count = (object) [
            'divh' => $divh,
            'dh' => $dh,
            'user' => $user,
            'proposal' => $proposalCount,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
            'open' => $open,
            'onprogress' => $onprogress,
            'closed' => $closed
        ];

        $data = [
            'title' => 'Dashboard | DPM',
            'count' => $count,
            'chart1' => $chartAccount,
            'chart2' => $chartProposal,
            'crCounts' => $crCounts,  // Add the CR counts to the data
            'countJeninsPermintaan' => $countJeninsPermintaan,  // Add this line
            'countJeninsPermintaanByUser' => $countJeninsPermintaanByUser,  // Add this line
            'countJeninsPermintaanByIT' => $countJeninsPermintaanByIT,
            'ratingByUserIT' => $ratingByUserIT 
        ];

        return view('dashboard.roles.it', $data);
    }

    private function user()
    {
       // Existing user and proposal counts
       $divh = User::whereHas('role', fn($query) => $query->where('name', 'divh'))->count();
       $dh = User::whereHas('role', fn($query) => $query->where('name', 'dh'))->count();
       $user = User::whereHas('role', fn($query) => $query->where('name', 'user'))->count();
       $countJeninsPermintaan = Proposal::select('status_barang', DB::raw('COUNT(*) as count'))->groupBy('status_barang')->where('status_apr','fully_approved')->get();
       $countJeninsPermintaanByUser = Proposal::join('users', 'proposals.user_id', '=', 'users.id')
       ->select('users.name', 'proposals.status_barang', DB::raw('COUNT(*) as count'))
       ->groupBy('users.name', 'proposals.status_barang')
       ->get();
       $countJeninsPermintaanByIT = Proposal::select('it_user', 'status_barang', DB::raw('COUNT(*) as count'))
       ->where('status_apr', 'fully_approved')
       ->whereNotNull('it_user') // Menambahkan kondisi untuk memastikan it_user tidak null
       ->groupBy('it_user', 'status_barang')
       ->get();
       $ratingByUserIT = Proposal::select('it_user', DB::raw('AVG(rating_it) as rating'))
       ->whereIn('status_cr', ['Closed','Closed With Delay', 'Auto Close'])
       ->groupBy('it_user')
       ->get();

   //   /  dd($countJeninsPermintaanByIT);

       $proposalCount = Proposal::count();
       $pending = Proposal::whereIn('status_apr', ['pending','partially_approved'])->count();
       $approved = Proposal::where('status_apr', 'fully_approved')->count();
       $rejected = Proposal::where('status_apr', 'rejected')->count();
       $open = Proposal::where('status_cr', 'Open To IT')->count();
       $onprogress = Proposal::whereIn('status_cr', ['ON PROGRESS', 'DELAY'])->count();
       $closed = Proposal::whereIn('status_cr', ['Closed By IT', 'Closed With Delay', 'Closed By IT With Delay', 'Auto Closed', 'Closed','Closed With Delay'])->count();
       
       $account = User::select(DB::raw('COUNT(*) as count'))->groupBy('role_id')->get();
       $proposal = Proposal::select('status_apr', DB::raw('COUNT(*) as count'))->groupBy('status_apr')->get();

       $chartProposal = [
           'labels' => $proposal->pluck('status_apr'),
           'datasets' => [
               [
                   'label' => 'Status CR',
                   'backgroundColor' => ['#343a40', '#39cccc', '#d81b60'],
                   'data' => $proposal->pluck('count')
               ],
           ],
       ];

       $chartAccount = [
           'labels' => ['Divh', 'DH', 'User'],
           'datasets' => [
               [
                   'label' => 'Status CR',
                   'backgroundColor' => ['#343a40', '#39cccc', '#d81b60'],
                   'data' => $account->pluck('count')
               ],
           ],
       ];

       // Get CR counts by user
       $crCounts = $this->crCountsByUserForIT();

       // Prepare the counts for the view
       $count = (object) [
           'divh' => $divh,
           'dh' => $dh,
           'user' => $user,
           'proposal' => $proposalCount,
           'pending' => $pending,
           'approved' => $approved,
           'rejected' => $rejected,
           'open' => $open,
           'onprogress' => $onprogress,
           'closed' => $closed
       ];

       $data = [
           'title' => 'Dashboard | DPM',
           'count' => $count,
           'chart1' => $chartAccount,
           'chart2' => $chartProposal,
           'crCounts' => $crCounts,  // Add the CR counts to the data
           'countJeninsPermintaan' => $countJeninsPermintaan,  // Add this line
           'countJeninsPermintaanByUser' => $countJeninsPermintaanByUser,  // Add this line
           'countJeninsPermintaanByIT' => $countJeninsPermintaanByIT,
           'ratingByUserIT' => $ratingByUserIT 
       ];

        return view('dashboard.roles.user', $data);
    }

    private function admin()
    {
        $proposal = Proposal::select('status_apr', DB::raw('COUNT(*) as count'))->groupBy('status_apr')->get();

        $chart = [
            'labels' => $proposal->pluck('status_apr'),
            'datasets' => [
                [
                    'label' => 'Status CR',
                    'backgroundColor' => ['#343a40', '#39cccc', '#d81b60'],
                    'data' => $proposal->pluck('count')
                ],
            ],
        ];

        $data = [
            'title' => 'Dashboard | DPM',
            'chart' => $chart,
        ];

        return view('dashboard.roles.admin', $data);
    }

    private function crCountsByUser()
    {
        // Memeriksa apakah user sedang login dan memiliki departemen
        if (auth()->check() && auth()->user()->departement) {
            // Mengambil daftar departemen pengguna yang sedang login
            $userDepartements = auth()->user()->departement;  // Tidak perlu explode karena sudah dalam format yang benar (dipisahkan koma)
            
            // Mengambil proposal yang terkait dengan departemen user yang sedang login
            return Proposal::whereRaw('FIND_IN_SET(?, departement)', [$userDepartements])  // Menggunakan FIND_IN_SET untuk mencocokkan beberapa departemen
                    ->where('status_apr', 'fully_approved')
                    ->select('it_user', 
                    DB::raw('COUNT(*) as total_count'),
                    DB::raw('SUM(CASE WHEN status_cr = "ON PROGRESS" THEN 1 ELSE 0 END) as on_progress_count'),
                    DB::raw('SUM(CASE WHEN status_cr IN ("Closed All", "Auto Close") THEN 1 ELSE 0 END) as closed_count'),
                    DB::raw('SUM(CASE WHEN status_cr IN ("Closed With Delay") THEN 1 ELSE 0 END) as closed_delay_count'),
                    DB::raw('SUM(CASE WHEN status_cr = "DELAY" THEN 1 ELSE 0 END) as delay_count'),
                    DB::raw('SUM(CASE WHEN status_cr IS NULL THEN 1 ELSE 0 END) as not_proceed_count')
                )
                ->groupBy('it_user')
                ->get()
                ->map(function($item) {
                    // Jika it_user tidak ada, set status default
                    $item->it_user = $item->it_user ?? 'CR has not been processed by IT';
                    return $item;
                });
        } else {
            // Jika user tidak login atau tidak memiliki departemen, kembalikan semua data proposal
            return Proposal::where('status_apr', 'fully_approved')
                ->select('it_user', 
                DB::raw('COUNT(*) as total_count'),
                DB::raw('SUM(CASE WHEN status_cr = "ON PROGRESS" THEN 1 ELSE 0 END) as on_progress_count'),
                DB::raw('SUM(CASE WHEN status_cr IN ("Closed", "Auto Close") THEN 1 ELSE 0 END) as closed_count'),
                DB::raw('SUM(CASE WHEN status_cr IN ("Closed With Delay") THEN 1 ELSE 0 END) as closed_delay_count'),
                DB::raw('SUM(CASE WHEN status_cr = "DELAY" THEN 1 ELSE 0 END) as delay_count'),
                DB::raw('SUM(CASE WHEN status_cr IS NULL OR status_cr = "Open To IT" THEN 1 ELSE 0 END) as not_proceed_count')
            )
            ->groupBy('it_user')
            ->get()
            ->map(function($item) {
                // Jika it_user tidak ada, set status default
                $item->it_user = $item->it_user ?? 'CR has not been processed by IT';
                return $item;
            });
        }
    }

    private function crCountsByUserForIT()
    {
        // Assuming Proposal has a user_id that relates to the User model
        return Proposal::where('status_apr', 'fully_approved')
            ->select('it_user', DB::raw('COUNT(*) as total_count'),
            DB::raw('SUM(CASE WHEN status_cr = "ON PROGRESS" THEN 1 ELSE 0 END) as on_progress_count'),
            DB::raw('SUM(CASE WHEN status_cr IN ("Closed", "Auto Close") THEN 1 ELSE 0 END) as closed_count'),
            DB::raw('SUM(CASE WHEN status_cr IN ("Closed With Delay") THEN 1 ELSE 0 END) as closed_delay_count'),
            DB::raw('SUM(CASE WHEN status_cr = "DELAY" THEN 1 ELSE 0 END) as delay_count'),
            DB::raw('SUM(CASE WHEN status_cr IS NULL OR status_cr = "Open To IT" THEN 1 ELSE 0 END) as not_proceed_count')
        )
        ->groupBy('it_user')
        ->get()
        ->map(function($item) {
            $item->it_user = $item->it_user ?? 'CR has not been processed by IT'; // Set status if it_user is null
            return $item;
        });
    }




}