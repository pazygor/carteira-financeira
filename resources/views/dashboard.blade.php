<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Bem-vindo, {{ $user->name }}</h3>

                <p class="mb-4">💰 <strong>Saldo atual:</strong> R$ {{ number_format($balance, 2, ',', '.') }}</p>

                <div class="flex gap-4">
                    <a href="{{ route('deposit.form') }}"
                        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Depositar</a>
                    <a href="{{ route('transfer.form') }}"
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Transferir</a>
                    <a href="{{ route('transactions.index') }}"
                        class="px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600 transition-colors duration-200">
                        Histórico de Transações
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>