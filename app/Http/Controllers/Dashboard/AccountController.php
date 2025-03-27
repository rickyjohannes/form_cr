<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Validators\ValidationException;

class AccountController extends Controller
{
    public function index()
    {
        // List Account
        $id = Auth::user()->id;
        $accounts = User::get();
        $data = [
            'title' => 'Account | DPM',
            'accounts' => $accounts
        ];

        return view('dashboard.account.index', $data);
    }

    public function create()
    {
        // Ambil semua departemen dari user, pecah berdasarkan koma, hilangkan duplikasi, dan urutkan
        $departements = User::pluck('departement')
            ->filter()
            ->map(function ($item) {
                return array_map('trim', explode(',', $item));
            })
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->toArray(); // Konversi ke array biasa agar bisa digunakan di Blade

        $roles = Role::all();

        $data = [
            'title' => 'Account | DPM',
            'roles' => $roles,
            'departements' => $departements,
            'account' => null // Tambahkan ini agar tidak error jika tidak ada `$account`
        ];

        return view('dashboard.account.create', $data);
    }



    public function store(Request $request)
    {
        // Validasi dengan custom messages
        $validated = $request->validate([
            'company_code' => 'required|max:255',
            'npk' => 'required|max:255',
            'name' => 'required|max:255',
            'username' => 'required|min:4|max:20|regex:/^[a-zA-Z0-9_.-]+$/|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'departement' => 'required|array',
            'departement.*' => 'required|string|max:255',
            'user_status' => 'required|max:255',
            'ext_phone' => 'nullable|max:255',
            'role_id' => 'required|in:1,2,3,4,5,6,7',
            'password' => 'required|min:6|confirmed',  // Password required for store method
        ], [
            // Custom error messages
            'username.regex' => 'Username hanya boleh mengandung huruf, angka, titik, underscore, dan strip.',
            'password.min' => 'Password (Minimal 6 karakter)',  // Custom message for password length validation
        ]);

        // Jika validasi berhasil, lanjutkan untuk membuat user
        $user = User::create([
            'company_code' => $validated['company_code'],
            'npk' => $validated['npk'],
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'departement' => implode(',', $validated['departement']), // Menggabungkan array departemen menjadi string
            'user_status' => $validated['user_status'],
            'ext_phone' => $validated['ext_phone'],
            'password' => bcrypt($validated['password']),   // Hash the password
            'email_verified_at' => now(), // Tandai email sebagai terverifikasi
        ]);

        Profile::create([
            'name' => $validated['name'],
            'user_id' => $user->id
        ]);

        return redirect()->route('account.index')->with('success', 'Account successfully created.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        // Find the user account by ID
        $account = User::findOrFail($id);
    
        // Get unique departments from the 'users' table
        $departement = User::select('departement')->distinct()->pluck('departement')->toArray();
    
        // Loop through the departments and split each one by comma
        $departementArray = [];
        foreach ($departement as $dept) {
            $departementArray = array_merge($departementArray, explode(',', $dept)); // Merge all departments into a single array
        }
        // Remove duplicates
        $departementArray = array_unique($departementArray);
    
        $roles = Role::all(); // Fetch all roles
    
        // Prepare data to send to the view
        $data = [
            'title' => 'Account | DPM',
            'account' => $account,
            'roles' => $roles,
            'departement' => $departementArray, // Send the processed array
        ];
    
        return view('dashboard.account.edit', $data);
    }
    
    public function editUser(string $id)
    {
        // Find the user account by ID
        $account = User::findOrFail($id);

        // Get unique departments from the 'users' table
        $departments = User::select('departement')->distinct()->pluck('departement')->toArray();
        
        $roles = Role::all(); // Fetch all roles

        // Prepare data to send to the view
        $data = [
            'title' => 'Account | DPM',
            'account' => $account,
            'roles' => $roles,
            'departments' => $departments,
        ]; 

        return view('dashboard.account.editUser', $data);
    }

    public function update(Request $request, string $id)
    {
        // Find the user account by ID
        $account = User::findOrFail($id);

        // Validate the incoming request
        $validated = $request->validate([
            'company_code' => 'required|max:255',
            'npk' => 'required|max:255',
            'name' => 'required|max:255',
            'username' => 'required|min:4|max:20|regex:/^[a-zA-Z0-9_.-]{4,20}$/|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'departement' => 'required|array', // Validasi array untuk multiple departemen
            'departement.*' => 'string|max:255', // Validasi tiap departemen
            'user_status' => 'required|max:255',
            'ext_phone' => 'nullable|max:255',
            'role_id' => 'required|in:1,2,3,4,5,6,7',
            'password' => 'nullable|min:6|confirmed',  // Password is optional for update
        ]);

        // Prepare account data for update
        $accountData = [
            'company_code' => $validated['company_code'],
            'npk' => $validated['npk'],
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'departement' => implode(',', $validated['departement']), // Menggabungkan array menjadi string
            'user_status' => $validated['user_status'],
            'ext_phone' => $validated['ext_phone'],
            'role_id' => $validated['role_id'],
        ];

        // Hash password if provided
        if ($request->filled('password')) {
            $accountData['password'] = bcrypt($validated['password']);
        }

        // Update the account with the validated data
        $account->update($accountData);

        // Redirect back to the account index page with a success message
        return redirect()->route('account.index')->with('success', 'Account successfully updated.');
    }

    public function updateUser(Request $request, string $id)
    {
        // Find the user account by ID
        $account = User::findOrFail($id);

        // Validate the incoming request
        $validated = $request->validate([
            'company_code' => 'required|max:255',
            'npk' => 'required|max:255',
            'name' => 'required|max:255',
            'username' => 'required|min:4|max:20|regex:/^[a-zA-Z0-9_.-]{4,20}$/|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'departement' => 'required|max:255',
            'user_status' => 'required|max:255',
            'ext_phone' => 'nullable|max:255',
            'role_id' => 'required|in:1,2,3,4,5,6,7',
            'password' => 'nullable|min:6|confirmed',  // Password is optional for update
        ]);

        // Prepare account data for update
        $accountData = [
            'company_code' => $validated['company_code'],
            'npk' => $validated['npk'],
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'departement' => $validated['departement'],
            'user_status' => $validated['user_status'],
            'ext_phone' => $validated['ext_phone'],
            'role_id' => $validated['role_id'],
        ];

        // Hash password if provided
        if ($request->filled('password')) {
            $accountData['password'] = bcrypt($validated['password']);
        }

        // Update the account with the validated data
        $account->update($accountData);

        // Redirect back to the account index page with a success message
        return redirect()->route('dashboard')->with('success', 'Account successfully updated.');
    }

    public function destroy(string $id)
    {
        $account = User::findOrFail($id);
        $account->delete();

        return redirect()->route('account.index')->with('success', 'Account successfully deleted.');
    }

    public function import(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // Maksimal 10MB
        ]);

        try {
            // Memulai proses impor
            Excel::import(new UserImport, $request->file('file'));
            
            // Redirect back dengan pesan sukses
            return redirect()->back()->with('success', 'Import successful');

        } catch (ValidationException $e) {
            // Mengambil error validasi
            $errors = $e->errors();

            // Menampilkan notifikasi error jika ada error validasi
            return redirect()->back()->with('error', 'The following validation errors occurred during import: ' . implode(', ', array_map(function($error) {
                return $error[0];  // Menampilkan error pertama dari setiap row
            }, $errors)));
        } catch (\Exception $e) {
            // Redirect dengan pesan error umum, Menangani exception lain
            return redirect()->back()->with('error', 'An error occurred during the import.');
        }
    }
}