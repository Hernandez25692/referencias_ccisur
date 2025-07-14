<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['SuperAdmin', 'GAF', 'GOR', 'GSEA', 'DE'];

        foreach ($roles as $rol) {
            Role::firstOrCreate(['name' => $rol]);
        }

        // Usuario SuperAdmin
        $admin = User::firstOrCreate(
            ['email' => 'admin@ccisur.test'],
            [
                'name' => 'Administrador CCISUR',
                'password' => Hash::make('admin1234'),
            ]
        );
        $admin->syncRoles('SuperAdmin');

        // Usuario normal GSEA
        $usuario = User::firstOrCreate(
            ['email' => 'usuario@ccisur.test'],
            [
                'name' => 'Usuario GSEA',
                'password' => Hash::make('usuario1234'),
            ]
        );
        $usuario->syncRoles('GSEA');

        $this->command->info('Usuarios creados:');
        $this->command->warn("➡ SuperAdmin → admin@ccisur.test / admin1234");
        $this->command->warn("➡ Usuario GSEA → usuario@ccisur.test / usuario1234");
    }
}
