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
            'manage prescriptions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrcreate(['name' => $permission]);
        }

        // create roles and assign existing permissions
        $doctor = Role::firstOrCreate(['name' => 'doctor']);
        $doctor->syncPermissions(['manage appointments', 'manage services', 'manage patients']);

        $receptionist = Role::firstOrCreate(['name' => 'receptionist']);
        $receptionist->syncPermissions(['manage appointments', 'manage patients']);

        $patient = Role::firstOrCreate(['name' => 'patient']);
        $patient->syncPermissions('manage appointments');

        $pharmacist = Role::firstOrCreate(['name' => 'pharmacist']);
        $pharmacist->syncPermissions('manage prescriptions');

        $nurse = Role::firstOrCreate(['name' => 'nurse']);
        $nurse->syncPermissions('manage prescriptions');

        $lab_technician = Role::firstOrCreate(['name' => 'lab_technician']);
        $lab_technician->syncPermissions('manage prescriptions');

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(['manage appointments', 'manage services', 'manage doctors', 'manage patients', 'manage departments', 'manage resources', 'manage blogs', 'manage users']);

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
            'country' => 'Kenya',
            'city' => 'Nairobi',
            'address' => 'Nairobi',
            'phone_number' => '0728745303',
            'gender' => 'male',
            'status' => 'active',
        ]);


        // Assign the admin role to this user
        $adminUser->syncRoles([$admin->name]);
        $adminUser->update(['role' => 'admin']);

        // Assign roles to existing users based on their current role in the database
        $users = User::all();

        foreach ($users as $user) {

            if ($user->role && in_array($user->role, ['admin', 'doctor', 'receptionist', 'patient'])) {
                $user->syncRoles([$user->role]);
            } else {
                $user->syncRoles(['patient']); // Default role for new users
            }
        }

        // clear cache again after seeding
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }


}
