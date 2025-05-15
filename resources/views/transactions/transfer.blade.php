<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transferência</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto bg-white p-6 shadow rounded">
            @if (session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('transfer.perform') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="recipient" class="block text-sm font-medium text-gray-700">
                        Email do destinatário
                    </label>
                    <input type="email" name="recipient" id="recipient" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700">
                        Valor a transferir
                    </label>
                    <input type="number" step="0.01" name="amount" id="amount" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Confirmar Transferência
                </button>
            </form>
        </div>
    </div>
</x-app-layout>