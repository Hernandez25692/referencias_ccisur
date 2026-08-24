<?php

namespace App\Policies;

use App\Models\Referencia;
use App\Models\User;

class ReferenciaPolicy
{
    /**
     * Roles con visibilidad sobre referencias de todos los departamentos.
     */
    protected function esSupervisor(User $user): bool
    {
        return $user->hasAnyRole(['SuperAdmin', 'Invitado']);
    }

    public function view(User $user, Referencia $referencia): bool
    {
        return $this->esSupervisor($user)
            || $referencia->departamento === $user->getRoleNames()->first();
    }

    public function update(User $user, Referencia $referencia): bool
    {
        return $referencia->departamento === $user->getRoleNames()->first();
    }

    public function viewBitacora(User $user, Referencia $referencia): bool
    {
        return $this->esSupervisor($user);
    }
}
