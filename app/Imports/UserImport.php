<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithValidation, WithHeadingRow
{
    public function model(array $row)
    {
        // Menampilkan data dari baris saat diimpor


        // Proses data yang diimpor
        return new User([
            'npk' => $row['npk'],
            'name' => $row['name'],
            'username' => $row['username'],
            'email' => $row['email'],
            'role_id' => $row['role_id'],
            'departement' => $row['departement'],
            'user_status' => $row['user_status'],
            'ext_phone' => $row['ext_phone'],
            'password' => $row['password'], // Bisa kosong atau terenkripsi
        ]);
    }

    public function rules(): array
    {
        return [
            'npk' => 'required|max:255',
            'name' => 'required|max:255',
            'username' => 'required|string|max:20|regex:/^[a-zA-Z0-9_.-]{4,20}$/|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'role_id' => 'required|in:1,2,3,4',
            'departement' => 'required|string|max:255',
            'user_status' => 'required|string|max:255',
            'ext_phone' => 'nullable|min:6',
            'password' => 'required|min:6',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        // Menampilkan kegagalan validasi untuk setiap baris yang gagal
        foreach ($failures as $failure) {
            Log::error('Import Failure:', [
                'row' => $failure->row(),
                'errors' => $failure->errors(),
            ]);
        }
    }
}
