@extends('base')

@section('title', 'Charon - Remote Controller')

@push('scripts')
    @vite(['resources/assets/js/remote/app.ts'])
@endpush
