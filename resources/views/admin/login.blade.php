@extends('admin.layouts.app')

@section('content')
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="w-full bg-gray-200">
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="d-flex flex-column justify-content-center align-items-center">
                <!-- Email Address -->
                <div class="align-self-center form-group">
                    <x-input-label for="name" :value="__('Name')" />
                    <input id="name" class="block form-control" name="name" :value="old('name')" required autofocus
                        autocomplete="username" />
                </div>

                <!-- Password -->
                <div class="align-self-center form-group">
                    <x-input-label for="password" :value="__('Password')" />

                    <input id="password" class="form-control" type="password" name="password" required
                        autocomplete="current-password" />
                </div>

                <!--button-->
                <div>
                    <button type="submit" class="btn btn-primary w-full justify-content-center">
                        {{ __('Log in') }}
                    </button>
                </div>
                @if (isset($error))
                    <div class="bg-warning">
                        {{ $error }}
                    </div>
                @endif

            </div>
        </form>
    </div>
@endsection
