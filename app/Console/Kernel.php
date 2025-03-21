<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Proposal;
use App\Notifications\ProposalUpdatedDelay; // Pastikan untuk mengimpor kelas notifikasi
use App\Notifications\ProposalUpdatedDelayApproval; // Pastikan untuk mengimpor kelas notifikasi
use Illuminate\Support\Facades\Notification; // Import Notification facade
use App\Models\User; // Import model User
use App\Helpers\WhatsAppHelper;
use App\Helpers\BladeHelper;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        \Log::info('Schedule is running');
        
        // Menjadwalkan tugas untuk mengupdate status proposal
        $schedule->call(function () {
            // Memanggil fungsi yang sudah ada
            $this->updateProposals(); // Call the update proposals function
            $this->notifyDelayedProposals(); // Call the notify delayed proposals function
            $this->notifyDelayedApproval(); // Call the notify delayed approval function

            // Auto Close task as before
            \Log::info('Auto Close task is running.');

            // Fetch proposals for auto close
            $proposalsToClose = Proposal::where('status_cr', ['Closed By IT', 'Closed By IT With Delay'])
                ->where('close_date', '<', now()->subDays(2))
                ->get();

            \Log::info('Proposals fetched for auto close: ' . $proposalsToClose->count());

            foreach ($proposalsToClose as $proposal) {
                $proposal->rating_it = '5';
                $proposal->rating_apk = '5';
                $proposal->status_cr = 'Auto Close';
                $proposal->save();
                \Log::info('Updated proposal ID to Auto Close: ' . $proposal->id);
            }
        })->everyMinute(); // Atur frekuensi sesuai kebutuhan   

        // Menjalankan fetch:itoutput setiap hari pada pukul 16:00
        $schedule->command('fetch:itoutput')->hourly();

        // Jika ingin dijalankan setiap hari pada jam tertentu (misal: 02:00 AM)
        // $schedule->command('fetch:itoutput')->dailyAt('02:00');
        // Jika ingin dijalankan setiap 30 menit
        // $schedule->command('fetch:itoutput')->everyThirtyMinutes();
        // $schedule->command('fetch:itoutput')->hourly();

        // Menjalankan backup setiap pada pukul 16:00
        $schedule->command('backup:run')->dailyAt('16:00');
    }

    /**
     * Update proposals to DELAY status.
     */
    protected function updateProposals()
    {
        \Log::info('Checking for proposals to update status.');

        // Query untuk proposal dengan status_barang yang sesuai dan action_it_date sudah lewat
        $proposals = Proposal::where('status_cr', 'ON PROGRESS')
        ->whereIn('status_barang', ['Pengadaan', 'Change Request', 'Pergantian', 'IT Helpdesk'])  // Menggunakan whereIn untuk beberapa nilai
        ->where('action_it_date', '<', now()) // Mencari proposal dengan action_it_date yang sudah lewat
        ->update(['status_cr' => 'DELAY']);  // Update status langsung

        \Log::info('Number of proposals updated to DELAY: ' . $proposals);

        // Query untuk proposal dengan status 'Peminjaman' dan estimated_date sudah lewat
        $proposals2 = Proposal::where('status_cr', 'ON PROGRESS')
            ->where('status_barang', 'Peminjaman')
            ->where('estimated_date', '<', now())
            ->update(['status_cr' => 'DELAY']);  // Update status langsung

        \Log::info('Proposals fetched and updated for delay check: ' . $proposals2);
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
            // Ensure last_notified_at is a Carbon instance
            $lastNotifiedAt = $proposal->last_notified_at ? \Carbon\Carbon::parse($proposal->last_notified_at) : null;

            if ($lastNotifiedAt && $lastNotifiedAt->isToday()) {
                continue; // Skip if already notified today
            }

            // Ambil user IT berdasarkan name yang cocok dengan it_user di proposal
            $itUsers = User::where('name', $proposal->it_user)
            ->whereHas('role', function ($query) {
                $query->where('name', 'it');
            })->get();

            // Ambil semua departemen dari user IT yang ditemukan
            $departments = $itUsers->pluck('departement')->unique();

            // Ambil user dengan role 'dh' atau 'divh' yang memiliki departement yang sama dengan $itUsers
            $itDhDivh = User::whereHas('role', function ($query) {
                $query->whereIn('name', ['dh', 'divh']);
            })
            ->where(function ($query) use ($proposal) {
                $query->where('departement', 'LIKE', $proposal->departement) // Cocok persis
                      ->orWhere('departement', 'LIKE', $proposal->departement . ',%') // Awal
                      ->orWhere('departement', 'LIKE', '%,' . $proposal->departement) // Akhir
                      ->orWhere('departement', 'LIKE', '%,' . $proposal->departement . ',%'); // Tengah
            })
            ->get();                

            // Cek jika tidak ada user ditemukan
            if ($itUsers->isEmpty() && $itDhDivh->isEmpty()) {
                \Log::info('No users found to notify for proposal ID: ' . $proposal->id);
                return; // Keluar dari fungsi jika tidak ada user
            }

            // Gabungkan semua user yang harus diberi notifikasi
            $usersToNotify = $itUsers->merge($itDhDivh)->unique('id');

            foreach ($usersToNotify as $user) {
                Notification::send($user, new ProposalUpdatedDelay($proposal));

                // Ambil user yang memiliki nomor WhatsApp berdasarkan email
                $usersWithWhatsApp = User::where('email', $user->email)
                ->whereNotNull('ext_phone')
                ->get();
                    
                // Render pesan WhatsApp dari Blade tetapi dalam format teks
                $whatsappMessage = strip_tags(view('mail.proposal_updated_delay', [
                    'proposal' => $proposal,
                ])->render());

                // Kirim notifikasi WhatsApp ke setiap user yang memiliki nomor HP
                foreach ($usersWithWhatsApp as $whatsappUser) {
                    if (!empty($whatsappUser->ext_phone)) {
                        \Log::info("Mengirim WhatsApp ke: " . $whatsappUser->ext_phone);
                        WhatsAppHelper::sendWhatsAppNotification($whatsappUser->ext_phone, $whatsappMessage);
                    } else {
                        \Log::warning("Nomor WhatsApp kosong untuk user: " . $whatsappUser->name);
                    }
                }
                
                \Log::info('Notification sent to user ID: ' . $user->id . ' for proposal ID: ' . $proposal->id);
            }

            // Update the last notified timestamp
            $proposal->last_notified_at = now();
            $proposal->save();
        }
    }


    /**
     * Memberi tahu pengguna tentang proposal yang tertunda, sekali per hari.
     */
    protected function notifyDelayedApproval()
    {
        \Log::info('Memberi tahu pengguna tentang proposal yang tertunda.');

        // Ambil proposal yang statusnya tertunda dan dibuat lebih dari 7 hari yang lalu
        $delayedProposals = Proposal::where('status_apr', 'pending')
            ->where('updated_at', '<', now()->subDays(7))
            ->get();

        \Log::info('Proposal yang diambil untuk pemberitahuan (PENDING): ' . $delayedProposals->count());

        foreach ($delayedProposals as $proposal) {
            // Pastikan last_notified_at adalah instance Carbon
            $lastNotifiedAt = $proposal->last_notified_at ? \Carbon\Carbon::parse($proposal->last_notified_at) : null;

            if ($lastNotifiedAt && $lastNotifiedAt->isToday()) {
                continue; // Lewati jika sudah diberi tahu hari ini
            }

            // Ambil token dari database untuk proposal
            $token = $proposal->token;

            if (!$token) {
                \Log::warning('Token tidak ditemukan untuk proposal ID: ' . $proposal->id);
                continue; // Lewati jika token tidak ada
            }

            $departmentToNotify = $proposal->departement;
            $companyCodeToNotify = $proposal->company_code;

            // Ambil pengguna di departemen yang ditentukan dan dengan peran 'dh'
            $usersToNotifyDh = User::whereHas('role', function ($query) {
                $query->where('name', 'dh');
            })
            ->where(function ($query) use ($departmentToNotify) {
                $query->where('departement', 'LIKE', $departmentToNotify) // Cocok persis
                        ->orWhere('departement', 'LIKE', $departmentToNotify . ',%') // Awal
                        ->orWhere('departement', 'LIKE', '%,' . $departmentToNotify) // Akhir
                        ->orWhere('departement', 'LIKE', '%,' . $departmentToNotify . ',%'); // Tengah
            })
            ->whereIn('company_code', $companyCodeToNotify) // Filter berdasarkan company code
            ->get();
            

            if ($usersToNotifyDh->isEmpty()) {
                \Log::info('Tidak ada pengguna yang ditemukan untuk diberi tahu untuk proposal ID: ' . $proposal->id);
                continue; // Lewati jika tidak ada pengguna
            }

            foreach ($usersToNotifyDh as $user) {
                try {
                    // Generate link untuk approval dan rejection
                    $approvalLink = route('proposal.approveDH', ['proposal_id' => $proposal->id, 'token' => $token]);
                    $rejectedLink = route('proposal.rejectDH', ['proposal_id' => $proposal->id, 'token' => $token]);

                    // Siapkan data untuk dikirim ke notifikasi
                    $data = [
                        'proposal' => $proposal,
                        'approvalLink' => $approvalLink,
                        'rejectedLink' => $rejectedLink,
                    ];

                    // Kirimkan data tersebut ke dalam notifikasi
                    Notification::send($user, new ProposalUpdatedDelayApproval($data));

                    // Ambil user yang memiliki nomor WhatsApp berdasarkan email
                    $usersWithWhatsApp = User::where('email', $user->email)
                    ->whereNotNull('ext_phone')
                    ->get();
                        
                    // Render pesan WhatsApp dari Blade tetapi dalam format teks
                    $whatsappMessage = strip_tags(view('mail.proposal_updated_delay_approval', [
                        'proposal' => $proposal,
                        'approvalLink' => $approvalLink,
                        'rejectedLink' => $rejectedLink
                    ])->render());

                    // Kirim notifikasi WhatsApp ke setiap user yang memiliki nomor HP
                    foreach ($usersWithWhatsApp as $whatsappUser) {
                        if (!empty($whatsappUser->ext_phone)) {
                            \Log::info("Mengirim WhatsApp ke: " . $whatsappUser->ext_phone);
                            WhatsAppHelper::sendWhatsAppNotification($whatsappUser->ext_phone, $whatsappMessage);
                        } else {
                            \Log::warning("Nomor WhatsApp kosong untuk user: " . $whatsappUser->name);
                        }
                    }

                    \Log::info('Pemberitahuan dikirim ke pengguna ID: ' . $user->id . ' untuk proposal ID: ' . $proposal->id);


                } catch (\Exception $e) {
                    \Log::error('Gagal mengirim pemberitahuan ke pengguna ID: ' . $user->id . ' untuk proposal ID: ' . $proposal->id . '. Kesalahan: ' . $e->getMessage());
                }
            }

            // Perbarui timestamp terakhir diberi tahu
            $proposal->last_notified_at = now();
            $proposal->save();
        }

        // Ambil proposal yang statusnya 'partially_approved' dan dibuat lebih dari 7 hari yang lalu
        $delayedProposalsDivh = Proposal::where('status_apr', 'partially_approved')
            ->where('updated_at', '<', now()->subDays(7))
            ->get();

        \Log::info('Proposal yang diambil untuk pemberitahuan (partially_approved): ' . $delayedProposalsDivh->count());

        foreach ($delayedProposalsDivh as $proposal) {
            // Pastikan last_notified_at adalah instance Carbon
            $lastNotifiedAt = $proposal->last_notified_at ? \Carbon\Carbon::parse($proposal->last_notified_at) : null;

            if ($lastNotifiedAt && $lastNotifiedAt->isToday()) {
                continue; // Lewati jika sudah diberi tahu hari ini
            }

            // Ambil token dari database untuk proposal
            $token = $proposal->token;

            if (!$token) {
                \Log::warning('Token tidak ditemukan untuk proposal ID: ' . $proposal->id);
                continue; // Lewati jika token tidak ada
            }

            $departmentToNotify = $proposal->departement;
            $companyCodeToNotify = $proposal->company_code;

            // Ambil pengguna di departemen yang ditentukan dan dengan peran 'divh'
            $usersToNotifyDivh = User::whereHas('role', function ($query) {
                $query->where('name', 'divh');
            })
            ->where(function ($query) use ($departmentToNotify) {
                $query->where('departement', 'LIKE', $departmentToNotify) // Cocok persis
                        ->orWhere('departement', 'LIKE', $departmentToNotify . ',%') // Awal
                        ->orWhere('departement', 'LIKE', '%,' . $departmentToNotify) // Akhir
                        ->orWhere('departement', 'LIKE', '%,' . $departmentToNotify . ',%'); // Tengah
            })
            ->whereIn('company_code', $companyCodeToNotify) // Filter berdasarkan company code
            ->get();

            if ($usersToNotifyDivh->isEmpty()) {
                \Log::info('Tidak ada pengguna yang ditemukan untuk diberi tahu untuk proposal ID: ' . $proposal->id);
                continue; // Lewati jika tidak ada pengguna
            }

            foreach ($usersToNotifyDivh as $user) {
                try {
                    // Generate link untuk approval dan rejection
                    $approvalLink = route('proposal.approveDIVH', ['proposal_id' => $proposal->id, 'token' => $token]);
                    $rejectedLink = route('proposal.rejectDIVH', ['proposal_id' => $proposal->id, 'token' => $token]);

                    // Siapkan data untuk dikirim ke notifikasi
                    $data = [
                        'proposal' => $proposal,
                        'approvalLink' => $approvalLink,
                        'rejectedLink' => $rejectedLink,
                    ];

                    // Kirimkan data tersebut ke dalam notifikasi
                    Notification::send($user, new ProposalUpdatedDelayApproval($data));

                    // Ambil user yang memiliki nomor WhatsApp berdasarkan email
                    $usersWithWhatsApp = User::where('email', $user->email)
                    ->whereNotNull('ext_phone')
                    ->get();
                        
                    // Render pesan WhatsApp dari Blade tetapi dalam format teks
                    $whatsappMessage = strip_tags(view('mail.proposal_updated_delay_approval', [
                        'proposal' => $proposal,
                        'approvalLink' => $approvalLink,
                        'rejectedLink' => $rejectedLink
                    ])->render());

                    // Kirim notifikasi WhatsApp ke setiap user yang memiliki nomor HP
                    foreach ($usersWithWhatsApp as $whatsappUser) {
                        if (!empty($whatsappUser->ext_phone)) {
                            \Log::info("Mengirim WhatsApp ke: " . $whatsappUser->ext_phone);
                            WhatsAppHelper::sendWhatsAppNotification($whatsappUser->ext_phone, $whatsappMessage);
                        } else {
                            \Log::warning("Nomor WhatsApp kosong untuk user: " . $whatsappUser->name);
                        }
                    }

                    \Log::info('Pemberitahuan dikirim ke pengguna ID: ' . $user->id . ' untuk proposal ID: ' . $proposal->id);
                } catch (\Exception $e) {
                    \Log::error('Gagal mengirim pemberitahuan ke pengguna ID: ' . $user->id . ' untuk proposal ID: ' . $proposal->id . '. Kesalahan: ' . $e->getMessage());
                }
            }

            // Perbarui timestamp terakhir diberi tahu
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
