<x-app-layout>
    <x-slot name="navigation">
        @include('layouts.navigation')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <x-slot name="content">
        <div class="container mx-auto p-4 w-full">

            @if ($products->isEmpty())
                <p>Your cart is empty.</p>
            @else
                <form action="" method="GET">
                    @csrf
                    <div class="overflow-x-auto">

                        <!-- Order Summary -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h2 class="text-2xl font-bold mb-4">Order Summary</h2>
            <div class="flex justify-between mb-2">
                <span>Subtotal:</span>
                <span>$100.00</span>
            </div>
            <div class="flex justify-between mb-2">
                <span>Shipping:</span>
                <span>$5.00</span>
            </div>
            <div class="flex justify-between mb-2">
                <span>Tax:</span>
                <span>$10.00</span>
            </div>
            <div class="flex justify-between font-bold text-lg">
                <span>Total:</span>
                <span>$115.00</span>
            </div>
        </div>

        <!-- Delivery Address -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h2 class="text-2xl font-bold mb-4">Delivery Address</h2>
            <div>
                <p>John Doe</p>
                <p>123 Main St, Apt 4B</p>
                <p>Springfield, IL 62701</p>
                <p>United States</p>
            </div>
        </div>


                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-sky-900 text-gray-100">
                                <tr>
                                    <th class="w-20 py-3 px-4 text-left"></th>
                                    <th class="py-3 px-4 text-left">Product</th>
                                    <th class="py-3 px-4 text-right">Price</th>
                                    <th class="py-3 px-4 text-right">Quantity</th>
                                    <th class="py-3 px-4 text-right"><b>Total</b></th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-100 text-gray-700 divide-y divide-gray-200">
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="w-20 py-3 px-4">
                                            <img src="{{ $product->images[0] }}" alt="{{ $product->title }}"
                                                class="w-16 h-16 object-cover">
                                        </td>
                                        <td class="py-3 px-4">
                                            {{ $product->title }}
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            ${{ number_format($product->price, 2) }}
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            {{ $product->units }}
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            $ {{ number_format($product->price * $product->units, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-200 text-gray-600">
                                <tr>
                                    <td colspan="4" class="py-3 px-4 text-right font-bold">Total</td>
                                    <td class="py-3 px-4 text-right font-bold">
                                        ${{ number_format($amount, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h2 class="text-2xl font-bold mb-4">Payment Information</h2>
                        <form>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Select Payment Method</label>
                                <div class="flex space-x-4 mt-2">
                                    <div class="flex items-center">
                                        <input id="credit_card" name="payment_method" type="radio"
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="credit_card" class="ml-3 block text-sm font-medium text-gray-700">
                                            <img src="https://via.placeholder.com/100x50?text=Credit+Card"
                                                alt="Credit Card">
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="paypal" name="payment_method" type="radio"
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="paypal" class="ml-3 block text-sm font-medium text-gray-700">
                                            <img src="https://via.placeholder.com/100x50?text=PayPal" alt="PayPal">
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="bank_transfer" name="payment_method" type="radio"
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="bank_transfer" class="ml-3 block text-sm font-medium text-gray-700">
                                            <img src="https://via.placeholder.com/100x50?text=Bank+Transfer"
                                                alt="Bank Transfer">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                class="bg-sky-500 text-white px-6 py-2 rounded-md hover:bg-sky-600">Complete
                                Purchase</button>
                        </form>
                    </div>
                    <x-secondary-button class="bg-sky-100">
                        list pay options here
                    </x-secondary-button>

                </form>
            @endif
        </div>
    </x-slot>
</x-app-layout>
