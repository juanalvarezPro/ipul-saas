<?php

namespace Database\Seeders;

use App\Enums\userStatus;
use App\Models\Church;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                // Crear una iglesia de prueba (solo si aún no existe alguna)
                $church = Church::create([
                    'name' => 'Iglesia General',
                    'country_id' => 170, // País por defecto, por ejemplo, Panamá
                    'province_id' => 1386, // Asumiendo que tienes una provincia con ID 1
                    'corregimiento_id' => 80073, // Asumiendo que tienes un corregimiento con ID 1
                    'pastor_name' => 'Pastor Juan Pérez',
                    'email' => 'contacto@iglesiacentral.com',
                    'phone' => '64235678',
                    'street_address' => 'Calle Ficticia 123, Ciudad',
                    'active' => true,
                ]);
        
                // Crear un usuario de prueba
                User::create([
                    'name' => 'Admin User',
                    'email' => 'admin@example.com',
                    'password' => Hash::make('password123'), // Contraseña encriptada
                    'status' => userStatus::APPROVED,
                    'church_id' => $church->id, // Relacionar al usuario con la iglesia creada
                ]);
    }
}
