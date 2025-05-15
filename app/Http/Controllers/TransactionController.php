<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\TransactionLog;
use Illuminate\Support\Facades\DB;
use App\Models\Wallet;
class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Mostra transações onde ele é o remetente ou destinatário
        $transactions = Transaction::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('transactions.index', compact('transactions'));
    }
    public function showDepositForm()
    {
        return view('transactions.deposit');
    }

    public function performDeposit(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
        ]);

        $user = Auth::user();
        $wallet = $user->wallet;

        DB::transaction(function () use ($user, $wallet, $request) {
            $wallet->balance += $request->amount;
            $wallet->save();

            $transaction = Transaction::create([
                'sender_id' => null, // depósito não tem remetente
                'receiver_id' => $user->id,
                'type' => 'deposit',
                'amount' => $request->amount,
            ]);

            TransactionLog::create([
                'transaction_id' => $transaction->id,
                'log' => "Depósito de R$ {$request->amount} realizado pelo usuário ID {$user->id}.",
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Depósito realizado com sucesso!');
    }

    public function showTransferForm()
    {
        return view('transactions.transfer');
    }

    public function performTransfer(Request $request)
    {
        $request->validate([
            'recipient' => ['required', 'email', 'exists:users,email'],
            'amount' => ['required', 'numeric', 'min:0.01'],
        ]);

        $sender = Auth::user();
        $recipient = \App\Models\User::where('email', $request->recipient)->first();

        if ($sender->id === $recipient->id) {
            return back()->withErrors(['recipient' => 'Você não pode transferir para si mesmo.']);
        }

        $senderWallet = $sender->wallet;
        $recipientWallet = $recipient->wallet;

        if ($senderWallet->balance < $request->amount) {
            return back()->withErrors(['amount' => 'Saldo insuficiente para realizar a transferência.']);
        }

        DB::transaction(function () use ($sender, $recipient, $senderWallet, $recipientWallet, $request) {
            // Atualiza saldos
            $senderWallet->balance -= $request->amount;
            $senderWallet->save();

            $recipientWallet->balance += $request->amount;
            $recipientWallet->save();

            // Registra transação principal
            $transaction = Transaction::create([
                'sender_id' => $sender->id,
                'receiver_id' => $recipient->id,
                'type' => 'transfer',
                'amount' => $request->amount,
            ]);

            // Log da transação
            TransactionLog::create([
                'transaction_id' => $transaction->id,
                'log' => "Transferência de R$ {$request->amount} realizado pelo usuário ID {$sender->id}.",
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Transferência realizada com sucesso!');
    }
    public function reverse($id)
    {
        // Usa transação do banco para garantir atomicidade
        DB::beginTransaction();

        try {
            $transaction = Transaction::findOrFail($id);

            // Impede reverter duas vezes
            if ($transaction->reversed) {
                return redirect()->back()->with('error', 'Essa transação já foi revertida.');
            }

            // Busca as wallets envolvidas
            $senderWallet = Wallet::where('user_id', $transaction->sender_id)->first();
            $receiverWallet = Wallet::where('user_id', $transaction->receiver_id)->first();

            // Verifica se ambas as carteiras existem
            if (!$receiverWallet || ($transaction->type === 'transfer' && !$senderWallet)) {
                return redirect()->back()->with('error', 'Carteiras não encontradas.');
            }

            // Reversão da transação
            if ($transaction->type === 'deposit') {
                // Estorna o valor do destinatário
                $receiverWallet->balance -= $transaction->amount;
                $receiverWallet->save();
            } elseif ($transaction->type === 'transfer') {
                // Estorna o valor do destinatário e devolve ao remetente
                $receiverWallet->balance -= $transaction->amount;
                $receiverWallet->save();

                $senderWallet->balance += $transaction->amount;
                $senderWallet->save();
            }

            // Marca a transação como revertida
            $transaction->reversed = true;
            $transaction->save();

            DB::commit();

            return redirect()->back()->with('success', 'Transação revertida com sucesso.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao reverter transação: ' . $e->getMessage());
        }
    }
}
