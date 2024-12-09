<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log; // For logging

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

        // Map the role_id based on the string to integer
        $roleId = isset($roleMapping[strtolower($row['role_id'])]) ? $roleMapping[strtolower($row['role_id'])] : null;

        // Return the User model with the mapped role_id
        return new User([
            'npk' => $row['npk'],
            'name' => $row['name'],
            'username' => $row['username'],
            'email' => $row['email'],
            'role_id' => $roleId, // role_id is now mapped to an integer
            'departement' => $row['departement'],
            'user_status' => $row['user_status'],
            'ext_phone' => $row['ext_phone'] ?? '',
            'password' => $row['password'],
        ]);
    }

    public function rules(): array
    {
        return [
            'npk' => 'required|max:255',
            'name' => 'required|max:255',
            'username' => 'required|min:4|max:20|regex:/^[a-zA-Z0-9_.-]{4,20}$/|unique:users,username,',
            'email' => 'required|email|max:255|unique:users,email',
            'role_id' => 'required|in:user,dh,divh,it', // Validate the role_id as a string from Excel
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
