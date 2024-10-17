<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\Approval;

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
            'departement' => 'required|string',
            'ext_phone' => 'required|string',
            'status_barang' => 'required|array',
            'facility' => 'required|array',
            'user_note' => 'nullable|string',
            'file' => 'required|mimes:pdf,xlsx,xls,csv|max:10240',
        ]);

        // Mengupload dan menyimpan file
        $filename = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $filename);

        // Convert arrays to strings (e.g., CSV)
        $status_barang = implode(',', $request->input('status_barang'));
        $facility = implode(',', $request->input('facility'));    

        // Create a new Proposal instance
        $proposal = new Proposal();
        $proposal->no_transaksi = $noTransaksi;
        $proposal->user_request = $request->input('user_request');
        $proposal->user_status = $request->input('user_status');
        $proposal->departement = $request->input('departement');
        $proposal->ext_phone = $request->input('ext_phone');
        $proposal->status_barang = $status_barang; // Store as a string
        $proposal->facility = $facility; // Store as a string
        $proposal->user_note = $request->input('user_note');
        $proposal->file = $filename;
        $proposal->user_id = auth()->id(); // Assuming you're using Laravel authentication
        $proposal->save();

         // Get the email recipient from the user with role 'supervisor'
         $dhItUser = Auth::user()::whereHas('role', function ($query) {
            $query->where('name', 'dh_it');
        })->first();

        // Check if the user exists and get their email
        $emailRecipient = $dhItUser ? $dhItUser->email : 'rickyjop0@gmail.com'; // Fallback jika tidak ada

        // Generate approval link
        $approvalLink = route('proposal.approveDH', ['proposal_id' => $proposal->id, 'token' => Auth::user()->api_token]);
        $rejectedLink = route('proposal.rejectDH', ['proposal_id' => $proposal->id, 'token' => Auth::user()->api_token]);

        // Create the email message with the button
        $emailMessage = 'Please approve / rejected the CR by click the button below...<br>';
        $emailMessage .= 'CR with No Transaksi: ' . $proposal->no_transaksi .'<br>';
        $emailMessage .= 'User Request: ' . $proposal->user_request .'<br>';
        $emailMessage .= 'Departement: ' . $proposal->departement .'<br>';
        $emailMessage .= 'No Handphone: ' . $proposal->ext_phone .'<br>';
        $emailMessage .= 'Status Barang: ' . $proposal->status_barang .'<br>';
        $emailMessage .= 'Facility: ' . $proposal->facility .'<br>';
        $emailMessage .= 'User Note: ' . $proposal->user_note .'<br>';
        $emailMessage .= '<a href="' . $approvalLink . '" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px;">Approve CR</a>';
        $emailMessage .= '<a href="' . $rejectedLink . '" style="background-color: #dc3545; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px;">Rejected CR</a>';

        // Use the notification system to send an email
        \Notification::route('mail', $emailRecipient)
            ->notify(new Approval($emailMessage));

        return redirect()->route('proposal.index')->with('success', 'CR successfully created.');    
    }


    // public function store(Request $request)
    // {
        
    //     $validated = $request->validate([
    //         'no_transaksi' => 'required|string|max:255|unique:proposals', // Add 'unique:proposals' to ensure uniqueness
    //         'user_request' => 'required|string|max:255',
    //         'user_status' => 'required|string|max:255',
    //         'departement' => 'required|string|max:255',
    //         'ext_phone' => 'required',
    //         'status_barang' => 'required',
    //         'facility' => 'required',
    //         'user_note' => 'required|string|max:255',
    //         // 'it_analys' => 'string|max:255'
    //     ]);

    //     $validated['user_id'] = Auth::user()->id;

    //     Proposal::create($validated);

    //     return redirect()->route('proposal.index')->with('success', 'CR successfully created.');
    // }

    public function show(string $id)
    {
        $proposal = Proposal::findOrFail($id);
        $data = [
            'title' => 'CR | DPM',
            'proposal' => $proposal
        ];
        return view('dashboard.proposal.detail', $data);
    }

    // public function edit(string $id)
    // {
    //     $proposal = Proposal::findOrFail($id);
    //     $data = [
    //         'title' => 'CR | DPM',
    //         'proposal' => $proposal
    //     ];
    //     return view('dashboard.proposal.edit', $data);
    // }

    public function edit($id)
    {
        try {
            // Retrieve the proposal by ID
            $proposal = Proposal::findOrFail($id);

            // Convert status_barang to an array
            $status_barang = !empty($proposal->status_barang) ? explode(',', $proposal->status_barang) : [];
            $facility = !empty($proposal->facility) ? explode(',', $proposal->facility) : [];
        

            // Debugging
            // dd($facility);

            return view('dashboard.proposal.edit', compact('proposal', 'status_barang', 'facility'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('proposals.index')->with('error', 'Proposal not found.');
        }
    }

    public function editit($id)
    {
        try {
            // Retrieve the proposal by ID
            $proposal = Proposal::findOrFail($id);

            // Convert status_barang to an array
            $status_barang = !empty($proposal->status_barang) ? explode(',', $proposal->status_barang) : [];
            $facility = !empty($proposal->facility) ? explode(',', $proposal->facility) : [];
        

            // Debugging
            // dd($facility);

            return view('dashboard.proposal.editit', compact('proposal', 'status_barang', 'facility'));
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
            'file' => 'mimes:pdf,xlsx,xls,csv|max:10240',
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
            'user_note' => 'nullable|string',
            'it_analys' => 'string|max:255',
            'file' => 'mimes:pdf,xlsx,xls,csv|max:10240',
            'file_it' => 'mimes:pdf,xlsx,xls,csv|max:10240',
            'no_asset' => 'required|string',
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

    public function approveDH(string $proposal_id)
    {
        $proposal = Proposal::findOrFail($proposal_id);

        // Check if the user has the 'dh_it' role
        if (Auth::user()->role->name == 'dh_it') {
            // Update the proposal status
            $proposal->update(['status_dh' => 'approved']);
            
            // Send the notification after saving the proposal
            
            
            // Get the email recipient from the user with role 'supervisor'
            $divhItUser = Auth::user()::whereHas('role', function ($query) {
                $query->where('name', 'supervisor');
            })->first();
            
            // Check if the user exists and get their email
            $emailRecipient = $divhItUser ? $divhItUser->email : 'rickyjop0@gmail.com'; // Fallback jika tidak ada
            
            // Generate approval link
            $approvalLink = route('proposal.approveDIVH', ['proposal_id' => $proposal->id, 'token' => Auth::user()->api_token]);
            $rejectedLink = route('proposal.rejectDIVH', ['proposal_id' => $proposal->id, 'token' => Auth::user()->api_token]);


            // Create the email message with the button
            $emailMessage = 'Please approve / rejected the CR by click the button below...<br>';
            $emailMessage .= 'CR with No Transaksi: ' . $proposal->no_transaksi .'<br>';
            $emailMessage .= 'User Request: ' . $proposal->user_request .'<br>';
            $emailMessage .= 'Departement: ' . $proposal->departement .'<br>';
            $emailMessage .= 'No Handphone: ' . $proposal->ext_phone .'<br>';
            $emailMessage .= 'Status Barang: ' . $proposal->status_barang .'<br>';
            $emailMessage .= 'Facility: ' . $proposal->facility .'<br>';
            $emailMessage .= 'User Note: ' . $proposal->user_note .'<br>';
            $emailMessage .= '<a href="' . $approvalLink . '" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px;">Approve CR</a>';
            $emailMessage .= '<a href="' . $rejectedLink . '" style="background-color: #dc3545; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px;">Rejected CR</a>';

            // Use the notification system to send an email
            \Notification::route('mail', $emailRecipient)
                ->notify(new Approval($emailMessage));
            
            return redirect()->route('proposal.index')->with('success', 'DH status approved successfully.');
        } else {
            return redirect()->back()->with('error', 'You do not have permission to approve DH status.');
        }
    }

    public function rejectDH(string $proposal_id)
    {
        $proposal = Proposal::findOrFail($proposal_id);

        // Check if the user has the 'dh_it' role
        if (Auth::user()->role->name == 'dh_it') {
            $proposal->update(['status_dh' => 'rejected']);
            return redirect()->route('proposal.index')->with('success', 'DH status rejected successfully.');
        } else {
            return redirect()->back()->with('error', 'You do not have permission to reject DH status.');
        }
    }

    // public function approveDIVH(string $proposal_id)
    // {
    //     $proposal = Proposal::findOrFail($proposal_id);

    //     // Check if the user has the 'supervisor' role
    //     if (Auth::user()->role->name == 'supervisor') {
    //         $proposal->update(['status_divh' => 'approved']);
    //         return redirect()->route('proposal.index')->with('success', 'DIVH status approved successfully.');
    //     } else {
    //         return redirect()->back()->with('error', 'You do not have permission to approve DIVH status.');
    //     }
    // }

    public function approveDIVH(string $proposal_id)
    {
        $proposal = Proposal::findOrFail($proposal_id);
    
        // Check if the user has the 'dh_it' role
        if (Auth::user()->role->name == 'supervisor') {
            // Update the proposal status
            $proposal->update(['status_divh' => 'approved']);
            $proposal->update(['status_cr' => 'ON PROGRESS']);
            
            // Send the notification after saving the proposal
            $message = 'Proposal with No CR: ' . $proposal->no_transaksi . ' has been approved.';
            
            // Get the email recipient from the user with role 'divh_it'
            $userItUser = Auth::user()->whereHas('role', function ($query) {
                $query->where('name', 'user');
            })->first();
            
            // Check if the user exists and get their email
            $emailRecipient = $userItUser ? $userItUser->email : 'rickyjop0@gmail.com'; // Fallback jika tidak ada
            
            // Use the notification system to send an email
            \Notification::route('mail', $emailRecipient)
                ->notify(new Approval($message));
            
            return redirect()->route('proposal.index')->with('success', 'DIVH status approved successfully.');
        } else {
            return redirect()->back()->with('error', 'You do not have permission to approve DIVH status.');
        } 
    }

    public function rejectDIVH(string $proposal_id)
    {
        $proposal = Proposal::findOrFail($proposal_id);

        // Check if the user has the 'supervisor' role
        if (Auth::user()->role->name == 'supervisor') {
            $proposal->update(['status_divh' => 'rejected']);
            return redirect()->route('proposal.index')->with('success', 'DIVH status rejected successfully.');
        } else {
            return redirect()->back()->with('error', 'You do not have permission to reject DIVH status.');
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
        'status_cr' => 'required|string|in:Closed All,Closed With IT','ON PROGRESS' // Pastikan nilai valid
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
