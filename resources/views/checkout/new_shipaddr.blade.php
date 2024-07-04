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
            <form action="{{ route('checkout.shipaddr.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="receiver" class="block text-gray-700">Receiver Name</label>
                    <input type="text" id="receiver" name="receiver"
                        value="@error('receiver') {{ '' }} @else {{ old('receiver') }} @enderror"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                    <!--input type="checkbox" name="receiver"><span>It's myself</span-->
                </div>

                <script src="https://unpkg.com/imask@6.4.2/dist/imask.js"></script>
                @vite(['resources/js/imask.js'])
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700">Phone</label>
                    <input type="text" id="phone" name="phone"
                        value="@error('phone') {{ '' }} @else {{ old('phone') }} @enderror"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-gray-700">Address</label>
                    <input type="text" id="address" name="address"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                </div>
                <div class="mb-4">
                    <label for="complement" class="block text-gray-700">Complement</label>
                    <input type="text" id="complement" name="complement"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="mb-4">
                    <label for="city" class="block text-gray-700">City</label>
                    <input type="text" id="city" name="city"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                </div>
                <div class="mb-4">
                    <label for="district" class="block text-gray-700">District</label>
                    <input type="text" id="district" name="district"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                </div>
                <div class="mb-4">
                    <label for="zip" class="block text-gray-700">Zip Code</label>
                    <input type="text" id="zip" name="zip"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                </div>
                <x-primary-button name="create">
                    Confirm
                </x-primary-button>
            </form>
        </div>
    </x-slot>
</x-app-layout>
