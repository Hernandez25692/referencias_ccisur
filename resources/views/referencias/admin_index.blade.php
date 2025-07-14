@extends('layouts.app')

@section('content')
    <style>
        :root {
            --azul-oscuro: #002c5f;
            --celeste: #009fe3;
            --gris-fondo: #f8fafc;
            --gris-borde: #e0e7ef;
            --gris-claro: #e6f2fa;
            --gris-hover: #b3d8f4;
            --blanco: #fff;
            --dorado: #b79a37;
            --gris-placeholder: #7b8794;
        }

        /* General container */
        .tabla-admin-container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 1rem;
        }

        /* Título */
        .tabla-admin-titulo {
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            color: var(--azul-oscuro);
            margin-bottom: 1.5rem;
            letter-spacing: 0.01em;
        }

        /* Formulario de filtros */
        .tabla-admin-filtros {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            background: var(--gris-fondo);
            border: 1.5px solid var(--azul-oscuro);
            border-radius: 0.75rem;
            padding: 1.2rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px 0 rgba(0,44,95,0.07);
        }
        @media (min-width: 700px) {
            .tabla-admin-filtros {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }
        .tabla-admin-filtros-campos {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            width: 100%;
        }
        @media (min-width: 700px) {
            .tabla-admin-filtros-campos {
                flex-direction: row;
                width: auto;
            }
        }
        .tabla-admin-filtros input[type="text"],
        .tabla-admin-filtros select {
            padding: 0.6rem 1rem;
            border: 1.5px solid var(--gris-borde);
            border-radius: 0.5rem;
            font-size: 1rem;
            color: var(--azul-oscuro);
            background: var(--blanco);
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
            min-width: 140px;
        }
        .tabla-admin-filtros input[type="text"]:focus,
        .tabla-admin-filtros select:focus {
            border-color: var(--celeste);
            box-shadow: 0 0 0 2px #009fe340;
        }
        .tabla-admin-filtros input[type="text"]::placeholder {
            color: var(--gris-placeholder);
            opacity: 1;
        }
        .tabla-admin-filtros select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M6 8L0.803847 0.5L11.1962 0.5L6 8Z' fill='%23009fe3'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.8rem center;
            background-size: 1rem;
        }
        .tabla-admin-filtros-botones {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        @media (min-width: 700px) {
            .tabla-admin-filtros-botones {
                margin-top: 0;
            }
        }
        .tabla-admin-btn {
            padding: 0.6rem 1.3rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.18s, color 0.18s, box-shadow 0.18s;
            box-shadow: 0 1px 4px 0 rgba(0,44,95,0.07);
        }
        .tabla-admin-btn-filtrar {
            background: linear-gradient(90deg, var(--celeste) 60%, var(--azul-oscuro) 100%);
            color: var(--blanco);
        }
        .tabla-admin-btn-filtrar:hover, .tabla-admin-btn-filtrar:focus {
            background: linear-gradient(90deg, var(--azul-oscuro) 60%, var(--celeste) 100%);
            box-shadow: 0 2px 8px 0 rgba(0,44,95,0.13);
        }
        .tabla-admin-btn-limpiar {
            background: var(--gris-borde);
            color: var(--azul-oscuro);
        }
        .tabla-admin-btn-limpiar:hover, .tabla-admin-btn-limpiar:focus {
            background: var(--celeste);
            color: var(--blanco);
        }

        /* Tabla */
        .tabla-admin-table-container {
            overflow-x: auto;
        }
        .tabla-admin-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: var(--blanco);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 2px 16px 0 rgba(0,44,95,0.10);
            border: 1.5px solid var(--azul-oscuro);
            min-width: 900px;
        }
        .tabla-admin-table thead tr {
            background: linear-gradient(90deg, var(--azul-oscuro) 60%, var(--celeste) 100%);
            color: var(--blanco);
            box-shadow: 0 2px 8px 0 rgba(0,44,95,0.10);
        }
        .tabla-admin-table th, .tabla-admin-table td {
            padding: 0.85rem 1.1rem;
            text-align: left;
            font-size: 1rem;
            vertical-align: middle;
        }
        .tabla-admin-table th {
            font-weight: 700;
            letter-spacing: 0.01em;
            border-bottom: 2px solid var(--celeste);
        }
        .tabla-admin-table tbody tr {
            transition: background 0.18s, box-shadow 0.18s;
            border-left: 4px solid transparent;
        }
        .tabla-admin-table tbody tr:nth-child(even) {
            background: var(--gris-claro);
            border-left-color: var(--celeste);
        }
        .tabla-admin-table tbody tr:nth-child(odd) {
            background: var(--blanco);
            border-left-color: var(--azul-oscuro);
        }
        .tabla-admin-table tbody tr:hover, .tabla-admin-table tbody tr:focus-within {
            background: var(--gris-hover);
            box-shadow: 0 2px 12px 0 rgba(0,159,227,0.13);
            border-left-color: var(--celeste);
            cursor: pointer;
        }
        .tabla-admin-table td {
            border-bottom: 1px solid var(--gris-borde);
            font-size: 0.98rem;
        }
        .tabla-admin-table td:last-child, .tabla-admin-table th:last-child {
            text-align: center;
        }
        .tabla-admin-table td .tabla-admin-btn-accion {
            background: none;
            border: none;
            color: var(--celeste);
            font-size: 1.1rem;
            cursor: pointer;
            transition: color 0.18s;
            padding: 0.2rem 0.4rem;
            border-radius: 0.3rem;
        }
        .tabla-admin-table td .tabla-admin-btn-accion:hover, 
        .tabla-admin-table td .tabla-admin-btn-accion:focus {
            color: var(--azul-oscuro);
            background: #e6f2fa;
        }
        .tabla-admin-table a.tabla-admin-link-doc {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            background: var(--celeste);
            color: var(--blanco);
            border-radius: 0.4rem;
            font-weight: 500;
            font-size: 0.97rem;
            text-decoration: none;
            transition: background 0.18s;
        }
        .tabla-admin-table a.tabla-admin-link-doc:hover, 
        .tabla-admin-table a.tabla-admin-link-doc:focus {
            background: var(--azul-oscuro);
        }
        .tabla-admin-table .tabla-admin-no-doc {
            color: #b0b7c3;
            font-style: italic;
        }
        /* Responsive: scroll horizontal en móviles */
        @media (max-width: 900px) {
            .tabla-admin-table-container {
                overflow-x: auto;
            }
            .tabla-admin-table {
                min-width: 700px;
            }
        }
        @media (max-width: 600px) {
            .tabla-admin-table th, .tabla-admin-table td {
                padding: 0.6rem 0.5rem;
                font-size: 0.93rem;
            }
            .tabla-admin-filtros {
                padding: 0.7rem 0.5rem;
            }
        }
        /* Paginación */
        .tabla-admin-paginacion {
            margin-top: 1.2rem;
            padding-left: 0.5rem;
        }
        /* Íconos */
        .tabla-admin-icon {
            vertical-align: middle;
            display: inline-block;
            font-size: 1.2rem;
        }
        /* Ajuste para nombres largos */
        .tabla-admin-table .truncate {
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
            vertical-align: bottom;
        }
    </style>

    <div class="tabla-admin-container">
        <h2 class="tabla-admin-titulo">Referencias por Departamento</h2>
        <form method="GET" action="{{ route('referencias.admin') }}" class="tabla-admin-filtros">
            <div class="tabla-admin-filtros-campos">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por texto..." />

                <select name="estado">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="completo" {{ request('estado') == 'completo' ? 'selected' : '' }}>Completado</option>
                </select>

                <select name="departamento">
                    <option value="">Todos los departamentos</option>
                    @foreach ($departamentos as $depto)
                        <option value="{{ $depto }}" {{ request('departamento') == $depto ? 'selected' : '' }}>
                            {{ nombreDepartamento($depto) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="tabla-admin-filtros-botones">
                <button type="submit" class="tabla-admin-btn tabla-admin-btn-filtrar">
                    Filtrar
                </button>
                <a href="{{ route('referencias.admin') }}" class="tabla-admin-btn tabla-admin-btn-limpiar">
                    Limpiar
                </a>
            </div>
        </form>

        <div class="tabla-admin-table-container">
            <table class="tabla-admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Correlativo</th>
                        <th>Departamento</th>
                        <th>Asunto</th>
                        <th>Solicitado por</th>
                        <th>Autorizado por</th>
                        <th>Generado por</th>
                        <th>Fecha de Generación</th>
                        <th>Última Modificación</th>
                        <th>Documento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($referencias as $i => $ref)
                        <tr tabindex="0">
                            <td><span class="truncate">{{ $i + 1 }}</span></td>
                            <td>
                                <span class="truncate" title="{{ $ref->correlativo }}">
                                    {{ Str::limit($ref->correlativo, 50, '...') }}
                                </span>
                            </td>
                            <td>
                                <span class="truncate" title="{{ nombreDepartamento($ref->departamento) }}">
                                    {{ Str::limit(nombreDepartamento($ref->departamento), 50, '...') }}
                                </span>
                            </td>
                            <td>
                                <span class="truncate" title="{{ $ref->asunto }}">
                                    {{ Str::limit($ref->asunto ?? '---', 30, '...') }}
                                </span>
                            </td>
                            <td>
                                <span class="truncate" title="{{ $ref->solicitado_por }}">
                                    {{ Str::limit($ref->solicitado_por ?? '---', 50, '...') }}
                                </span>
                            </td>
                            <td>
                                <span class="truncate" title="{{ $ref->autorizado_por }}">
                                    {{ Str::limit($ref->autorizado_por ?? '---', 50, '...') }}
                                </span>
                            </td>
                            <td>
                                <span class="truncate" title="{{ $ref->user->name ?? 'N/D' }}">
                                    {{ Str::limit($ref->user->name ?? 'N/D', 50, '...') }}
                                </span>
                            </td>
                            <td>
                                {{ $ref->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                {{ $ref->updated_at->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                @if ($ref->documento)
                                    <a href="{{ asset('storage/' . $ref->documento) }}" class="tabla-admin-link-doc" target="_blank">Ver</a>
                                @else
                                    <span class="tabla-admin-no-doc">No adjunto</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; justify-content: center; gap: 0.4rem;">
                                    <a href="{{ route('referencias.show', $ref->id) }}" class="tabla-admin-btn-accion" title="Ver detalle">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="tabla-admin-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('referencias.bitacora', $ref->id) }}" class="tabla-admin-btn-accion" title="Ver historial" style="color: var(--dorado);">
                                        <i class="ph ph-clock-counter-clockwise tabla-admin-icon"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="tabla-admin-paginacion">
                {{ $referencias->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
@endsection
