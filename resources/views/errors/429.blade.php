@php
    $code = '429';
    $title = 'Demasiadas solicitudes';
    $message = 'Has realizado demasiadas solicitudes en poco tiempo. Espera un momento e intenta nuevamente.';
@endphp
@include('errors.template')
