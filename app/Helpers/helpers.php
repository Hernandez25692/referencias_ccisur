<?php

if (!function_exists('nombreDepartamento')) {
    function nombreDepartamento(string $sigla): string
    {
        return match ($sigla) {
            'DE' => 'Dirección Ejecutiva',
            'GOR' => 'Gerencia de Operaciones Registrales',
            'GAF' => 'Gerencia Administrativa y Financiera',
            'GSEA' => 'Gerencia de Servicios Empresariales y Afiliaciones',
            default => $sigla,
        };
    }
}
