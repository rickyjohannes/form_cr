<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Proposal; 

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    // protected function schedule(Schedule $schedule): void
    // {
    //     // $schedule->command('inspire')->hourly();
    // }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            \Log::info('Auto Close task is running.');
        
            $proposals = Proposal::where('status_cr', 'Closed With IT')
                ->where('updated_at', '<=', now()->subDays(2))
                ->get();
        
            foreach ($proposals as $proposal) {
                $proposal->status_cr = 'Auto Close';
                $proposal->save();
                \Log::info('Updated proposal ID: ' . $proposal->id);
            }
        })->everyMinute();   // Atur frekuensi sesuai kebutuhan
    }




}
