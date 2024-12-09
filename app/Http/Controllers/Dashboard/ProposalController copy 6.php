<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\ProposalCR;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\Approval;
use App\Notifications\Rejected;
use App\Notifications\ApprovalDIVH;
use App\Notifications\ProposalUpdated;
use App\Notifications\ProposalUpdatedClosed;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; // Pastikan ini di atas file
use Carbon\Carbon;

class ProposalController extends Controller
{
    public function index() 
    {
        $role = Auth::user()->role->name;

        if($role == 'user') {
            return $this->user();
        } elseif ($role == 'it'){
            return $this->it();
        } else {
            return $this->admin();
        }
    }

    private function admin()
    {
        $pending = Proposal::where('status_apr', 'pending')->get();
        $approved = Proposal::where('status_apr', 'fully_approved')->get();
        $rejected = Proposal::where('status_apr', 'rejected')->get();
        $proposalpen = Proposal::where('status_apr', 'pending')->orWhere('status_apr', 'partially_approved')->where('status_apr', '!=', 'rejected')->get();
        $proposalpendivh = Proposal::where('status_apr', 'partially_approved')->orWhere('status_apr', 'pending')->where('status_apr', '!=', 'rejected')->get();
        $proposalapr = Proposal::where('status_apr', 'fully_approved')->where('status_apr', 'fully_approved')->get();
        $proposalrej = Proposal::where('status_apr', 'rejected') ->orWhere('status_apr', 'rejected')->get();
        // $proposals = Proposal::orderBy('created_at', 'desc')->get();
        
        $data = [
            'title' => 'Dashboard | DPM',
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
            'proposalpen' => $proposalpen,
            'proposalpendivh' => $proposalpendivh,
            'proposalapr' => $proposalapr,
            'proposalrej' => $proposalrej
        ];
        
        return view('dashboard.proposal.administrator', $data);
    }

    private function user()
    {
        $id = Auth::user()->id;

        // Mulai dengan query builder
        $proposalsQuery = Proposal::where('user_id', $id);  // Ambil proposal berdasarkan user_id

        // Memeriksa rute yang aktif dan menentukan tampilan yang sesuai
        if (request()->routeIs('proposal.*')) {
            // Jika rute yang dipanggil adalah proposal.* (Form Proposal)
            $view = 'dashboard.proposal.user';  // Halaman untuk Form Proposal
        } elseif (request()->routeIs('proposalcr.*')) {
            // Jika rute yang dipanggil adalah proposalcr.* (Form Change Request)
            // Mengambil proposal hanya yang memiliki status 'Change Request'
            $proposalsQuery->where('status_barang', 'Change Request');
            $view = 'dashboard.proposal.user_cr';  // Halaman untuk Form Change Request
        } else {
            // Default view jika tidak ada yang cocok
            $view = 'dashboard.proposal.user';
        }

        // Memeriksa apakah ada parameter 'status_barang' yang dipilih
        if (request()->has('status_barang') && request()->status_barang != '') {
            // Filter berdasarkan status_barang jika ada
            $proposalsQuery->where('status_barang', request()->status_barang);
        }

        // Menjalankan query untuk mendapatkan data proposal yang sudah difilter
        $proposals = $proposalsQuery->get();  // Panggil get() hanya sekali di sini

        // Data yang akan dikirim ke tampilan
        $data = [
            'title' => 'Dashboard | DPM',
            'proposals' => $proposals  // Kirim data proposals ke tampilan
        ];

        // Mengembalikan tampilan dengan data yang telah dipersiapkan
        return view($view, $data);
    }

 

    public function approval(string $id, string $status) 
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->update(['status' => $status]);

        return redirect()->route('proposal.index')->with('success', 'CR status updated successfully.');
    }

    public function print(string $id)
    {
        // Fetch the proposal by its ID
        $proposal = Proposal::findOrFail($id);
    
        // Ambil pengguna yang memiliki departemen yang sama dengan departemen proposal
        $user = \App\Models\User::join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.departement', $proposal->departement)
            ->first(['users.name', 'roles.name as role_name']);
        
        // Pastikan jika user ditemukan, kita kirimkan data user ke view
        if (!$user) {
            $user = (object)[
                'name' => 'Not Found',
                'role_name' => 'Not Found'
            ];
        }
    
        // Load the view to generate the PDF
        $pdf = Pdf::loadView('dashboard.proposal.print', [
            'proposal' => $proposal,
            'user' => $user,  // Kirimkan data user ke view
        ]);
    
        // Download the generated PDF with a specific filename
        return $pdf->download('form_cr_approved_' . $id . '.pdf');  // Use dynamic naming to avoid overwriting files
    }
    
    public function create()
    {
        $data = ['title' => 'CR | DPM'];
        return view('dashboard.proposal.create', $data);
    }

    public function store(Request $request)
    {
        // Generate nomor transaksi
        $noTransaksi = Proposal::generateNoTransaksi();

        // Validasi input
        $request->validate([
            'status_barang' => 'required|array',
            'kategori' => 'required|array',
            'facility' => 'required_without:other_facility|array', // Facility harus diisi kecuali ada other_facility
            'user_note' => 'nullable|string',
            'no_asset_user' => 'nullable|string',  // Validasi untuk no_asset_user (nullable)
            'file' => 'nullable|mimes:pdf,xlsx,xls,csv,jpg,png,mp4,pptx|max:204800',
            'other_facility' => 'nullable|string|max:255', // Validasi untuk other facility
            'estimated_start_date' => 'nullable|date_format:d/m/Y H:i', // Validasi format tanggal
            'estimated_date' => 'nullable|date_format:d/m/Y H:i', // Validasi format tanggal
        ]);

        // Mengupload file jika ada
        $filename = null;
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move(public_path('uploads'), $filename);  // Menyimpan file dengan Laravel storage
        }
        \Log::info('File Uploaded: ' . $filename);

        // Mengonversi arrays ke strings
        $status_barang = implode(',', $request->input('status_barang'));
        $kategori = implode(',', $request->input('kategori'));
        $facility = $request->input('facility') ? implode(',', $request->input('facility')) : '';

        // Ambil nilai other_facility dan tambahkan jika ada
        $other_facility = $request->input('other_facility');
        if ($other_facility) {
            $facility = $facility ? $facility . ',' . $other_facility : $other_facility; // Gabungkan jika fasilitas lain ada
        }

        // Ambil informasi pengguna
        $userRequest = auth()->user()->name;
        $userStatus = auth()->user()->user_status;
        $userDepartement = auth()->user()->departement;

        // Validasi data pengguna
        if (empty($userRequest) || empty($userStatus) || empty($userDepartement)) {
            return redirect()->back()->withErrors(['error' => 'User, Status, or Departement cannot be empty.']);
        }

        // Generate token untuk proposal
        $token = Str::random(60);  // Menggunakan Str::random untuk generate token

        // Buat instance Proposal baru
        $proposal = new Proposal();
        $proposal->no_transaksi = $noTransaksi;
        $proposal->user_request = $userRequest;
        $proposal->user_status = $userStatus;
        $proposal->departement = $userDepartement;
        $proposal->ext_phone = $request->input('ext_phone');
        $proposal->status_barang = $status_barang;
        $proposal->kategori = $kategori;
        $proposal->facility = $facility;
        $proposal->user_note = $request->input('user_note');
        $proposal->no_asset_user = $request->input('no_asset_user'); // Menyimpan nilai no_asset_user
        $proposal->file = $filename;
        $proposal->user_id = auth()->id();
        $proposal->token = $token;

        $statusBarang = $request->input('status_barang');
        $estimatedDate = null;
        $estimatedStartDate = null;

        // Periksa status_barang untuk menentukan input tanggal mana yang digunakan
        if (in_array('Peminjaman', $statusBarang)) {
            // Ambil tanggal pengembalian
            if ($request->has('estimated_start_date')) {
                $rawDate = $request->input('estimated_start_date');
                try {
                    $estimatedStartDate = Carbon::createFromFormat('d/m/Y H:i', $rawDate)->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors(['estimated_start_date' => 'Tanggal Peminjaman tidak valid.']);
                }
            }
        }

        // Periksa status_barang untuk menentukan input tanggal mana yang digunakan
        if (in_array('Peminjaman', $statusBarang)) {
            // Ambil tanggal pengembalian
            if ($request->has('estimated_date_pengembalian')) {
                $rawDate = $request->input('estimated_date_pengembalian');
                try {
                    $estimatedDate = Carbon::createFromFormat('d/m/Y H:i', $rawDate)->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors(['estimated_date_pengembalian' => 'Tanggal Pengembalian tidak valid.']);
                }
            }
            
        } elseif (in_array('Change Request', $statusBarang)) {
            // Ambil tanggal permintaan
            if ($request->has('estimated_date_permintaan')) {
                $rawDate = $request->input('estimated_date_permintaan');
                try {
                    $estimatedDate = Carbon::createFromFormat('d/m/Y H:i', $rawDate)->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors(['estimated_date_permintaan' => 'Tanggal Permintaan tidak valid.']);
                }
            }
        }

        // Jika ada tanggal yang valid, simpan ke kolom estimated_date
        if ($estimatedDate) {
            $proposal->estimated_date = $estimatedDate; // Simpan ke kolom estimated_date
        }

        // Jika ada tanggal yang valid, simpan ke kolom estimated_date
        if ($estimatedStartDate) {
            $proposal->estimated_start_date = $estimatedStartDate; // Simpan ke kolom estimated_date
        }


        $proposal->save();

        // Ambil email penerima berdasarkan user dengan role 'dh' dan departemen yang sesuai
        $emailRecipient = $this->getEmailRecipientForDh(Auth::user());

        // Generate link untuk approval dan rejection
        $approvalLink = route('proposal.approveDH', ['proposal_id' => $proposal->id, 'token' => $token]);
        $rejectedLink = route('proposal.rejectDH', ['proposal_id' => $proposal->id, 'token' => $token]);

        // Siapkan data untuk notifikasi
        $data = [
            'proposal' => $proposal,
            'approvalLink' => $approvalLink,
            'rejectedLink' => $rejectedLink,
        ];

        // Kirim notifikasi melalui email
        \Notification::route('mail', $emailRecipient)
            ->notify(new Approval($data));  // Mengirimkan data sebagai array

        // Cek jika proposal berhasil disimpan, kemudian redirect
        return redirect()->route('proposal.index')->with('success', 'CR successfully created.');
    }

    private function getEmailRecipientForDh($user)
    {
        // Ambil department dari pengguna yang sedang login
        $userDepartement = auth()->user()->departement; 
    
        \Log::info('User Department: ' . $userDepartement);
    
        // Cari pengguna dengan role 'dh' dan department yang sama
        $dhUsers = User::whereHas('role', function ($query) {
            $query->where('name', 'dh');
        })->where('departement', $userDepartement)->get(); // Gunakan get() untuk mengambil semua pengguna
    
        // Log jumlah pengguna yang ditemukan
        \Log::info('Number of DH Users Found: ' . $dhUsers->count());
    
        // Jika tidak ada pengguna ditemukan, gunakan fallback
        if ($dhUsers->isEmpty()) {
            return 'helpdesk@dp.dharmap.com'; // Fallback jika tidak ada
        }
    
        // Ambil email dari pengguna pertama yang ditemukan
        return $dhUsers->pluck('email')->toArray(); // Mengembalikan array email
    }

    public function show(string $id)
    {
        $proposal = Proposal::findOrFail($id);
        $data = [
            'title' => 'CR | DPM',
            'proposal' => $proposal
        ];
        return view('dashboard.proposal.detail', $data);
    }

    public function edit($id)
    {
        try {
            // Retrieve the proposal by ID
            $proposal = Proposal::findOrFail($id);

            // Convert status_barang dan facility menjadi array
            $status_barang = !empty($proposal->status_barang) ? explode(',', $proposal->status_barang) : [];
            $facility = !empty($proposal->facility) ? explode(',', $proposal->facility) : [];
            $other_facility = $proposal->other_facility;

            // Log for debugging
            \Log::info('Other Facility:', [$other_facility]);
            \Log::info('Other Facility Value: ' . $other_facility);
            \Log::info('Proposal Data: ', $proposal->toArray());

            // Passing data to the view
            return view('dashboard.proposal.edit', compact('proposal', 'status_barang', 'facility', 'other_facility'));
        } catch (ModelNotFoundException $e) {
            // Redirect if proposal not found
            return redirect()->route('proposals.index')->with('error', 'Proposal not found.');
        }
    }

    public function editit($id)
    {
        try {
            // Retrieve the proposal by ID
            $proposal = Proposal::findOrFail($id);

            // Convert status_barang dan facility menjadi array
            $status_barang = !empty($proposal->status_barang) ? explode(',', $proposal->status_barang) : [];
            $facility = !empty($proposal->facility) ? explode(',', $proposal->facility) : [];
            $other_facility = $proposal->other_facility;

            // Log for debugging
            \Log::info('Other Facility:', [$other_facility]);
            \Log::info('Other Facility Value: ' . $other_facility);
            \Log::info('Proposal Data: ', $proposal->toArray());

            // Passing data to the view
            return view('dashboard.proposal.editit', compact('proposal', 'status_barang', 'facility', 'other_facility'));
        } catch (ModelNotFoundException $e) {
            // Redirect if proposal not found
            return redirect()->route('proposals.index')->with('error', 'Proposal not found.');
        }
    }

    public function update(Request $request, string $id)
    {
        // Validasi hanya file, data lain dibiarkan tidak berubah jika tidak ada input
        $validated = $request->validate([
            'file' => 'nullable|mimes:pdf,xlsx,xls,csv,jpg,png,mp4,pptx|max:204800',
        ]);

        // Temukan proposal berdasarkan ID
        $proposal = Proposal::findOrFail($id);

        // Cek dan simpan file jika ada
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($proposal->file && file_exists(public_path('uploads/' . $proposal->file))) {
                \Storage::delete('uploads/' . $proposal->file);
            }

            // Generate filename dan simpan file baru
            $filename = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move(public_path('uploads'), $filename);
            $proposal->file = $filename;
            \Log::info('File Uploaded: ' . $filename);
        }

        // Hanya update data yang berubah, jika ada
        $proposal->update([
            // Cek dan update hanya field yang ada dalam request
            'status_barang' => $request->filled('status_barang') ? implode(',', array_map('trim', $request->status_barang)) : $proposal->status_barang,
            'facility' => $request->filled('facility') ? implode(',', array_map('trim', $request->facility)) : $proposal->facility,
            'other_facility' => $request->filled('other_facility') ? trim($request->other_facility) : $proposal->other_facility,
            'user_note' => $request->filled('user_note') ? $request->user_note : $proposal->user_note,
            'no_asset_user' => $request->filled('no_asset_user') ? $request->no_asset_user : $proposal->no_asset_user,
            'file' => isset($filename) ? $filename : $proposal->file,  // Jika ada file baru, update file
        ]);

        \Log::info('Proposal updated with ID: ' . $proposal->id);
        \Log::info('Redirecting after successful update.');

        return redirect()->route('proposal.index')->with('success', 'CR successfully updated.');
    }

    public function updateit(Request $request, string $id) 
    {
        // Temukan proposal
        $proposal = Proposal::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'action_it_date' => 'nullable|date',
            'it_analys' => 'nullable|max:255',
            'file' => 'mimes:pdf,xlsx,xls,csv,jpg,png,mp4,pptx|max:204800',
            'file_it' => 'mimes:pdf,xlsx,xls,csv,jpg,png,mp4,pptx|max:204800',
            'no_asset' => 'nullable|string',
        ]);

        // Sanitasi input untuk facility dan status_barang
        $facilityString = isset($validated['facility']) ? implode(',', array_map('trim', $validated['facility'])) : null;
        $statusBarangString = isset($validated['status_barang']) ? implode(',', array_map('trim', $validated['status_barang'])) : null;

        // Cek dan simpan file jika ada
        $filename = $filenameit = null;
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move(public_path('uploads'), $filename);
        }
        if ($request->hasFile('file_it')) {
            $filenameit = time() . '.' . $request->file('file_it')->extension();
            $request->file_it->move(public_path('uploads'), $filenameit);
        }

        // Dapatkan nama pengguna dan nilai estimated_date sebelumnya
        $user = auth()->user();
        $it_user = $user->name ?? null;
        $oldActionDate = $proposal->action_it_date;

        // Tentukan estimated_date dan close_date
        $ActionDate = $validated['action_it_date'] ?? $oldActionDate;
        
        // Tentukan nilai it_user berdasarkan action_it_date
        if ($ActionDate && !$proposal->it_user) {
            $it_user = $user->name ?? 'IT User'; // Sesuaikan dengan default yang diinginkan
        }

        // Pastikan close_date tidak diperbarui jika sudah ada nilainya
        $close_date = !empty($proposal->close_date) ? $proposal->close_date : (!empty($validated['file_it']) ? now() : null);

        // Tentukan status_cr
        $closedStatuses = ['Closed By IT','Closed With Delay', 'Closed By IT With Delay', 'Auto Closed', 'Closed'];

        if (in_array($proposal->status_cr, $closedStatuses)) {
            // Jika status_cr adalah salah satu status yang tertutup, biarkan tetap
            $status_cr = $proposal->status_cr;
        } else {
            // Jika status_cr bukan salah satu yang tertutup, set menjadi 'ON PROGRESS'
            $status_cr = 'ON PROGRESS';
        }

        // Terapkan perubahan status_cr pada proposal dan simpan
        $proposal->status_cr = $status_cr;
        $proposal->save();

        // Kirim notifikasi jika file_it diisi
        if (!empty($validated['file_it'])) {
            // Menambahkan pengecekan status_cr
            if ($proposal->status_cr == 'ON PROGRESS') {
                $status_cr = 'Closed By IT'; // Jika status_cr adalah 'ON PROGRESS'
            } elseif ($proposal->status_cr == 'DELAY') {
                $status_cr = 'Closed By IT With Delay'; // Jika status_cr adalah 'DELAY'
            }

            // Ambil email penerima
            $emailRecipient = User::where('departement', $proposal->departement)->pluck('email'); 

            try {
                // Pastikan untuk mengupdate data proposal sebelum mengirim notifikasi
                $proposal->it_analys = $validated['it_analys'] ?? $proposal->it_analys;
                $proposal->no_asset = $validated['no_asset'] ?? $proposal->no_asset;
                $proposal->file_it = $filenameit ?? $proposal->file_it;
                $proposal->save();

                // Pastikan close_date sudah terupdate sebelum mengirim notifikasi
                if ($close_date !== null) {
                    $proposal->close_date = $close_date;
                    $proposal->save();
                }

                // Kirim notifikasi
                \Notification::route('mail', $emailRecipient)
                    ->notify(new ProposalUpdatedClosed($proposal)); // Kirim instance Proposal
                Log::info('Email notification sent successfully for Proposal ID: ' . $proposal->id);
            } catch (\Exception $e) {
                Log::error('Failed to send email notification for Proposal ID: ' . $proposal->id . '. Error: ' . $e->getMessage());
            }
        } else {
            // Tidak ada file yang di-upload, jadi status_cr tetap sama
            $status_cr = $proposal->status_cr; 
        }

        // Update proposal dan pastikan nilai no_asset disimpan
        $dataToUpdate = [
            'status_cr' => $status_cr,
            'action_it_date' => $ActionDate,
            'it_user' => $it_user, // Pastikan it_user diupdate jika action_it_date diubah
            'it_analys' => $validated['it_analys'] ?? $proposal->it_analys,
            'close_date' => $close_date, // Tidak akan diubah jika sudah ada nilai
            'no_asset' => $validated['no_asset'] ?? $proposal->no_asset,  // Pastikan 'no_asset' disimpan
            'file' => $filename ?? $proposal->file, // Jika ada file baru, update file
            'file_it' => $filenameit ?? $proposal->file_it,
        ];

        // Hanya update jika ada perubahan pada field status_barang atau facility
        if ($facilityString !== null) {
            $dataToUpdate['facility'] = $facilityString;
        }
        if ($statusBarangString !== null) {
            $dataToUpdate['status_barang'] = $statusBarangString;
        }

        // Update proposal hanya dengan nilai yang berubah atau tidak NULL
        $proposal->update($dataToUpdate);

        // Log perubahan untuk debugging
        Log::info("Proposal updated: ID {$proposal->id} - Estimated Date changed from {$oldActionDate} to {$ActionDate}");

        // Kirim notifikasi jika estimated_date telah diperbarui
        if ($ActionDate !== $oldActionDate) {
            try {
                $this->notifyProposalUpdate($proposal);
                Log::info('Email notification sent successfully for Proposal ID: ' . $proposal->id);
            } catch (\Exception $e) {
                Log::error('Failed to send email notification for Proposal ID: ' . $proposal->id . '. Error: ' . $e->getMessage());
            }
        }

        return redirect()->route('proposal.index')->with('success', 'CR successfully updated.');
    }


    public function destroy(string $id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->delete();

        return redirect()->route('proposal.index')->with('success', 'CR successfully deleted.');
    }

    public function approveDH(Request $request, string $proposal_id)
    {
        // Dapatkan token dari parameter
        $token = $request->route('token'); // Ambil token dari URL

        // Temukan proposal berdasarkan ID dan token
        $proposal = Proposal::where('id', $proposal_id)->where('token', $token)->first();

        if (!$proposal) {
            return response()->json(['error' => 'Unauthorized or invalid token'], 403);
        }

        // Cek apakah status proposal sudah fully_approved atau rejected
        if (in_array($proposal->status_apr, ['partially_approved','fully_approved', 'rejected'])) {
            return response()->json(['error' => 'This request cannot be updated because it is already ' . $proposal->status_apr], 400);
        }

        // Update status proposal dan field date_approve_dh
        $proposal->update([
            'status_apr' => 'partially_approved',
            'actiondate_apr' => now(), // Menyimpan tanggal saat ini
        ]);

        // Dapatkan email penerima dari pengguna dengan role 'divh' dan departement yang sama
        $divhItUser = User::where('departement', $proposal->departement)
        ->whereHas('role', function ($query) {
            $query->where('name', 'divh');
        })->first();

        // Cek apakah pengguna ada dan ambil email mereka
        $emailRecipient = $divhItUser ? $divhItUser->email : 'helpdesk@dp.dharmap.com'; // Fallback jika tidak ada

        // Generate approval link
        $approvalLink = route('proposal.approveDIVH', ['proposal_id' => $proposal->id, 'token' => $token]);
        $rejectedLink = route('proposal.rejectDIVH', ['proposal_id' => $proposal->id, 'token' => $token]);

        // Buat data untuk dikirim
        $data = [
            'proposal' => $proposal,
            'approvalLink' => $approvalLink,
            'rejectedLink' => $rejectedLink,
        ];

        // Kirim notifikasi
        \Notification::route('mail', $emailRecipient)
            ->notify(new Approval($data)); // Kirim data sebagai array

        // Cek apakah pengguna terautentikasi
        if (!auth()->check()) {
            return view('approveDH', [
                'proposalNo_transaksi' => $proposal->no_transaksi,
                'proposalUserRequest' => $proposal->user_request,
                'proposalPosition' => $proposal->user_status,
                'proposalDepartement' => $proposal->departement,
                'proposalNoHandphone' => $proposal->ext_phone,
                'proposalStatusBarang' => $proposal->status_barang,
                'proposalKategori' => $proposal->kategori,
                'proposalFacility' => $proposal->facility,
                'proposalUserNote' => $proposal->user_note,
                'proposalAssetUser' => $proposal->no_asset_user,
                'proposalCreated' => $proposal->created_at,
                'proposalEstimatedStartDate' => $proposal->estimated_start_date,
                'proposalEstimatedDate' => $proposal->estimated_date,
            ]);
        } else {
            return redirect()->route('proposal.index')->with('success', 'DH status approved successfully.');
        }
    }

    public function rejectDH(Request $request, string $proposal_id)
    {
        // Get the token from the request
        $token = $request->route('token'); // Or use $request->input('token')
    
        // Find the proposal by ID and token
        $proposal = Proposal::where('id', $proposal_id)->where('token', $token)->first();
    
        if (!$proposal) {
            return response()->json(['error' => 'Unauthorized or invalid token'], 403);
        }

        // Cek apakah status proposal sudah fully_approved atau rejected
        if (in_array($proposal->status_apr, ['fully_approved', 'partially_approved'])) {
            return response()->json(['error' => 'This request cannot be updated because it is already ' . $proposal->status_apr], 400);
        }

         // Update status proposal dan field date_approve_dh
         $proposal->update([
            'status_apr' => 'rejected',
            'status_cr' => 'Closed By Rejected',
            'actiondate_apr' => now(), // Menyimpan tanggal saat ini
        ]);

        // Get the email recipient from the user who created the proposal
        $emailRecipient = $proposal->user->email ?? 'helpdesk@dp.dharmap.com'; // Fallback jika tidak ada

        // Buat data untuk dikirim
        $data = [
            'proposal' => $proposal,
        ];

        // Kirim notifikasi
        \Notification::route('mail', $emailRecipient)
            ->notify(new Rejected($data)); // Kirim data sebagai array
    
        // Cek apakah pengguna terautentikasi
        if (!auth()->check()) {
            return view('rejectDH', [
                'proposalNo_transaksi' => $proposal->no_transaksi,
                'proposalUserRequest' => $proposal->user_request,
                'proposalPosition' => $proposal->user_status,
                'proposalDepartement' => $proposal->departement,
                'proposalNoHandphone' => $proposal->ext_phone,
                'proposalStatusBarang' => $proposal->status_barang,
                'proposalKategori' => $proposal->kategori,
                'proposalFacility' => $proposal->facility,
                'proposalUserNote' => $proposal->user_note,
                'proposalAssetUser' => $proposal->no_asset_user,
                'proposalCreated' => $proposal->created_at,
                'proposalEstimatedStartDate' => $proposal->estimated_start_date,
                'proposalEstimatedDate' => $proposal->estimated_date,
            ]);
        } else {
            return redirect()->route('proposal.index')->with('success', 'DH status rejected successfully.');
        }
    }

    public function approveDIVH(Request $request, string $proposal_id)
    {
        // Get the token from the request
        $token = $request->route('token'); // Atau gunakan $request->input('token')

        // Find the proposal by ID and token
        $proposal = Proposal::where('id', $proposal_id)->where('token', $token)->first();

        if (!$proposal) {
            return response()->json(['error' => 'Unauthorized or invalid token'], 403);
        }

        // Cek apakah status proposal sudah fully_approved atau rejected
        if (in_array($proposal->status_apr, ['fully_approved', 'rejected'])) {
            return response()->json(['error' => 'This request cannot be updated because it is already ' . $proposal->status_apr], 400);
        }

        // Update status proposal dan field date_approve_dh
        $proposal->update([
            'status_apr' => 'fully_approved',
            'status_cr' => 'Open To IT',
            'actiondate_apr' => now(), // Menyimpan tanggal saat ini
        ]);

        // Get the email recipient from the user who created the proposal
        $emailRecipient = $proposal->user->email ?? 'helpdesk@dp.dharmap.com'; // Fallback jika tidak ada

        // Buat data untuk dikirim
        $data = [
            'proposal' => $proposal,
        ];

        // Kirim notifikasi
        \Notification::route('mail', $emailRecipient)
            ->notify(new ApprovalDIVH($data)); // Kirim data sebagai array

        //<!-- Untuk Notify Email To All Dept IT-->
        // // Kirim notifikasi ke semua pengguna di departemen IT
        // $itUsers = User::where('departement', 'IT')->pluck('email');

        // foreach ($itUsers as $itUserEmail) {
        //     \Notification::route('mail', $itUserEmail)
        //         ->notify(new ApprovalDIVH($data)); // Kirim data yang sama
        // }
        //<!-- -->

        // Cek apakah pengguna terautentikasi
        if (!auth()->check()) {
            return view('approveDIVH', [
                'proposalNo_transaksi' => $proposal->no_transaksi,
                'proposalUserRequest' => $proposal->user_request,
                'proposalPosition' => $proposal->user_status,
                'proposalDepartement' => $proposal->departement,
                'proposalNoHandphone' => $proposal->ext_phone,
                'proposalStatusBarang' => $proposal->status_barang,
                'proposalKategori' => $proposal->kategori,
                'proposalFacility' => $proposal->facility,
                'proposalUserNote' => $proposal->user_note,
                'proposalAssetUser' => $proposal->no_asset_user,
                'proposalCreated' => $proposal->created_at,
                'proposalEstimatedStartDate' => $proposal->estimated_start_date,
                'proposalEstimatedDate' => $proposal->estimated_date,
            ]);
        } else {
            return redirect()->route('proposal.index')->with('success', 'DIVH status approved successfully.');
        }
    }


    public function rejectDIVH(Request $request, string $proposal_id)
    {
        // Get the token from the request
        $token = $request->route('token'); // Or use $request->input('token')

        // Find the proposal by ID and token
        $proposal = Proposal::where('id', $proposal_id)->where('token', $token)->first();

        if (!$proposal) {
            return response()->json(['error' => 'Unauthorized or invalid token'], 403);
        }

        // Cek apakah status proposal sudah fully_approved atau rejected
        if (in_array($proposal->status_apr, ['fully_approved'])) {
            return response()->json(['error' => 'This request cannot be updated because it is already ' . $proposal->status_apr], 400);
        }

         // Update status proposal dan field date_approve_dh
         $proposal->update([
            'actiondate_apr' => now(), // Menyimpan tanggal saat ini
            'status_apr' => 'rejected',
            'status_cr' => 'Closed By Rejected',
            'actiondate_apr' => now(), // Menyimpan tanggal saat ini
        ]);

        // Get the email recipient from the user who created the proposal
        $emailRecipient = $proposal->user->email ?? 'helpdesk@dp.dharmap.com'; // Fallback jika tidak ada

        // Buat data untuk dikirim
        $data = [
            'proposal' => $proposal,
        ];

        // Kirim notifikasi
        \Notification::route('mail', $emailRecipient)
            ->notify(new Rejected($data)); // Kirim data sebagai array

        // Cek apakah pengguna terautentikasi
        if (!auth()->check()) {
            return view('rejectDIVH', [
                'proposalNo_transaksi' => $proposal->no_transaksi,
                'proposalUserRequest' => $proposal->user_request,
                'proposalPosition' => $proposal->user_status,
                'proposalDepartement' => $proposal->departement,
                'proposalNoHandphone' => $proposal->ext_phone,
                'proposalStatusBarang' => $proposal->status_barang,
                'proposalKategori' => $proposal->kategori,
                'proposalFacility' => $proposal->facility,
                'proposalUserNote' => $proposal->user_note,
                'proposalAssetUser' => $proposal->no_asset_user,
                'proposalCreated' => $proposal->created_at,
                'proposalEstimatedStartDate' => $proposal->estimated_start_date,
                'proposalEstimatedDate' => $proposal->estimated_date,
            ]);
        } else {
            return redirect()->route('proposal.index')->with('success', 'DIVH status rejected successfully.');
        }
    }

    public function detail($id)
    {
        $proposal = Proposal::findOrFail($id); // Fetch the proposal by ID

        return view('dashboard.proposal.detail', ['proposal' => $proposal]); // Pass the proposal data to the view
    }

    public function showFiles()
    {
        $files = File::files(public_path('uploads'));
        $fileNames = array_map(function($file) {
            return $file->getFilename();
        }, $files);

        return view('files', ['files' => $fileNames]);
    }

    public function showFilesIT()
    {
        $files = File::files(public_path('uploadsIT'));
        $fileNames = array_map(function($file) {
            return $file->getFilename();
        }, $files);

        return view('filesIT', ['filesIT' => $fileNames]);
    }

    public function updateStatus(Request $request, string $proposal_id)
    {
        // Temukan proposal berdasarkan ID
        $proposal = Proposal::findOrFail($proposal_id);
        
        // Validasi request
        $validated = $request->validate([
            'status_cr' => 'nullable|string|in:Closed,Closed By IT,ON PROGRESS,DELAY,Closed By IT With Delay,Closed With Delay',
            'rating_it' => 'nullable|integer|between:1,5',  // rating antara 1-5
            'rating_apk' => 'nullable|integer|between:1,5',  // rating antara 1-5
            'review' => 'nullable|string|max:255',  // review berupa teks dengan panjang maksimal 255 karakter
        ]);

        try {
            // Cek jika status diubah
            if ($request->has('status_cr')) {
                $previousStatus = $proposal->status_cr;

                // Cek untuk Auto Close jika sudah lebih dari 2 hari
                if ($previousStatus === 'Closed By IT' && $proposal->updated_at->diffInDays(now()) > 2) {
                    $proposal->status_cr = 'Auto Close';
                } else {
                    $proposal->status_cr = $request->status_cr; // Simpan status baru
                }

                // Kirim notifikasi jika status berubah menjadi "Closed By IT" atau lainnya
                if (in_array($proposal->status_cr, ['Closed By IT', 'Closed By IT With Delay'])) {
                    $emailRecipient = User::where('departement', $proposal->departement)->pluck('email');
                    \Notification::route('mail', $emailRecipient)
                        ->notify(new ProposalUpdatedClosed($proposal)); // Kirim instance Proposal
                }
            }

            // Cek jika ada perubahan pada rating atau review
            if ($request->hasAny(['rating_it', 'rating_apk', 'review'])) {
                // Menyimpan rating IT jika ada
                if ($request->has('rating_it')) {
                    $proposal->rating_it = $request->rating_it;
                }

                // Menyimpan rating APK jika ada
                if ($request->has('rating_apk')) {
                    $proposal->rating_apk = $request->rating_apk;
                }

                // Menyimpan review jika ada (boleh null)
                // Jika review kosong, simpan null
                if ($request->has('review') && $request->review !== '') {
                    $proposal->review = $request->review;
                } else {
                    $proposal->review = null;  // Jika review kosong, set null
                }
            }

            // Simpan perubahan ke database (baik status, rating, maupun review)
            $proposal->save();

            // Menentukan pesan sukses berdasarkan perubahan yang terjadi
            if ($request->has('status_cr')) {
                return redirect()->route('proposal.index')->with('success', 'Status CR berhasil diperbarui.');
            } else {
                return redirect()->route('proposal.index')->with('success', 'Rating dan Review berhasil disimpan.');
            }

        } catch (\Exception $e) {
            // Menangkap kesalahan jika terjadi kegagalan saat menyimpan
            return redirect()->route('proposal.index')->with('error', 'Proses gagal: ' . $e->getMessage());
        }
    }

    private function it()
    {
        // Menyiapkan query dasar untuk mengambil proposal dengan status_apr 'fully_approved'
        $query = Proposal::where('status_apr', 'fully_approved');

        // Memeriksa apakah ada parameter 'status_barang' yang dipilih
        if (request()->has('status_barang') && request()->status_barang != '') {
            // Filter berdasarkan status_barang jika ada
            $query->where('status_barang', request()->status_barang);
        }

        // Menjalankan query untuk mendapatkan data proposal yang sudah difilter
        $proposalsit = $query->get();

        // Data yang akan dikirim ke tampilan
        $data = [
            'title' => 'Dashboard | DPM',
            'proposalsit' => $proposalsit,  // Kirim data proposals ke tampilan
        ];

        // Mengembalikan tampilan dengan data yang telah dipersiapkan
        return view('dashboard.proposal.it', $data);
    }



    public function notifyProposalUpdate(Proposal $proposal)
    {
        // Dapatkan pengguna untuk notifikasi berdasarkan departemen
        $usersToNotify = User::where('departement', $proposal->departement)->pluck('email'); 

        // Kirim notifikasi
        foreach ($usersToNotify as $emailRecipient) {
            \Notification::route('mail', $emailRecipient)
                ->notify(new ProposalUpdated($proposal)); // Pastikan $proposal adalah objek Proposal
        }
    }
    
}
