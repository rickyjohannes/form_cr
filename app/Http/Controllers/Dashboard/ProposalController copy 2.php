<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
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
        $pending = Proposal::where('status_dh', 'pending')->get();
        $approved = Proposal::where('status_dh', 'approved')->get();
        $rejected = Proposal::where('status_dh', 'rejected')->get();
        $proposalpen = Proposal::where('status_dh', 'pending')->orWhere('status_divh', 'pending') ->where('status_dh', '!=', 'rejected')->get();
        $proposalapr = Proposal::where('status_dh', 'approved')->where('status_divh', 'approved')->get();
        $proposalrej = Proposal::where('status_dh', 'rejected') ->orWhere('status_divh', 'rejected')->get();
        // $proposals = Proposal::orderBy('created_at', 'desc')->get();
        
        $data = [
            'title' => 'Dashboard | DPM',
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
            'proposalpen' => $proposalpen,
            'proposalapr' => $proposalapr,
            'proposalrej' => $proposalrej
        ];
        
        return view('dashboard.proposal.administrator', $data);
    }

    private function user()
    {
        $id = Auth::user()->id;
        $proposals = Proposal::where('user_id', $id)->get();
        $data = [
            'title' => 'Dashboard | DPM',
            'proposals' => $proposals
        ];
        return view('dashboard.proposal.user', $data);
    }

    public function approval(string $id, string $status) 
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->update(['status' => $status]);

        return redirect()->route('proposal.index')->with('success', 'CR status updated successfully.');
    }

    public function print(string $id) 
    {
        $proposal = Proposal::findOrFail($id);

        $pdf = Pdf::loadView('dashboard.proposal.print', ['proposal' => $proposal]);
        return $pdf->download('form_cr_aprroved.pdf');
    }

    public function create()
    {
        $data = ['title' => 'CR | DPM'];
        return view('dashboard.proposal.create', $data);
    }

    // public function store(Request $request)
    // {
    //     // Generate nomor transaksi
    //     $noTransaksi = Proposal::generateNoTransaksi();
        
    //     $request->validate([
    //         'status_barang' => 'required|array',
    //         'kategori' => 'required|array',
    //         'facility' => 'required_without:other_facility|array', // Aturan ini memastikan bahwa jika facility tidak ada, other_facility harus diisi.
    //         'user_note' => 'nullable|string',
    //         'file' => 'nullable|mimes:pdf,xlsx,xls,csv,jpg,png,mp4|max:10240',
    //         'other_facility' => 'nullable|string|max:255', // Validate other facility if applicable
    //     ]);

    //     // Mengupload file jika ada
    //     $filename = $request->hasFile('file') ? time() . '.' . $request->file('file')->extension() : null;
    //     if ($filename) {
    //         $request->file('file')->move(public_path('uploads'), $filename);
    //     }

    //     // Mengonversi arrays ke strings
    //     $status_barang = implode(',', $request->input('status_barang'));
    //     $kategori = implode(',', $request->input('kategori'));
    //     $facility = $request->input('facility') ? implode(',', $request->input('facility')) : '';

    //     // Ambil nilai other_facility
    //     $other_facility = $request->input('other_facility');

    //     // Jika other_facility diisi, tambahkan ke facility
    //     if ($other_facility) {
    //         if ($facility) {
    //             $facility .= ',' . $other_facility; // Tambahkan ke fasilitas yang ada
    //         } else {
    //             $facility = $other_facility; // Jika tidak ada fasilitas lain, set dengan other_facility
    //         }
    //     }

    //     $userRequest = auth()->user()->name;
    //     if (empty($userRequest)) {
    //         return redirect()->back()->withErrors(['error' => 'User cannot be empty.']);
    //     }

    //     $userStatus = auth()->user()->user_status;
    //     if (empty($userStatus)) {
    //         return redirect()->back()->withErrors(['error' => 'Status User cannot be empty.']);
    //     }

    //     // Ambil departemen pengguna yang sedang login
    //     $userDepartement = auth()->user()->departement;
    //     if (empty($userDepartement)) {
    //         return redirect()->back()->withErrors(['error' => 'Departement cannot be empty.']);
    //     }

    //     // Generate a new token for the proposal
    //     $token = Str::random(60); // Menggunakan Str::random untuk generate token

    //     // Create a new Proposal instance
    //     $proposal = new Proposal();
    //     $proposal->no_transaksi = $noTransaksi;
    //     $proposal->user_request = $userRequest;
    //     $proposal->user_status = $userStatus;
    //     $proposal->departement = $userDepartement; // Mengambil dari pengguna yang sedang login
    //     $proposal->ext_phone = $request->input('ext_phone');
    //     $proposal->status_barang = $status_barang;
    //     $proposal->kategori = $kategori;
    //     $proposal->facility = $facility;
    //     $proposal->user_note = $request->input('user_note');
    //     $proposal->file = $filename;
    //     $proposal->facility = $facility; // Simpan ke database
    //     $proposal->user_id = auth()->id();
    //     $proposal->token = $token; // Simpan token di database
    //     $proposal->save();

    //     // Get the email recipient from the user with role 'dh' and matching department
    //     $emailRecipient = $this->getEmailRecipientForDh(Auth::user());

    //     // Generate approval link
    //     $approvalLink = route('proposal.approveDH', ['proposal_id' => $proposal->id, 'token' => $token]);
    //     $rejectedLink = route('proposal.rejectDH', ['proposal_id' => $proposal->id, 'token' => $token]);

    //     // Buat data untuk dikirim
    //     $data = [
    //         'proposal' => $proposal,
    //         'approvalLink' => $approvalLink,
    //         'rejectedLink' => $rejectedLink,
    //     ];

    //     // Kirim notifikasi
    //     \Notification::route('mail', $emailRecipient)
    //         ->notify(new Approval($data)); // Kirim data sebagai array

    //     // Cek jika penyimpanan berhasil
    //         if (!$proposal->save()) {
    //             return redirect()->back()->withErrors(['error' => 'Failed to save proposal.']);
    //         }

    //         // Kirim notifikasi dan redirect
    //         return redirect()->route('proposal.index')->with('success', 'CR successfully created.');  
    // }
    
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
            'file' => 'nullable|mimes:pdf,xlsx,xls,csv,jpg,png,mp4|max:10240',
            'other_facility' => 'nullable|string|max:255', // Validasi untuk other facility
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
            return 'rickyjop0@gmail.com'; // Fallback jika tidak ada
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
            'file' => 'nullable|mimes:pdf,xlsx,xls,csv,jpg,png,mp4|max:10240',
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
            'estimated_date' => 'nullable|date',
            'it_analys' => 'nullable|max:255',
            'file' => 'mimes:pdf,xlsx,xls,csv,jpg,png,mp4|max:10240',
            'file_it' => 'mimes:pdf,xlsx,xls,csv,jpg,png,mp4|max:10240',
            'no_asset' => 'nullable|string',
        ]);

        // Sanitasi input untuk facility dan status_barang
        $facility = array_map('trim', $validated['facility'] ?? []);
        $facilityString = implode(',', $facility);
        
        $status_barang = array_map('trim', $validated['status_barang'] ?? []);
        $statusBarangString = implode(',', $status_barang);

        // Cek dan simpan file jika ada
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move(public_path('uploads'), $filename);
            $proposal->file = $filename;
        }

        if ($request->hasFile('file_it')) {
            $filenameit = time() . '.' . $request->file('file_it')->extension();
            $request->file_it->move(public_path('uploads'), $filenameit);
            $proposal->file_it = $filenameit;
        }

        // Dapatkan nama pengguna dari profile
        $user = auth()->user();
        $it_user = $user->profile->name ?? null;

        // Dapatkan nilai estimated_date saat ini dari proposal
        $oldEstimatedDate = $proposal->estimated_date;

        // Cek apakah estimated_date baru ada
        $estimatedDate = $validated['estimated_date'] ?? $oldEstimatedDate;

        // Simpan close_date jika it_analys ada
        $close_date = isset($validated['it_analys']) && $validated['it_analys'] !== null ? now() : null;

        // Logika untuk menentukan status_cr
        $closedStatuses = ['Closed With IT', 'Closed IT With Delay', 'Auto Closed', 'Closed All'];
        $status_cr = in_array($proposal->status_cr, $closedStatuses) ? $proposal->status_cr : 'ON PROGRESS';

        // Update proposal
        $proposal->update(array_merge($validated, [
            // Cek dan update hanya field yang ada dalam request
            'status_barang' => $request->filled('status_barang') ? implode(',', array_map('trim', $request->status_barang)) : $proposal->status_barang,
            'facility' => $request->filled('facility') ? implode(',', array_map('trim', $request->facility)) : $proposal->facility,
            'other_facility' => $request->filled('other_facility') ? trim($request->other_facility) : $proposal->other_facility,
            'user_note' => $request->filled('user_note') ? $request->user_note : $proposal->user_note,
            'no_asset_user' => $request->filled('no_asset_user') ? $request->no_asset_user : $proposal->no_asset_user,
            'file' => isset($filename) ? $filename : $proposal->file,  // Jika ada file baru, update file
            'file_it' => isset($filenameit) ? $filenameit : $proposal->file_it,
            'estimated_date' => $estimatedDate,
            'it_user' => $it_user,
            'status_cr' => $status_cr,
            'close_date' => $close_date,
        ]));

        // Log nilai lama dan baru untuk debugging
        Log::info('Updating proposal with ID: ' . $proposal->id);
        Log::info('New estimated date: ' . $estimatedDate);
        Log::info('Old estimated date: ' . $oldEstimatedDate);

        // Logika untuk mengirim notifikasi email jika estimated_date telah diperbarui
        if ($estimatedDate !== $oldEstimatedDate) {
            if (is_null($oldEstimatedDate) || !is_null($estimatedDate)) {
                try {
                    $this->notifyProposalUpdate($proposal);
                    Log::info('Email notification sent successfully for Proposal ID: ' . $proposal->id);
                } catch (\Exception $e) {
                    Log::error('Failed to send email notification for Proposal ID: ' . $proposal->id . '. Error: ' . $e->getMessage());
                }
            } else {
                Log::info('No change in estimated date, notification not sent.');
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

        // Update status proposal dan field date_approve_dh
        $proposal->update([
            'status_dh' => 'approved',
            'actiondate_dh' => now(), // Menyimpan tanggal saat ini
        ]);

        // Dapatkan email penerima dari pengguna dengan role 'divh' dan departement yang sama
        $divhItUser = User::where('departement', $proposal->departement)
        ->whereHas('role', function ($query) {
            $query->where('name', 'divh');
        })->first();

        // Cek apakah pengguna ada dan ambil email mereka
        $emailRecipient = $divhItUser ? $divhItUser->email : 'rickyjop0@gmail.com'; // Fallback jika tidak ada

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

         // Update status proposal dan field date_approve_dh
         $proposal->update([
            'status_dh' => 'rejected',
            'status_divh' => 'rejected',
            'status_cr' => 'Close By Rejected',
            'actiondate_dh' => now(), // Menyimpan tanggal saat ini
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

        // Update status proposal dan field date_approve_dh
        $proposal->update([
            'status_divh' => 'approved',
            'status_cr' => 'Open To IT',
            'actiondate_divh' => now(), // Menyimpan tanggal saat ini
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

         // Update status proposal dan field date_approve_dh
         $proposal->update([
            'status_divh' => 'rejected',
            'status_cr' => 'Close By Rejected',
            'actiondate_divh' => now(), // Menyimpan tanggal saat ini
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
        $request->validate([
            'status_cr' => 'required|string|in:Closed All,Closed With IT,ON PROGRESS,DELAY,Closed IT With Delay,Closed With Delay'
        ]);
        
        // Simpan status sebelumnya
        $previousStatus = $proposal->status_cr;

        // Cek untuk Auto Close jika sudah lebih dari 2 hari
        if ($previousStatus === 'Closed With IT' && 
            $proposal->updated_at->diffInDays(now()) > 2) {
            $proposal->status_cr = 'Auto Close';
        } else {
            $proposal->status_cr = $request->status_cr;
        }
        
        // Cek apakah status_cr yang baru adalah "Closed With IT" atau "Closed IT With Delay"
        if (in_array($proposal->status_cr, ['Closed With IT', 'Closed IT With Delay'])) {
            // Ambil email penerima
            $emailRecipient = $proposal->user->email ?? 'rickyjop0@gmail.com'; // Fallback jika tidak ada
            
            // Kirim notifikasi
            \Notification::route('mail', $emailRecipient)
                ->notify(new ProposalUpdatedClosed($proposal)); // Kirim instance Proposal
        }

        // Simpan perubahan ke database
        $proposal->save();
        
        return redirect()->route('proposal.index')->with('success', 'Status CR updated successfully.');
    }


    private function it()
    {
        $id = Auth::user()->id;
        $proposalsit = Proposal::get();
        $data = [
            'title' => 'Dashboard | DPM',
            'proposalsit' => $proposalsit
        ];
        return view('dashboard.proposal.it', $data);
    }

    public function notifyProposalUpdate(Proposal $proposal)
    {
        // Buat pesan notifikasi
        $message = 'Proposal with No CR: ' . $proposal->no_transaksi . ' has been updated.<br>';
        $message .= 'User Request: ' . $proposal->user_request . '<br>';
        $message .= 'Department: ' . $proposal->departement . '<br>';
        $message .= 'No Handphone: ' . $proposal->ext_phone . '<br>';
        $message .= 'Status Barang: ' . $proposal->status_barang . '<br>';
        $message .= 'Facility: ' . $proposal->facility . '<br>';
        $message .= 'User Note: ' . $proposal->user_note . '<br>';
        $message .= 'Estimated Date: ' . \Carbon\Carbon::parse($proposal->estimated_date)->format('Y-m-d H:i:s') . '<br>';
        $message .= 'CR will be processed by the IT team. Please be patient, and if you do not receive news soon, feel free to follow up using this CR number. Thank you for your understanding.<br>';

        // Dapatkan pengguna untuk notifikasi berdasarkan departemen
        $usersToNotify = User::where('departement', $proposal->departement)->pluck('email'); 

        // Kirim notifikasi
        foreach ($usersToNotify as $emailRecipient) {
            \Notification::route('mail', $emailRecipient)
                ->notify(new ProposalUpdated($proposal)); // Pastikan $proposal adalah objek Proposal
        }
    }


    


    
}
