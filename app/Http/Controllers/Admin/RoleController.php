<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // Listado de roles
    public function index()
    {
        $roles = Role::orderBy('name')->get();
        return view('admin.roles.index', compact('roles'));
    }

    // Form para crear rol/departamento
    public function create()
    {
        // (Opcional) lista de permisos disponibles si luego quieres asignar
        $permissions = Permission::orderBy('name')->pluck('name', 'id');
        return view('admin.roles.create', compact('permissions'));
    }

    // Guardar rol/departamento
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:roles,name'],
            'clone_from'  => ['nullable', 'string'], // nombre de rol para clonar permisos
            'guard_name'  => ['nullable', 'in:web'], // fijamos web
        ], [
            'name.unique' => 'Ya existe un rol con ese nombre.',
        ]);

        $role = Role::create([
            'name'       => $data['name'],
            'guard_name' => 'web',
        ]);

        // Si se eligió clonar permisos desde otro rol (p.ej. SuperAdmin)
        if (!empty($data['clone_from'])) {
            $from = Role::where('name', $data['clone_from'])->where('guard_name', 'web')->first();
            if ($from) {
                $role->syncPermissions($from->permissions);
            }
        }

        return redirect()->route('admin.roles.index')->with('success', 'Rol creado correctamente.');
    }
}
