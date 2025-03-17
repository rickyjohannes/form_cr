<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Account Supervisor
        $supervisor = User::create([
            'username' => 'divh',
            'email' => 'divh@gmail.com',
            'departement' => 'IT',
            'email_verified_at' => null,
            'password' => 'password',
            'role_id'=> 1,
        ]);

        // Account Admin
        $admin = User::create([
            'username' => 'dh',
            'email' => 'dh@gmail.com',
            'departement' => 'IT',
            'email_verified_at' => null,
            'password' => 'password',
            'role_id'=> 2,
        ]);

        // Account User
        $user = User::create([
            'username' => 'user',
            'email' => 'user@gmail.com',
            'departement' => 'IT',
            'email_verified_at' => null,
            'password' => 'password',
            'role_id'=> 3,
        ]);

        // Mark Verified Email
        $supervisor->markEmailAsVerified();
        $admin->markEmailAsVerified();
        $user->markEmailAsVerified();

        // Profile Supervisor
        Profile::create([
            'name' => 'divh',
            'user_id' => $divh->id
        ]);

        // Profile Admin
        Profile::create([
            'name' => 'dh',
            'user_id' => $dh->id
        ]);
        
        // Profile User
        Profile::create([
            'name' => 'user',
            'user_id' => $user->id
        ]);
    }
}
