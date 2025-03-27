<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserImport implements ToModel, WithValidation, WithHeadingRow
{
    public function model(array $row)
    {
        // Mapping text role_id to integers
        $roleMapping = [
            'user'  => 1,
            'dh'    => 2,
            'divh'  => 3,
            'it'    => 4
        ];

        // Normalize role_id
        $normalizedRoleId = strtolower(trim($row['role_id']));
        $roleId = $roleMapping[$normalizedRoleId] ?? null;

        if (!$roleId) {
            Log::error("Invalid role_id: " . $row['role_id']);
            return null;
        }

        // Proses departement agar menjadi string dengan format yang benar
        $departementArray = array_map('trim', explode(',', $row['departement']));
        $departementString = implode(',', array_filter($departementArray));

        // Cari user berdasarkan username atau email
        $user = User::where('username', $row['username'])->orWhere('email', $row['email'])->first();

        if ($user) {
            // Jika user sudah ada, update data tanpa mengganti password
            $existingDepartements = is_string($user->departement)
                ? array_map('trim', explode(',', $user->departement))
                : [];

            // Gabungkan departement baru dengan yang sudah ada
            $mergedDepartements = array_unique(array_merge($existingDepartements, $departementArray));
            $finalDepartement = implode(',', $mergedDepartements);

            $user->update([
                'company_code' => $row['company_code'],
                'npk'          => $row['npk'],
                'name'         => $row['name'],
                'email'        => $row['email'],
                'role_id'      => $roleId,
                'departement'  => $finalDepartement,
                'user_status'  => $row['user_status'],
                'ext_phone'    => $row['ext_phone'] ?? '',
            ]);

            Log::info("User updated: " . $row['username']);
            return $user;
        } else {
            // Jika user tidak ditemukan, buat user baru
            return new User([
                'company_code'      => $row['company_code'],
                'npk'               => $row['npk'],
                'name'              => $row['name'],
                'username'          => $row['username'],
                'email'             => $row['email'],
                'role_id'           => $roleId,
                'departement'       => $departementString,
                'user_status'       => $row['user_status'],
                'ext_phone'         => $row['ext_phone'] ?? '',
                'password'          => Hash::make($row['password']),
                'email_verified_at' => now(), // Tandai email sebagai terverifikasi
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'company_code' => 'required|max:255',
            'npk'         => 'required|max:255',
            'name'        => 'required|max:255',
            'username'    => [
                'required',
                'min:4',
                'max:20',
                'regex:/^[a-zA-Z0-9_.-]{4,20}$/',
                function ($attribute, $value, $fail) {
                    if (User::where('username', $value)->exists()) {
                        return; // Lewati validasi jika username sudah ada (agar bisa diupdate)
                    }
                }
            ],
            'email'       => [
                'required',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (User::where('email', $value)->exists()) {
                        return; // Lewati validasi jika email sudah ada (agar bisa diupdate)
                    }
                }
            ],
            'role_id'     => [
                'required',
                function ($attribute, $value, $fail) {
                    $validRoles = ['user', 'dh', 'divh', 'it'];
                    if (!in_array(strtolower(trim($value)), $validRoles)) {
                        $fail('The selected role_id is invalid.');
                    }
                }
            ],
            'departement' => 'required|string|max:255',
            'user_status' => 'required|string|max:255',
            'ext_phone'   => 'nullable|min:6',
            'password'    => 'required|min:6',
        ];
    }

    public function onFailure(\Maatwebsite\Excel\Validators\Failure ...$failures)
    {
        foreach ($failures as $failure) {
            Log::error('Import Failure:', [
                'row'    => $failure->row(),
                'errors' => $failure->errors(),
            ]);
        }
    }
}
