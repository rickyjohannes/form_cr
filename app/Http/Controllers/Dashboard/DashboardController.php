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
        
        $proposalCount = Proposal::count();
        $pending = Proposal::where('status_dh', 'pending')->count();
        $approved = Proposal::where('status_divh', 'approved')->count();
        $rejected = Proposal::where('status_dh', 'rejected')->count();
        
        $account = User::select(DB::raw('COUNT(*) as count'))->groupBy('role_id')->get();
        $proposal = Proposal::select('status_dh', DB::raw('COUNT(*) as count'))->groupBy('status_dh')->get();

        $chartProposal = [
            'labels' => $proposal->pluck('status_dh'),
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
        $crCounts = $this->crCountsByUser();

        // Prepare the counts for the view
        $count = (object) [
            'divh' => $divh,
            'dh' => $dh,
            'user' => $user,
            'proposal' => $proposalCount,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected
        ];

        $data = [
            'title' => 'Dashboard | DPM',
            'count' => $count,
            'chart1' => $chartAccount,
            'chart2' => $chartProposal,
            'crCounts' => $crCounts,  // Add the CR counts to the data
        ];

        return view('dashboard.roles.divh', $data);
    }


    private function dh()
    {
        // Existing user and proposal counts
        $divh = User::whereHas('role', fn($query) => $query->where('name', 'divh'))->count();
        $dh = User::whereHas('role', fn($query) => $query->where('name', 'dh'))->count();
        $user = User::whereHas('role', fn($query) => $query->where('name', 'user'))->count();
        
        $proposalCount = Proposal::count();
        $pending = Proposal::where('status_dh', 'pending')->count();
        $approved = Proposal::where('status_divh', 'approved')->count();
        $rejected = Proposal::where('status_dh', 'rejected')->count();
        
        $account = User::select(DB::raw('COUNT(*) as count'))->groupBy('role_id')->get();
        $proposal = Proposal::select('status_dh', DB::raw('COUNT(*) as count'))->groupBy('status_dh')->get();

        $chartProposal = [
            'labels' => $proposal->pluck('status_dh'),
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
        $crCounts = $this->crCountsByUser();

        // Prepare the counts for the view
        $count = (object) [
            'divh' => $divh,
            'dh' => $dh,
            'user' => $user,
            'proposal' => $proposalCount,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected
        ];

        $data = [
            'title' => 'Dashboard | DPM',
            'count' => $count,
            'chart1' => $chartAccount,
            'chart2' => $chartProposal,
            'crCounts' => $crCounts,  // Add the CR counts to the data
        ];

        return view('dashboard.roles.dh', $data);
    }

    private function it()
    {
        // Existing user and proposal counts
        $divh = User::whereHas('role', fn($query) => $query->where('name', 'divh'))->count();
        $dh = User::whereHas('role', fn($query) => $query->where('name', 'dh'))->count();
        $user = User::whereHas('role', fn($query) => $query->where('name', 'user'))->count();
        
        $proposalCount = Proposal::count();
        $pending = Proposal::where('status_dh', 'pending')->count();
        $approved = Proposal::where('status_divh', 'approved')->count();
        $rejected = Proposal::where('status_dh', 'rejected')->count();
        
        $account = User::select(DB::raw('COUNT(*) as count'))->groupBy('role_id')->get();
        $proposal = Proposal::select('status_dh', DB::raw('COUNT(*) as count'))->groupBy('status_dh')->get();

        $chartProposal = [
            'labels' => $proposal->pluck('status_dh'),
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
        $crCounts = $this->crCountsByUser();

        // Prepare the counts for the view
        $count = (object) [
            'divh' => $divh,
            'dh' => $dh,
            'user' => $user,
            'proposal' => $proposalCount,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected
        ];

        $data = [
            'title' => 'Dashboard | DPM',
            'count' => $count,
            'chart1' => $chartAccount,
            'chart2' => $chartProposal,
            'crCounts' => $crCounts,  // Add the CR counts to the data
        ];

        return view('dashboard.roles.it', $data);
    }

    private function user()
    {
        // Existing user and proposal counts
        $divh = User::whereHas('role', fn($query) => $query->where('name', 'divh'))->count();
        $dh = User::whereHas('role', fn($query) => $query->where('name', 'dh'))->count();
        $user = User::whereHas('role', fn($query) => $query->where('name', 'user'))->count();
        
        $proposalCount = Proposal::count();
        $pending = Proposal::where('status_dh', 'pending')->count();
        $approved = Proposal::where('status_divh', 'approved')->count();
        $rejected = Proposal::where('status_dh', 'rejected')->count();
        
        $account = User::select(DB::raw('COUNT(*) as count'))->groupBy('role_id')->get();
        $proposal = Proposal::select('status_dh', DB::raw('COUNT(*) as count'))->groupBy('status_dh')->get();

        $chartProposal = [
            'labels' => $proposal->pluck('status_dh'),
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
        $crCounts = $this->crCountsByUser();

        // Prepare the counts for the view
        $count = (object) [
            'divh' => $divh,
            'dh' => $dh,
            'user' => $user,
            'proposal' => $proposalCount,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected
        ];

        $data = [
            'title' => 'Dashboard | DPM',
            'count' => $count,
            'chart1' => $chartAccount,
            'chart2' => $chartProposal,
            'crCounts' => $crCounts,  // Add the CR counts to the data
        ];

        return view('dashboard.roles.user', $data);
    }

    


    private function admin()
    {
        $proposal = Proposal::select('status_dh', DB::raw('COUNT(*) as count'))->groupBy('status_dh')->get();

        $chart = [
            'labels' => $proposal->pluck('status_dh'),
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
        // Assuming Proposal has a user_id that relates to the User model
        return Proposal::select('it_user', DB::raw('COUNT(*) as total_count'),
            DB::raw('SUM(CASE WHEN status_cr = "ON PROGRESS" THEN 1 ELSE 0 END) as on_progress_count'),
            DB::raw('SUM(CASE WHEN status_cr = "DELAY" THEN 1 ELSE 0 END) as delay_count'),
            DB::raw('SUM(CASE WHEN status_cr = "CR Closed" THEN 1 ELSE 0 END) as closed_count'),
            DB::raw('SUM(CASE WHEN status_cr IS NULL THEN 1 ELSE 0 END) as not_proceed_count')
        )
        ->groupBy('it_user')
        ->get()
        ->map(function($item) {
            $item->it_user = $item->it_user ?? 'CR has not been processed by IT'; // Set status if it_user is null
            return $item;
        });
    }



}