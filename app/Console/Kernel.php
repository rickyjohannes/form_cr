<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Proposal;
use App\Notifications\ProposalUpdatedDelay;
use App\Notifications\ProposalUpdatedDelayApproval;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Helpers\WhatsAppHelper;
use App\Helpers\BladeHelper;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            try {
                $this->updateProposals();
                $this->notifyDelayedProposals();
                $this->notifyDelayedApproval();
                
                $proposalsToClose = Proposal::where('status_cr', 'Closed By IT')
                    ->where('close_date', '<', now()->subDays(2))
                    ->get();

                foreach ($proposalsToClose as $proposal) {
                    $proposal->rating_it = '5';
                    $proposal->rating_apk = '5';
                    $proposal->status_cr = 'Auto Close';
                    $proposal->save();
                }

                $proposalsToCloseDelay = Proposal::where('status_cr', 'Closed By IT With Delay')
                    ->where('close_date', '<', now()->subDays(2))
                    ->get();

                foreach ($proposalsToCloseDelay as $proposal) {
                    $proposal->rating_it = '5';
                    $proposal->rating_apk = '5';
                    $proposal->status_cr = 'Auto Closed With Delay';
                    $proposal->save();
                }
            } catch (\Exception $e) {
                Log::error('Error in scheduled task: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            }
        })->everyMinute();

        $schedule->command('fetch:itoutput')->hourly();
        $schedule->command('backup:run')->dailyAt('16:00');
    }

    protected function updateProposals()
    {
        try {
            $proposals = Proposal::where('status_cr', 'ON PROGRESS')
                ->whereIn('status_barang', ['Pengadaan', 'Change Request', 'Pergantian', 'IT Helpdesk'])
                ->where('action_it_date', '<', now())
                ->update(['status_cr' => 'DELAY']);

            $proposals2 = Proposal::where('status_cr', 'ON PROGRESS')
                ->where('status_barang', 'Peminjaman')
                ->where('estimated_date', '<', now())
                ->update(['status_cr' => 'DELAY']);
        } catch (\Exception $e) {
            Log::error('Error in updateProposals: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        }
    }

    protected function notifyDelayedProposals()
    {
        try {
            $delayedProposals = Proposal::where('status_cr', 'DELAY')->get();
            foreach ($delayedProposals as $proposal) {
                try {
                    $itUsers = User::where('name', $proposal->it_user)
                        ->whereHas('role', function ($query) {
                            $query->where('name', 'it');
                        })->get();
                    
                    if ($itUsers->isEmpty()) {
                        continue;
                    }

                    foreach ($itUsers as $user) {
                        Notification::send($user, new ProposalUpdatedDelay($proposal));
                    }

                    $proposal->last_notified_at = now();
                    $proposal->save();
                } catch (\Exception $e) {
                    Log::error('Error notifying user ID: ' . $user->id . ' - ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in notifyDelayedProposals: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        }
    }

    protected function notifyDelayedApproval()
    {
        try {
            $delayedProposals = Proposal::where('status_apr', 'pending')
                ->where('updated_at', '<', now()->subDays(7))
                ->get();

            foreach ($delayedProposals as $proposal) {
                try {
                    $token = $proposal->token;
                    if (!$token) {
                        continue;
                    }

                    $usersToNotifyDh = User::whereHas('role', function ($query) {
                        $query->where('name', 'dh');
                    })->where('departement', $proposal->departement)
                    ->get();

                    foreach ($usersToNotifyDh as $user) {
                        Notification::send($user, new ProposalUpdatedDelayApproval(['proposal' => $proposal]));
                    }

                    $proposal->last_notified_at = now();
                    $proposal->save();
                } catch (\Exception $e) {
                    Log::error('Error notifying approval user ID: ' . $user->id . ' - ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in notifyDelayedApproval: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        }
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}