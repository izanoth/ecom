<x-app-layout>
    <x-slot name="navigation">
        @include('layouts.navigation')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>

    <x-slot name="content">
        @if (!(count($cart_products) > 0))
            <div class="flex flex-col justidy-center justify-items-center items-center">
            <p>Não há produtos no carrinho.</p>
            <x-secondary-button href="{{ route('home') }}">Ir às compras</x-secondary-button>
            </div>
        @else
            <div class="container mx-auto overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                                Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                                Units
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">
                                Price
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($cart_products as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form method='post' action='{{ route('cart.remove', ['id' => $product->id]) }}'>
                                        @csrf
                                        @method('DELETE')
                                        <button class='btn btn-danger' type='submit'><i style="font-color:red"
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>

                                @vite(['resources/js/axios.js'])
                                <td class="px-6 py-4 whitespace-nowrap">{{ $product->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input class="mt-1 block text-right text-lg bg-transparent focus:outline-none cart_update border-inherit"
                                        type="number" name="update" data-id="{{ $product->id }}"
                                        value="{{ $product->units }}" />
                                </td>
                                <td data-id="{{ $product->id }}" class="px-6 py-4 whitespace-nowrap subtotal">
                                    {{ $product->price * $product->units }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <x-secondary-button href="{{ route('home') }}" class="d-block bg-sky-100">
                    Keep Shopping
                </x-secondary-button>
                <x-primary-a href="{{ route('checkout') }}">
                    Complete Purchase
                </x-primary-a>
            </div>
        @endif
    </x-slot>
</x-app-layout>
