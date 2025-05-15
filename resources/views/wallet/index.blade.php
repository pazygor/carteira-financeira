<!-- resources/views/wallet/index.blade.php -->
<h2>Minha Carteira</h2>
<p>Saldo: R$ {{ number_format(auth()->user()->wallet->balance, 2, ',', '.') }}</p>

<h3>Depósito</h3>
<form method="POST" action="{{ route('wallet.deposit') }}">
    @csrf
    <input type="number" name="amount" step="0.01" required>
    <button type="submit">Depositar</button>
</form>

<h3>Transferência</h3>
<form method="POST" action="{{ route('wallet.transfer') }}">
    @csrf
    <input type="email" name="email" placeholder="Email do destinatário" required>
    <input type="number" name="amount" step="0.01" required>
    <button type="submit">Transferir</button>
</form>