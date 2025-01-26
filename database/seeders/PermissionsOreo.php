<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsOreo extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'manage appointments',
            'manage services',
            'manage doctors',
            'manage patients',
            'manage departments',
            'manage resources',
            'manage blogs',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // create roles and assign existing permissions
        $doctor = Role::firstOrCreate(['name' => 'Doctor']);
        $doctor->givePermissionTo('manage appointments', 'manage services', 'manage patients');

        $receptionist = Role::firstOrCreate(['name' => 'Receptionist']);
        $receptionist->givePermissionTo('manage appointments', 'manage patients');

        $patient = Role::firstOrCreate(['name' => 'Patient']);
        $patient->givePermissionTo('manage appointments');

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->givePermissionTo('manage appointments', 'manage services', 'manage doctors', 'manage patients', 'manage departments', 'manage resources', 'manage blogs', 'manage users');

        // Create demo admin user if it does not exist
        $adminUser = User::firstOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'fname' => 'Hillary',
            'lname' => 'Okwach',
            'username' => 'Okwach',
            'password' => bcrypt('123456789'), // Use a secure password
            'role' => 'admin', // Only if this field is necessary
        ]);

        //associated profile
        $adminUser->profile()->create([
            'user_id' => $adminUser->id,
            'profile_type' => 'user',
            'country' => 'Kenya',
            'city' => 'Nairobi',
            'address' => 'Nairobi',
            'phone_number' => '0728745303',
            'gender' => 'male',
            'status' => 'active',
        ]);


        // Assign the admin role to this user
        $adminUser->assignRole($admin);

        // Assign roles to existing users based on their current role in the database
        $users = User::all();
        foreach ($users as $user) {
            // Assuming you have a `role` column in your users table
            if ($user->role === 'admin') {
                $user->syncRoles([$admin]);
            } elseif ($user->role === 'doctor') {
                $user->syncRoles([$doctor]);
            } elseif ($user->role === 'receptionist') {
                $user->syncRoles([$receptionist]);
            } else {
                // Default role
                $user->syncRoles([$patient]);
            }
        }
    }


}
