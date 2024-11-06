<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
        $roles = Role::all();
        $data = [
            'title' => 'Account | DPM',
            'roles' => $roles
        ]; 
        return view('dashboard.account.create', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:4|max:20|regex:/^[a-zA-Z0-9_.-]{4,20}$/|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'departement' => 'required|max:255',
            'user_status' => 'required|max:255',
            'ext_phone' => 'required|max:255',
            'role_id' => 'required|in:1,2,3,4,5,6,7',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'departement' => $validated['departement'],
            'user_status' => $validated['user_status'],
            'ext_phone' => $validated['ext_phone'],
            'password' => $validated['password']
        ]);
        
        Profile::create([
            'name' => $validated['name'],
            'user_id' => $user->id
        ]);

        $user->markEmailAsVerified();

        return redirect()->route('account.index')->with('Account successfully created.');
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
}
