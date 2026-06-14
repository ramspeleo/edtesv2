<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'System Administrator']);
        Role::firstOrCreate(['name' => 'Records Officer']);
        Role::firstOrCreate(['name' => 'Office User']);
        Role::firstOrCreate(['name' => 'Approver']);
        Role::firstOrCreate(['name' => 'Viewer']);
    }
}