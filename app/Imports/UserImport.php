<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class UserImport implements ToModel, WithValidation, WithHeadingRow
{
    public function model(array $row)
    {
        // Mapping text role_id to integers
        $roleMapping = [
            'user' => 1,
            'dh' => 2,
            'divh' => 3,
            'it' => 4
        ];

        // Normalize role_id
        $normalizedRoleId = strtolower($row['role_id']);
        $roleId = $roleMapping[$normalizedRoleId] ?? null;

        // Process departement values
        $departementArray = array_map('trim', explode(',', $row['departement']));
        
        // Hilangkan koma ekstra di awal atau akhir
        $departementString = trim(implode(',', array_filter($departementArray)), ',');

        // Cek apakah username sudah ada di database
        $user = User::where('username', $row['username'])->orWhere('email', $row['email'])->first();

        if ($user) {
            // Jika user sudah ada, update data tanpa mengganti password
            $existingDepartements = explode(',', $user->departement);
            $mergedDepartements = array_unique(array_merge($existingDepartements, $departementArray));

            $user->update([
                'company_code' => $row['company_code'],
                'npk' => $row['npk'],
                'name' => $row['name'],
                'email' => $row['email'],
                'role_id' => $roleId,
                'departement' => trim(implode(',', $mergedDepartements), ','), // Pastikan tidak ada koma ekstra
                'user_status' => $row['user_status'],
                'ext_phone' => $row['ext_phone'] ?? '',
            ]);

            return $user;
        } else {
            // Jika username tidak ada, buat user baru
            return new User([
                'company_code' => $row['company_code'],
                'name' => $row['name'],
                'username' => $row['username'],
                'email' => $row['email'],
                'role_id' => $roleId,
                'departement' => $departementString,
                'user_status' => $row['user_status'],
                'ext_phone' => $row['ext_phone'] ?? '',
                'password' => bcrypt($row['password']),
                'email_verified_at' => now(), // Tandai email sebagai terverifikasi
            ]);
        }
    }


    public function rules(): array
    {
        return [
            'company_code' => 'required|max:255',
            'npk' => 'required|max:255',
            'name' => 'required|max:255',
            'username' => [
                'required',
                'min:4',
                'max:20',
                'regex:/^[a-zA-Z0-9_.-]{4,20}$/',
                function ($attribute, $value, $fail) {
                    $existingUser = User::where('username', $value)->first();
                    if ($existingUser) {
                        return; // Lewati validasi jika username sudah ada (agar bisa diupdate)
                    }
                }
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    $existingUser = User::where('email', $value)->first();
                    if ($existingUser) {
                        return; // Lewati validasi jika email sudah ada (agar bisa diupdate)
                    }
                }
            ],
            'role_id' => ['required', function ($attribute, $value, $fail) {
                $validRoles = ['user', 'dh', 'divh', 'it'];
                if (!in_array(strtolower($value), $validRoles)) {
                    $fail('The selected role_id is invalid.');
                }
            }],
            'departement' => 'required|string|max:255',
            'user_status' => 'required|string|max:255',
            'ext_phone' => 'nullable|min:6',
            'password' => 'required|min:6',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        // Log import failures for troubleshooting
        foreach ($failures as $failure) {
            Log::error('Import Failure:', [
                'row' => $failure->row(),
                'errors' => $failure->errors(),
            ]);
        }
    }
}
