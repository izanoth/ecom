<section>
    <header>
        <h2 class="text-lg font-small text-gray-900 dark:text-gray-100">
            {{ __('Your Shipping Addresses') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure abbout your addresses or edit it.') }}
        </p>
    </header>
    @foreach ($shippings as $shipping)
        <div class="w-full flex-items mt-4 items-center relative cursor-pointer">
            <x-secondary-button class="w-full" href="{{ route('checkout.shipaddr.store', ['id' => $shipping->id, 'edit' => true]) }}">
                <div class="flex flex-col justify-center items-center">
                    <p class="ml-2">{{ $shipping->receiver }}</p>
                    <p class="ml-2">{{ $shipping->address }}</p>
                    <p class="ml-2">{{ $shipping->complement }}</p>
                </div>
            </x-secondary-button>

            <style>
                .fas {
                    transition: color 1s;

                }
                .fas:hover {
                    color: rgb(0,0,0);
                }
            </style>

            <a class="fas fa-edit absolute bottom-2 right-9 text-gray-300 cursor-pointer text-2xl"
                href="{{ route('checkout.shipaddr.store', ['id' => $shipping->id]) }}"></a>
            <a class="fas fa-trash absolute bottom-2 right-2 text-red-300 cursor-pointer text-2xl"
                href="{{ route('checkout.shipaddr.delete', ['id' => $shipping->id]) }}"> </a>
        </div>
    @endforeach
</section>
