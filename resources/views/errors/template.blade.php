@extends('errors.layout')

@section('code', $code ?? 'Error')
@section('title', $title ?? 'Ha ocurrido un problema')
@section('message')
    {!! $message ?? 'Ocurrió un error inesperado. Por favor, intenta nuevamente.' !!}
@endsection

@section('actions')
    @include('errors._actions')
@endsection
