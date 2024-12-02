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
        // $accounts = User::with(['profile'])->where('id', '!=', $id)->get();
        $accounts = User::with(['profile'])->get();
        $data = [
            'title' => 'Account | DPM',
            'accounts' => $accounts
        ];

        return view('dashboard.account.index', $data);
    }

    public function create()
    {
        // Mengambil data unik departemen dari tabel 'proposal'
        $departments = User::distinct('departement')->pluck('departement');

        $roles = Role::all();
        $data = [
            'title' => 'Account | DPM',
            'roles' => $roles,
            'departments' => $departments,
        ]; 
        return view('dashboard.account.create', $data);
    }

    public function store(Request $request)
    {
        // Validasi dengan custom messages
        $validated = $request->validate([
            'npk' => 'required|max:255',
            'name' => 'required|max:255',
            'username' => 'required|min:4|max:20|regex:/^[a-zA-Z0-9_.-]{4,20}$/|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'departement' => 'required|max:255',
            'user_status' => 'required|max:255',
            'ext_phone' => 'nullable|max:255',
            'role_id' => 'required|in:1,2,3,4,5,6,7',
            'password' => 'required|min:6|confirmed',  // Password required for store method
        ], [
            // Custom error messages
            'password.min' => 'Password (Minimal 6 karakter)',  // Custom message for password length validation
        ]);

        // Jika validasi berhasil, lanjutkan untuk membuat user
        $user = User::create([
            'npk' => $validated['npk'],
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'departement' => $validated['departement'],
            'user_status' => $validated['user_status'],
            'ext_phone' => $validated['ext_phone'],
            'password' => bcrypt($validated['password'])  // Hash the password
        ]);

        Profile::create([
            'name' => $validated['name'],
            'user_id' => $user->id
        ]);

        $user->markEmailAsVerified();

        return redirect()->route('account.index')->with('success', 'Account successfully created.');
    }



    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $account = User::with('profile')->findOrFail($id); // Fetch account with profile
        $roles = Role::all();
        // Optional: You can fetch departments from a config or directly from the database if needed, 
        // but since it's a static field in the users table, we won't fetch it.

        // Static department list for the dropdown
        $departments = ['IT', 'PPIC', 'MARKETING', 'ACCOUNTING', 'FINANCE', 'ENGINEERING', 'MAINTENANCE'];

        return view('dashboard.account.edit', [
            'title' => 'Account | DPM',
            'account' => $account,
            'roles' => $roles,
            'departments' => $departments,
        ]);
    }


    public function update(Request $request, string $id)
    {
        $account = User::findOrFail($id);

        // Validate the incoming request
        $validated = $request->validate([
            'npk' => 'required|max:255',
            'name' => 'required|max:255',
            'username' => 'required|min:4|max:20|regex:/^[a-zA-Z0-9_.-]{4,20}$/|unique:users,username,' . $account->id,
            'email' => 'required|email|unique:users,email,' . $account->id,
            'departement' => 'required|in:IT,PPIC,MARKETING,ACCOUNTING,FINANCE,ENGINEERING,MAINTENANCE', // Validate against static departments
            'user_status' => 'required|max:255',
            'ext_phone' => 'required|max:255',
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Prepare account data for update
        $accountData = [
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

        // Update the account
        $account->update($accountData);

        // Update the associated profile
        $profile = Profile::where('user_id', $id)->firstOrFail();
        $profile->update(['name' => $validated['name']]);

        return redirect()->route('account.index')->with('success', 'Account successfully updated.');
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
            
            // Log jika sukses
            Log::info('Import completed successfully.');

            // Redirect back dengan pesan sukses
            return redirect()->back()->with('success', 'Import successful');

        } catch (ValidationException $e) {
            // Mengambil error validasi
            $errors = $e->errors();

            // Log jika ada error validasi
            Log::error('Validation failed during import.', ['errors' => $errors]);

            // Menampilkan notifikasi error jika ada error validasi
            return redirect()->back()->with('error', 'The following validation errors occurred during import: ' . implode(', ', array_map(function($error) {
                return $error[0];  // Menampilkan error pertama dari setiap row
            }, $errors)));
        } catch (\Exception $e) {
            // Menangani exception lain dan log error
            Log::error('An error occurred during the import.', ['exception' => $e->getMessage()]);

            // Redirect dengan pesan error umum
            return redirect()->back()->with('error', 'An error occurred during the import.');
        }
    }



}
