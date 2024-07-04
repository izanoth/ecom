<x-app-layout>
    <x-slot name="navigation">
        <!--Layouts.NAVIGATION-->
        @include('layouts.navigation')
    </x-slot>

    <x-slot name="content">
        <!-- Page Content -->
        <x-product-display>
            @if (!$products->isEmpty())
                @foreach ($products as $product)
                    <div class="w-64 m-4 p-4 border rounded-lg flex flex-col justify-center items-center">
                        <img src="{{ asset($product->images[0]) }}" alt="Imagem do Produto" class="w-full h-auto">
                        <a href="{{ route('product', ['id' => $product->id]) }}"
                            class="text-lg font-semibold mt-2">{{ __($product->title) }}</a>
                        <div class="">
                            <form method="GET" action="{{ route('cart.append') }}">
                                <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                <span>Unidades: </span><input name="units" type="number"
                                    class="w-20 mt-2 px-4 py-2 border border-inherit rounded-lg focus:outline-none focus:border-blue-500"
                                    value="1" />
                                <x-cart-button>
                                    Add to cart
                                </x-cart-button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="w-full h-full flex justify-center items-center">
                    <p>Product not found.</p>
                </div>
            @endif
        </x-product-display>
    </x-slot>
</x-app-layout>
