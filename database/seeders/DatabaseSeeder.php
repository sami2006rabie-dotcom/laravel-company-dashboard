<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Information Technology', 'head_name' => 'John Doe', 'location' => 'Building A - Floor 3', 'description' => 'IT Department'],
            ['name' => 'Human Resources', 'head_name' => 'Jane Smith', 'location' => 'Building B - Floor 2', 'description' => 'HR Department'],
            ['name' => 'Sales & Marketing', 'head_name' => 'Bob Johnson', 'location' => 'Building C - Floor 1', 'description' => 'Sales Department'],
            ['name' => 'Operations', 'head_name' => 'Sarah Wilson', 'location' => 'Building A - Floor 1', 'description' => 'Operations Department'],
            ['name' => 'Finance', 'head_name' => 'Michael Brown', 'location' => 'Building B - Floor 3', 'description' => 'Finance Department']
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@company.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'phone_verified' => true,
        ]);

        $users = [
            ['name' => 'John Smith', 'email' => 'john@company.com', 'department_id' => 1, 'position' => 'Senior Developer'],
            ['name' => 'Mary Johnson', 'email' => 'mary@company.com', 'department_id' => 2, 'position' => 'HR Manager'],
            ['name' => 'David Wilson', 'email' => 'david@company.com', 'department_id' => 3, 'position' => 'Sales Executive'],
            ['name' => 'Emily Davis', 'email' => 'emily@company.com', 'department_id' => 1, 'position' => 'Junior Developer'],
            ['name' => 'James Miller', 'email' => 'james@company.com', 'department_id' => 4, 'position' => 'Operations Manager'],
            ['name' => 'Lisa Anderson', 'email' => 'lisa@company.com', 'department_id' => 5, 'position' => 'Finance Analyst']
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password123'),
                'role' => 'user',
                'department_id' => $user['department_id'],
                'position' => $user['position'],
                'email_verified_at' => now(),
            ]);
        }
    }
}