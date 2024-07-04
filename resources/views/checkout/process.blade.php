<x-app-layout>
    <x-slot name="navigation">
        @include('layouts.navigation')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shipping Address') }}
        </h2>
    </x-slot>

    <x-slot name="content">
        <div class="container mx-auto p-4 w-50">
            @foreach ($shippings as $shipping)
                <div class="w-full flex-items mt-4 items-center">
                    <x-secondary-button href="{{ route('checkout.shipaddr.confirmated', ['id' => $shipping->id]) }}">
                        <label class="block-flex items-center">
                            <p class="ml-2">{{ $shipping->receiver }}</p>
                            <p class="ml-2">{{ $shipping->address }}</p>
                            <p class="ml-2">{{ $shipping->complement }}</p>
                        </label>
                    </x-secondary-button>
                </div>
            @endforeach

            <a href="{{ route('checkout.shipaddr.create', ['user_id' => session()->get('id')]) }}">
                <x-primary-button>
                    Add new shipping address
                </x-primary-button>
            </a>
        </div>
    </x-slot>
</x-app-layout>
