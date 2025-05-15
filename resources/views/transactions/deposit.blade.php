<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Depósito</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto bg-white p-6 shadow rounded">
            <form action="{{ route('deposit.perform') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700">Valor a depositar</label>
                    <input type="number" step="0.01" name="amount" id="amount" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    Confirmar Depósito
                </button>
            </form>
        </div>
    </div>
</x-app-layout>