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

        // Normalize role_id to lowercase for flexible matching
        $normalizedRoleId = strtolower($row['role_id']);

        // Map the normalized role_id to an integer
        $roleId = $roleMapping[$normalizedRoleId] ?? null;

        // If role_id is invalid, set it to null
        if (!$roleId) {
            $roleId = null;
        }

        // Ensure departement value is valid (could be part of system configuration or predefined)
        $validDepartements = ['HR', 'IT', 'Finance', 'Marketing', 'PPIC'];  // Add PPIC here to allow it

        // Process the departement value to remove spaces and ensure correct format
        $departement = $this->processDepartements($row['departement'], $validDepartements);

        // If departement is invalid after processing, log an error or handle it as needed
        if (empty($departement)) {
            Log::warning('Invalid or empty departement value: ' . $row['departement']);
        }

        // Return the User model with the mapped role_id and departement
        return new User([
            'npk' => $row['npk'],
            'name' => $row['name'],
            'username' => $row['username'],
            'email' => $row['email'],
            'role_id' => $roleId,
            'departement' => implode(',', $departement), // Convert array to string (no spaces)
            'user_status' => $row['user_status'],
            'ext_phone' => $row['ext_phone'] ?? '',
            'password' => bcrypt($row['password']), // Hash password before storing
        ]);
    }

    /**
     * Process the departement string or array from Excel.
     * Ensure no spaces after commas and each departement is valid.
     * 
     * @param string|array $departement
     * @param array $validDepartements
     * @return array
     */
    private function processDepartements($departement, $validDepartements)
    {
        // If departement is a string, convert it into an array by splitting on commas
        if (is_string($departement)) {
            $departement = explode(',', $departement);  // Assuming departements are comma-separated
        }

        // Remove any leading or trailing spaces and filter valid departements
        $departement = array_map('trim', $departement);  // Remove spaces from each department

        // Filter out any invalid departements
        $departement = array_filter($departement, function ($dept) use ($validDepartements) {
            return in_array($dept, $validDepartements);
        });

        // Return the validated departements
        return array_values($departement); // Reindex the array to remove any gaps
    }
    
    public function rules(): array
    {
        // Custom validation rule for role_id
        return [
            'npk' => 'required|max:255',
            'name' => 'required|max:255',
            'username' => 'required|min:4|max:20|regex:/^[a-zA-Z0-9_.-]{4,20}$/|unique:users,username,',
            'email' => 'required|email|max:255|unique:users,email',
            'role_id' => ['required', function ($attribute, $value, $fail) {
                // Normalize role_id to lowercase before validating
                $normalizedRoleId = strtolower($value);
                
                // Mapping for role_id
                $validRoles = ['user', 'dh', 'divh', 'it'];
                
                // Check if the role is valid
                if (!in_array($normalizedRoleId, $validRoles)) {
                    $fail('The selected role_id is invalid.');
                }
            }],
            'departement' => 'required|string|max:255', // Ensure departement is required and valid
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
