<?php

namespace Tests\Feature;

use App\Models\Referencia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ReferenciaAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function crearUsuario(string $rol): User
    {
        Role::firstOrCreate(['name' => $rol]);

        $user = User::factory()->create();
        $user->assignRole($rol);

        return $user;
    }

    protected function crearReferencia(string $departamento, User $autor): Referencia
    {
        return Referencia::create([
            'correlativo' => 'REF-CCISUR/' . $departamento . '-2026-001',
            'asunto' => 'Asunto de prueba',
            'departamento' => $departamento,
            'estado' => 'pendiente',
            'user_id' => $autor->id,
        ]);
    }

    public function test_usuario_no_puede_ver_referencia_de_otro_departamento(): void
    {
        $autorGor = $this->crearUsuario('GOR');
        $referenciaGor = $this->crearReferencia('GOR', $autorGor);
        $usuarioGaf = $this->crearUsuario('GAF');

        $this->actingAs($usuarioGaf)
            ->get(route('referencias.show', $referenciaGor))
            ->assertForbidden();
    }

    public function test_usuario_no_puede_actualizar_referencia_de_otro_departamento(): void
    {
        $autorGor = $this->crearUsuario('GOR');
        $referenciaGor = $this->crearReferencia('GOR', $autorGor);
        $usuarioGaf = $this->crearUsuario('GAF');

        $this->actingAs($usuarioGaf)
            ->put(route('referencias.update', $referenciaGor), ['asunto' => 'hackeado'])
            ->assertForbidden();

        $this->assertDatabaseHas('referencias', [
            'id' => $referenciaGor->id,
            'asunto' => 'Asunto de prueba',
        ]);
    }

    public function test_usuario_no_puede_ver_bitacora_de_otro_departamento(): void
    {
        $autorGor = $this->crearUsuario('GOR');
        $referenciaGor = $this->crearReferencia('GOR', $autorGor);
        $usuarioGaf = $this->crearUsuario('GAF');

        $this->actingAs($usuarioGaf)
            ->get(route('referencias.bitacora', $referenciaGor))
            ->assertForbidden();
    }

    public function test_usuario_regular_no_puede_ver_bitacora_de_su_propio_departamento(): void
    {
        $autorGaf = $this->crearUsuario('GAF');
        $referenciaGaf = $this->crearReferencia('GAF', $autorGaf);

        $this->actingAs($autorGaf)
            ->get(route('referencias.bitacora', $referenciaGaf))
            ->assertForbidden();
    }

    public function test_usuario_si_puede_ver_y_actualizar_referencia_de_su_propio_departamento(): void
    {
        $autorGaf = $this->crearUsuario('GAF');
        $referenciaGaf = $this->crearReferencia('GAF', $autorGaf);

        $this->actingAs($autorGaf)
            ->get(route('referencias.show', $referenciaGaf))
            ->assertOk();

        $this->actingAs($autorGaf)
            ->put(route('referencias.update', $referenciaGaf), ['asunto' => 'actualizado'])
            ->assertRedirect(route('referencias.index'));

        $this->assertDatabaseHas('referencias', [
            'id' => $referenciaGaf->id,
            'asunto' => 'actualizado',
        ]);
    }

    public function test_superadmin_puede_ver_referencia_y_bitacora_de_cualquier_departamento(): void
    {
        $autorGor = $this->crearUsuario('GOR');
        $referenciaGor = $this->crearReferencia('GOR', $autorGor);
        $superAdmin = $this->crearUsuario('SuperAdmin');

        $this->actingAs($superAdmin)
            ->get(route('referencias.show', $referenciaGor))
            ->assertOk();

        $this->actingAs($superAdmin)
            ->get(route('referencias.bitacora', $referenciaGor))
            ->assertOk();
    }
}
