<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Proposal;
use App\Notifications\ProposalUpdatedDelay; // Pastikan untuk mengimpor kelas notifikasi
use Illuminate\Support\Facades\Notification; // Import Notification facade
use App\Models\User; // Import model User

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Menjadwalkan tugas untuk mengupdate status proposal
        $schedule->call(function () {
            $this->updateProposals(); // Call the update proposals function
            $this->notifyDelayedProposals(); // Call the notify delayed proposals function

            // Auto Close task as before
            \Log::info('Auto Close task is running.');

            $proposalsToClose = Proposal::where('status_cr', 'Closed With IT')
                ->where('updated_at', '<', now()->subDays(2))
                ->get();

            \Log::info('Proposals fetched for auto close: ' . $proposalsToClose->count());

            foreach ($proposalsToClose as $proposal) {
                $proposal->status_cr = 'Auto Close';
                $proposal->save();
                \Log::info('Updated proposal ID to Auto Close: ' . $proposal->id);
            }
        })->everyMinute(); // Atur frekuensi sesuai kebutuhan
    }

    /**
     * Update proposals to DELAY status.
     */
    protected function updateProposals()
    {
        \Log::info('Checking for proposals to update status.');

        $proposals = Proposal::where('status_cr', 'ON PROGRESS')
            ->where('estimated_date', '<', now()) // Mencari proposal dengan estimated_date yang sudah lewat
            ->get();

        \Log::info('Proposals fetched for delay check: ' . $proposals->count());

        foreach ($proposals as $proposal) {
            $proposal->status_cr = 'DELAY'; // Update status menjadi DELAY
            $proposal->save();
            \Log::info('Updated proposal ID to DELAY: ' . $proposal->id);
        }
    }

    /**
     * Notify users about delayed proposals, once per day.
     */
    protected function notifyDelayedProposals()
    {
        \Log::info('Notifying users about delayed proposals.');

        $delayedProposals = Proposal::where('status_cr', 'DELAY')->get();
        \Log::info('Proposals fetched for notification: ' . $delayedProposals->count());

        foreach ($delayedProposals as $proposal) {
            // Check if a notification has already been sent today
            if ($proposal->last_notified_at && $proposal->last_notified_at->isToday()) {
                continue; // Skip if already notified today
            }

            // Determine the department to notify
            $departmentToNotify = $proposal->departement === 'IT' ? 'IT' : $proposal->departement;

            // Mengambil pengguna yang berada di departemen yang ditentukan
            $usersToNotify = User::where('departement', $departmentToNotify)->get();

            foreach ($usersToNotify as $user) {
                // Kirim notifikasi email
                Notification::send($user, new ProposalUpdatedDelay($proposal));
                \Log::info('Notification sent to user ID: ' . $user->id . ' for proposal ID: ' . $proposal->id);
            }

            // Update the last notified timestamp
            $proposal->last_notified_at = now();
            $proposal->save();
        }
    }

    /**
     * Function to read proposals with status DELAY.
     */
    public function readDelayedProposals()
    {
        $delayedProposals = Proposal::where('status_cr', 'DELAY')->get();
        \Log::info('Fetched delayed proposals: ' . $delayedProposals->count());

        return $delayedProposals; // Return the delayed proposals
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
