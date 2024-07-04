@extends('admin.layouts.app')

@section('content')
    @if (isset($message))
        {{ $message }}
    @endif
    <form method="POST" action="{{ route('admin.store') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- hash -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Hash')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Create') }}
            </x-primary-button>
        </div>
        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('admin.index') }}"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
        </div>
    </form>
@endsection
