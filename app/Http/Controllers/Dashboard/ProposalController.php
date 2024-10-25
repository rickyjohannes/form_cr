<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\Approval;
use App\Models\User;
use Illuminate\Support\Str;

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

    public function store(Request $request)
    {
        // Generate nomor transaksi
        $noTransaksi = Proposal::generateNoTransaksi();
        
        $request->validate([
            'user_request' => 'required|string',
            'user_status' => 'required|string',
            'ext_phone' => 'required|string',
            'status_barang' => 'required|array',
            'facility' => 'required|array',
            'user_note' => 'nullable|string',
            'file' => 'nullable|mimes:pdf,xlsx,xls,csv,jpg,png,mp4|max:10240',
        ]);

        // Mengupload file jika ada
        $filename = $request->hasFile('file') ? time() . '.' . $request->file('file')->extension() : null;
        if ($filename) {
            $request->file('file')->move(public_path('uploads'), $filename);
        }

        // Convert arrays to strings (e.g., CSV)
        $status_barang = implode(',', $request->input('status_barang'));
        $facility = implode(',', $request->input('facility'));    

        // Ambil departemen pengguna yang sedang login
        $userDepartement = auth()->user()->departement;
        if (empty($userDepartement)) {
            return redirect()->back()->withErrors(['error' => 'Departement cannot be empty.']);
        }

        // Generate a new token for the proposal
        $token = Str::random(60); // Menggunakan Str::random untuk generate token

        // Create a new Proposal instance
        $proposal = new Proposal();
        $proposal->no_transaksi = $noTransaksi;
        $proposal->user_request = $request->input('user_request');
        $proposal->user_status = $request->input('user_status');
        $proposal->departement = $userDepartement; // Mengambil dari pengguna yang sedang login
        $proposal->ext_phone = $request->input('ext_phone');
        $proposal->status_barang = $status_barang;
        $proposal->facility = $facility;
        $proposal->user_note = $request->input('user_note');
        $proposal->file = $filename;
        $proposal->user_id = auth()->id();
        $proposal->token = $token; // Simpan token di database
        $proposal->save();

        // Get the email recipient from the user with role 'dh' and matching department
        $emailRecipient = $this->getEmailRecipientForDh(Auth::user());

        // Generate approval link
        $approvalLink = route('proposal.approveDH', ['proposal_id' => $proposal->id, 'token' => $token]);
        $rejectedLink = route('proposal.rejectDH', ['proposal_id' => $proposal->id, 'token' => $token]);

        // Create the email message with the button
        $emailMessage = 'Please approve/reject the CR by clicking the button below...<br>';
        $emailMessage .= 'CR with No Transaksi: ' . $proposal->no_transaksi . '<br>';
        $emailMessage .= 'User Request: ' . $proposal->user_request . '<br>';
        $emailMessage .= 'Departement: ' . $proposal->departement . '<br>';
        $emailMessage .= 'No Handphone: ' . $proposal->ext_phone . '<br>';
        $emailMessage .= 'Status Barang: ' . $proposal->status_barang . '<br>';
        $emailMessage .= 'Facility: ' . $proposal->facility . '<br>';
        $emailMessage .= 'User Note: ' . $proposal->user_note . '<br>';
        $emailMessage .= 'File: ' . $proposal->file . '<br>';
        $emailMessage .= '<span style="display: block; margin: 10px 185px; font-size: 18px; font-weight: bold;">Action</span>'; // Action text
        $emailMessage .= '<div style="text-align: center; margin-top: 20px;">'; // Center the buttons
        $emailMessage .= '<div style="display: flex; align-items: center; justify-content: center;">';
        $emailMessage .= '<a href="' . $approvalLink . '" style="background-color: #4CAF50; color: white; padding: 15px 30px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px; font-size: 16px; width: 200px; margin: 5px;">Approve CR</a>';
        $emailMessage .= '<a href="' . $rejectedLink . '" style="background-color: #dc3545; color: white; padding: 15px 30px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px; font-size: 16px; width: 200px; margin: 5px;">Reject CR</a>';
        $emailMessage .= '</div>'; // Close the button container
        
        // Use the notification system to send an email
        \Notification::route('mail', $emailRecipient)
            ->notify(new Approval($emailMessage));

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

            // Daftar opsi fasilitas
            $facilityOptions = [
                "Account -> Login",
                "Account -> Email",
                "Account -> Internet",
                "Software -> Install Software",
                "Software -> Change Request",
                "Software -> New Application",
                "Infrastruktur -> PC / TC",
                "Infrastruktur -> Printer / Scanner",
                "Infrastruktur -> Monitor",
                "Infrastruktur -> Keyboard / Mouse",
                "Infrastruktur -> Lan / Telp"
            ];

            return view('dashboard.proposal.edit', compact('proposal', 'status_barang', 'facility', 'facilityOptions'));
        } catch (ModelNotFoundException $e) {
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

            // Daftar opsi fasilitas
            $facilityOptions = [
                "Account -> Login",
                "Account -> Email",
                "Account -> Internet",
                "Software -> Install Software",
                "Software -> Change Request",
                "Software -> New Application",
                "Infrastruktur -> PC / TC",
                "Infrastruktur -> Printer / Scanner",
                "Infrastruktur -> Monitor",
                "Infrastruktur -> Keyboard / Mouse",
                "Infrastruktur -> Lan / Telp"
            ];

            return view('dashboard.proposal.editit', compact('proposal', 'status_barang', 'facility', 'facilityOptions'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('proposals.index')->with('error', 'Proposal not found.');
        }
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'user_request' => 'required|string',
            'user_status' => 'required|string',
            'departement' => 'required|string',
            'ext_phone' => 'required|string',
            'status_barang' => 'required|array',
            'facility' => 'required|array',
            'user_note' => 'nullable|string',
            'file' => 'mimes:pdf,xlsx,xls,csv,jpg,png,mp4|max:10240',
        ]);

        // Sanitasi input untuk facility dan status_barang
        $facility = array_map('trim', $validated['facility']);
        $facilityString = implode(',', $facility);
        $status_barang = array_map('trim', $validated['status_barang']);
        $statusBarangString = implode(',', $status_barang);

        // Temukan proposal
        $proposal = Proposal::findOrFail($id);

        // Cek dan simpan file jika ada
        if ($request->hasFile('file')) {
            // Generate filename dan simpan file
            $filename = time() . '.' . $request->file->extension();
            $request->file->move(public_path('uploads'), $filename);
            $proposal->file = $filename; // Perbarui nama file
            \Log::info('File Uploaded: ' . $filename);
        } 

        // Perbarui atribut yang divalidasi
        $proposal->update(array_merge($validated, [
            'facility' => $facilityString,
            'status_barang' => $statusBarangString,
            'file' => $proposal->file, // Pastikan ini ada
        ]));

        return redirect()->route('proposal.index')->with('success', 'CR successfully updated.');
    }

    public function updateit(Request $request, string $id)
    {
        $validated = $request->validate([
            'user_request' => 'required|string',
            'user_status' => 'required|string',
            'departement' => 'required|string',
            'ext_phone' => 'required|string',
            'status_barang' => 'required|array',
            'facility' => 'required|array',
            'user_note' => 'required|string',
            'it_analys' => 'string|max:255',
            'file' => 'mimes:pdf,xlsx,xls,csv|max:10240',
            'file_it' => 'mimes:pdf,xlsx,xls,csv,jpg,png,mp4|max:10240',
            'no_asset' => 'nullable|string',
        ]);

        // Sanitasi input untuk facility dan status_barang
        $facility = array_map('trim', $validated['facility']);
        $facilityString = implode(',', $facility);
        $status_barang = array_map('trim', $validated['status_barang']);
        $statusBarangString = implode(',', $status_barang);

        // Temukan proposal
        $proposal = Proposal::findOrFail($id);

        // Cek dan simpan file jika ada
        if ($request->hasFile('file')) {
            // Generate filename dan simpan file
            $filename = time() . '.' . $request->file->extension();
            $request->file->move(public_path('uploads'), $filename);
            $proposal->file = $filename; // Perbarui nama file
            \Log::info('File Uploaded: ' . $filename);
        } 
        
        // Cek dan simpan file jika ada
        if ($request->hasFile('file_it')) {
            $filenameit = time() . '.' . $request->file_it->extension();
            $request->file_it->move(public_path('uploads'), $filenameit);
            $proposal->file_it = $filenameit; // Perbarui nama file IT
            \Log::info('File IT Uploaded: ' . $filenameit);
        }

        // Perbarui atribut yang divalidasi
        $proposal->update(array_merge($validated, [
            'facility' => $facilityString,
            'status_barang' => $statusBarangString,
            'file' => $proposal->file, // Pastikan ini ada
            'file_it' => $proposal->file_it, // Pastikan ini ada
        ]));

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

        // Dapatkan email penerima dari pengguna dengan role 'divh'
        $divhItUser = User::whereHas('role', function ($query) {
            $query->where('name', 'divh');
        })->first();

        // Cek apakah pengguna ada dan ambil email mereka
        $emailRecipient = $divhItUser ? $divhItUser->email : 'fallback@example.com'; // Fallback jika tidak ada

        // Generate approval link dan rejected link
        $approvalLink = route('proposal.approveDIVH', ['proposal_id' => $proposal->id, 'token' => $token]);
        $rejectedLink = route('proposal.rejectDIVH', ['proposal_id' => $proposal->id, 'token' => $token]);

        // Buat pesan email
        $emailMessage = 'Please approve/reject the CR by clicking the button below...<br>';
        $emailMessage .= 'CR with No Transaksi: ' . $proposal->no_transaksi . '<br>';
        $emailMessage .= 'User Request: ' . $proposal->user_request . '<br>';
        $emailMessage .= 'Department: ' . $proposal->departement . '<br>';
        $emailMessage .= 'No Handphone: ' . $proposal->ext_phone . '<br>';
        $emailMessage .= 'Status Barang: ' . $proposal->status_barang . '<br>';
        $emailMessage .= 'Facility: ' . $proposal->facility . '<br>';
        $emailMessage .= 'User Note: ' . $proposal->user_note . '<br>';
        $emailMessage .= 'File: ' . $proposal->file . '<br>';
        $emailMessage .= '<span style="display: block; margin: 10px 185px; font-size: 18px; font-weight: bold;">Action</span>'; // Action text
        $emailMessage .= '<div style="text-align: center; margin-top: 20px;">'; // Center the buttons
        $emailMessage .= '<div style="display: flex; align-items: center; justify-content: center;">';
        $emailMessage .= '<a href="' . $approvalLink . '" style="background-color: #4CAF50; color: white; padding: 15px 30px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px; font-size: 16px; width: 200px; margin: 5px;">Approve CR</a>';
        $emailMessage .= '<a href="' . $rejectedLink . '" style="background-color: #dc3545; color: white; padding: 15px 30px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px; font-size: 16px; width: 200px; margin: 5px;">Reject CR</a>';
        $emailMessage .= '</div>'; // Close the button container

        // Kirim email
        \Notification::route('mail', $emailRecipient)
            ->notify(new Approval($emailMessage));

        // Cek apakah pengguna terautentikasi
        if (!auth()->check()) {
            return view('approveDH', [
                'proposalNo_transaksi' => $proposal->no_transaksi,
                'proposalUserRequest' => $proposal->user_request,
                'proposalDepartement' => $proposal->departement,
                'proposalNoHandphone' => $proposal->ext_phone,
                'proposalStatusBarang' => $proposal->status_barang,
                'proposalFacility' => $proposal->facility,
                'proposalUserNote' => $proposal->user_note,
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
    
        // Cek apakah pengguna terautentikasi
        if (!auth()->check()) {
            return view('rejectDH', [
                'proposalNo_transaksi' => $proposal->no_transaksi,
                'proposalUserRequest' => $proposal->user_request,
                'proposalDepartement' => $proposal->departement,
                'proposalNoHandphone' => $proposal->ext_phone,
                'proposalStatusBarang' => $proposal->status_barang,
                'proposalFacility' => $proposal->facility,
                'proposalUserNote' => $proposal->user_note,
            ]);
        } else {
            return redirect()->route('proposal.index')->with('success', 'DH status rejected successfully.');
        }
    }

    public function approveDIVH(Request $request, string $proposal_id)
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
            'status_divh' => 'approved',
            'status_cr' => 'ON PROGRESS',
            'actiondate_divh' => now(), // Menyimpan tanggal saat ini
        ]);

        // Send the notification after saving the proposal
        $message = 'Proposal with No CR: ' . $proposal->no_transaksi . ' has been approved.<br>';
        $message .= 'CR Akan di Proses oleh Tim IT. Mohon bersabar, dan jika dalam waktu dekat Anda tidak menerima kabar, silakan follow up menggunakan nomor CR ini. Terima kasih atas pengertiannya.<br>';

        // Get the email recipient from the user with role 'divh_it'
        $userItUser = User::whereHas('role', function ($query) {
            $query->where('name', 'divh_it');
        })->first();

        // Check if the user exists and get their email
        $emailRecipient = $userItUser ? $userItUser->email : 'rickyjop0@gmail.com'; // Fallback if not found

        // Use the notification system to send an email
        \Notification::route('mail', $emailRecipient)
            ->notify(new Approval($message));

        // Cek apakah pengguna terautentikasi
        if (!auth()->check()) {
            return view('approveDIVH', [
                'proposalNo_transaksi' => $proposal->no_transaksi,
                'proposalUserRequest' => $proposal->user_request,
                'proposalDepartement' => $proposal->departement,
                'proposalNoHandphone' => $proposal->ext_phone,
                'proposalStatusBarang' => $proposal->status_barang,
                'proposalFacility' => $proposal->facility,
                'proposalUserNote' => $proposal->user_note,
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

        // Cek apakah pengguna terautentikasi
        if (!auth()->check()) {
            return view('rejectDIVH', [
                'proposalNo_transaksi' => $proposal->no_transaksi,
                'proposalUserRequest' => $proposal->user_request,
                'proposalDepartement' => $proposal->departement,
                'proposalNoHandphone' => $proposal->ext_phone,
                'proposalStatusBarang' => $proposal->status_barang,
                'proposalFacility' => $proposal->facility,
                'proposalUserNote' => $proposal->user_note,
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
        $proposal = Proposal::findOrFail($proposal_id);
        
        // Validasi request
        $request->validate([
          //  'status_cr' => 'required|string',
        'status_cr' => 'required|string|in:CR Closed,Closed With IT','ON PROGRESS' // Pastikan nilai valid
        ]);
        
        // Simpan status sebelumnya
        $previousStatus = $proposal->status_cr;
        
        // Cek untuk Auto Close jika sudah lebih dari 2 hari
        if ($previousStatus === 'Closed With IT' && 
            $proposal->updated_at->diffInDays(now()) >= 2) {
            $proposal->status_cr = 'Auto Close';
        } else {
            // Update status_cr hanya jika tidak diubah menjadi Auto Close
            $proposal->status_cr = $request->status_cr;
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
    
}
