<x-app-layout>
    <x-slot name="navigation">
        @include('layouts.navigation')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($product->title) }}
        </h2>
    </x-slot>

    <x-slot name="content">
        <!-- Página de Produto -->
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Imagens do Produto -->
                <div x-data="{ mainImageSrc: '{{ $product->images[0] }}' }" class="w-full">
                    <img id="imagem_principal" :src="mainImageSrc" alt="{{ $product->title }}"
                        class="w-full object-cover rounded-lg shadow-md mb-4">
                    <div class="flex justify-between">
                        @foreach ($product->images as $image)
                            <img @click="mainImageSrc = '{{ $image }}'" src="{{ $image }}" alt="Miniatura"
                                class="w-1/5 px-4 cursor-pointer">
                        @endforeach
                    </div>
                </div>
                <!-- Detalhes do Produto -->
                <div class="w-full container mx-auto p-4 w-full">
                    <h2 class="text-3xl font-semibold mb-2">{{ $product->title }}</h2>
                    <p class="text-gray-700 mb-4"></p>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">Description:</h3>
                        <p>{{ $product->description }}</p>
                    </div>
                    <!-- UL -->
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">UL:</h3>
                        <ul class="list-disc list-inside">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>

                    <!-- Especificações -->
                    <div class="container mx-auto p-4 w-full">
                        <h3 class="text-lg font-semibold mb-2">Specifications:</h3>
                        <table class="min-w-full divide-x divide-y">
                            @foreach ($product->specifications as $key => $value)
                                <tr>
                                        @if (is_array($value) || is_object($value))
                                            <td class="bg-gray-200 font-bold" colspan="2">{{ $key }}</td>
                                                </tr>
                                                <!-- Sub-keys and sub-values -->
                                                @foreach ($value as $subKey => $subValue)
                                                    <tr>
                                                        <td class="pl-4 text-bold">{{ $subKey }}</td>
                                                        <td>{{ $subValue }}</td>
                                                    </tr>
                                                @endforeach
                                        @else
                                        <td class="font-bold bg-gray-100 text-bold">{{ $key }}:</td>
                                                    <td>
                                            {{ $value }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    <!-- Preço -->
                    <div class="mb-4">
                        <span class="text-2xl font-semibold text-gray-800">R$ {{ $product->price }}</span>
                    </div>
                    <input name="units" type="number"
                        class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                        value="1" />
                    <!-- Botão Adicionar ao Carrinho -->
                    <div>
                        <x-cart-button class="px-4 py-2 rounded-md focus:outline-none"
                            @auth
href="{!! route('cart.append', ['product_id' => $product->id, 'user_id' => $user_id]) !!}"
                                            @else
                                                href="{{ route('cart.append', ['product_id' => $product->id]) }}" @endauth>>
                            Adicionar
                            ao Carrinho
                        </x-cart-button>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
