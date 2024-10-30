<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@xal.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $admin->assignRole('Admin');
    
        // Responsable User
        $responsable = User::create([
            'name' => 'Responsable User',
            'email' => 'responsable@xal.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $responsable->assignRole('Responsable');
    
        // Gestionnaire User
        $gestionnaire = User::create([
            'name' => 'Gestionnaire User',
            'email' => 'gestionnaire@xal.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $gestionnaire->assignRole('Gestionnaire');
    
        // Regular User
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@xal.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $user->assignRole('Gestionnaire');
    
        // Inactive User
        $inactive = User::create([
            'name' => 'Inactive User',
            'email' => 'inactive@xal.com',
            'password' => Hash::make('password'),
            'is_active' => false,
        ]);
        $inactive->assignRole('Gestionnaire');
    
        // Additional Users
        $additionalUsers = [
            [
                'name' => 'User One',
                'email' => 'user1@xal.com',
                'password' => Hash::make('password1'),
                'is_active' => true,
                'role' => 'Responsable'
            ],
            [
                'name' => 'User Two',
                'email' => 'user2@xal.com',
                'password' => Hash::make('password2'),
                'is_active' => true,
                'role' => 'Gestionnaire'
            ],
            [
                'name' => 'User Three',
                'email' => 'user3@xal.com',
                'password' => Hash::make('password3'),
                'is_active' => false,
                'role' => 'Admin'
            ],
            [
                'name' => 'User Four',
                'email' => 'user4@xal.com',
                'password' => Hash::make('password4'),
                'is_active' => true,
                'role' => 'Gestionnaire'
            ],
            [
                'name' => 'User Five',
                'email' => 'user5@xal.com',
                'password' => Hash::make('password5'),
                'is_active' => true,
                'role' => 'Responsable'
            ],
            [
                'name' => 'User Six',
                'email' => 'user6@xal.com',
                'password' => Hash::make('password6'),
                'is_active' => true,
                'role' => 'Admin'
            ],
            [
                'name' => 'User Seven',
                'email' => 'user7@xal.com',
                'password' => Hash::make('password7'),
                'is_active' => false,
                'role' => 'Gestionnaire'
            ],
            [
                'name' => 'User Eight',
                'email' => 'user8@xal.com',
                'password' => Hash::make('password8'),
                'is_active' => true,
                'role' => 'Responsable'
            ],
            [
                'name' => 'User Nine',
                'email' => 'user9@xal.com',
                'password' => Hash::make('password9'),
                'is_active' => true,
                'role' => 'Admin'
            ],
            [
                'name' => 'User Ten',
                'email' => 'user10@xal.com',
                'password' => Hash::make('password10'),
                'is_active' => false,
                'role' => 'Gestionnaire'
            ]
        ];
    
        foreach ($additionalUsers as $additionalUser) {
            $user = User::create([
                'name' => $additionalUser['name'],
                'email' => $additionalUser['email'],
                'password' => $additionalUser['password'],
                'is_active' => $additionalUser['is_active'],
            ]);
            $user->assignRole($additionalUser['role']);
        }
    }
    
}
