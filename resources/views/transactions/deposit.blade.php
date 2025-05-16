<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Depósito</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto bg-white p-6 shadow rounded">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form x-data="{ loading: false }" x-on:submit="loading = true" action="{{ route('deposit.perform') }}"
                method="POST">
                @csrf
                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700">Valor a depositar</label>
                    <input type="number" step="0.01" name="amount" id="amount" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded flex items-center justify-center w-full"
                    :disabled="loading">
                    <svg x-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    <span x-show="!loading">Confirmar Depósito</span>
                    <span x-show="loading">Processando...</span>
                </button>
            </form>
        </div>
    </div>
</x-app-layout>