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
            \Log::info('Checking for proposals to update status.');

            $proposals = Proposal::where('status_cr', 'ON PROGRESS')
                ->where('estimated_date', '<', now()) // Mencari proposal dengan estimated_date yang sudah lewat
                ->get();

            \Log::info('Proposals fetched for delay check: ' . $proposals->count());

            foreach ($proposals as $proposal) {
                $proposal->status_cr = 'DELAY'; // Update status menjadi DELAY
                $proposal->save();
                \Log::info('Updated proposal ID to DELAY: ' . $proposal->id);

                // Mengambil pengguna yang berada di departemen yang sama dengan proposal
                $usersToNotify = User::where('departement', $proposal->departement)->get();

                foreach ($usersToNotify as $user) {
                    // Kirim notifikasi email
                    Notification::send($user, new ProposalUpdatedDelay($proposal));
                    \Log::info('Notification sent to user ID: ' . $user->id . ' for proposal ID: ' . $proposal->id);
                }
            }

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
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
