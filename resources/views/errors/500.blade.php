@php
    $code = '500';
    $title = 'Error interno del servidor';
    $message =
        'Se produjo un error inesperado en el servidor. Nuestro equipo fue notificado. Intenta nuevamente en unos minutos.';
@endphp
@include('errors.template')
