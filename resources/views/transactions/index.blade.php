<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Historico de Transações
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl font-bold mb-4">Histórico de Transações</h2>

        <table class="table-auto w-full bg-white shadow rounded">
            <thead>
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Tipo</th>
                    <th class="border px-4 py-2">Valor</th>
                    <th class="border px-4 py-2">Remetente</th>
                    <th class="border px-4 py-2">Destinatário</th>
                    <th class="border px-4 py-2">Data</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td class="border px-4 py-2">{{ $transaction->id }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($transaction->type) }}</td>
                        <td class="border px-4 py-2">R$ {{ number_format($transaction->amount, 2, ',', '.') }}</td>
                        <td class="border px-4 py-2">{{ $transaction->sender_id ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $transaction->receiver_id }}</td>
                        <td class="border px-4 py-2">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        <td class="border px-4 py-2">
                            @if ($transaction->reversed)
                                <span class="text-red-600 font-semibold">Revertida</span>
                            @else
                                <span class="text-green-600 font-semibold">Ativa</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2">
                            @if (!$transaction->reversed)
                                <form action="{{ route('transactions.reverse', $transaction->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
                                        onclick="return confirm('Deseja reverter esta transação?')">Reverter</button>
                                </form>
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>