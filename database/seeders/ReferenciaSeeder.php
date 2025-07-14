<?php

namespace Database\Seeders;

use App\Models\Referencia;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReferenciaSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'usuario@ccisur.test')->first();

        if (!$user) {
            $this->command->warn('❌ Usuario GSEA no encontrado. Asegúrate de correr primero el UserSeeder.');
            return;
        }

        $departamento = $user->getRoleNames()->first() ?? 'GSEA';

        $años = [2021, 2022, 2023, 2024, 2025];
        $cantidadPorAño = 100;

        foreach ($años as $año) {
            for ($i = 1; $i <= $cantidadPorAño; $i++) {
                $correlativo = 'REF-CCISUR/' . $departamento . '-' . $año . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);

                Referencia::create([
                    'correlativo' => $correlativo,
                    'asunto' => "Referencia simulada del año $año",
                    'solicitado_por' => 'Persona ' . $i,
                    'autorizado_por' => 'Supervisor ' . $i,
                    'documento' => null,
                    'departamento' => $departamento,
                    'estado' => 'pendiente',
                    'user_id' => $user->id,
                    'created_at' => Carbon::create($año, rand(1, 12), rand(1, 28), rand(8, 18)),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('✅ Referencias generadas exitosamente para el usuario GSEA.');
    }
}
