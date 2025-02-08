<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insertar los roles en la tabla 'roles'
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);
    }
}
