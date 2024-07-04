<!-- resources/views/emails/welcome.blade.php -->

@extends('layouts.email')

@section('title', 'Bem-vindo')

@section('content')
    <div class="bg-sky-500 p-4">
        <div class="flex justify-between items-center">
            <div class="text-white text-xl font-bold">Bem-vindo!</div>
            <img src="https://via.placeholder.com/50" alt="Logo" class="h-12 w-12 rounded-full">
        </div>
    </div>
    <div class="p-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Olá, {{ $user->name }}</h1>
        <p class="text-gray-700">Bem-vindo ao nosso site! Estamos felizes em tê-lo conosco.</p>
    </div>
    <div class="bg-gray-200 p-4 text-center">
        <p class="text-gray-600">Se você tiver alguma dúvida, não hesite em nos contatar.</p>
        <p class="text-gray-600">© {{ date('Y') }} Sua Empresa. Todos os direitos reservados.</p>
    </div>
@endsection
