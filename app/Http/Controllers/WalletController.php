<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function deposit(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:0.01']);

        $user = auth()->user();
        $wallet = $user->wallet;
        $wallet->balance += $request->amount;
        $wallet->save();

        // Log da transação
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'deposit',
            'amount' => $request->amount,
        ]);

        return redirect()->route('wallet.index')->with('success', 'Depósito realizado com sucesso!');
    }
    public function transfer(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $sender = auth()->user();
        $receiver = User::where('email', $request->email)->first();

        if ($sender->id === $receiver->id) {
            return back()->withErrors(['email' => 'Você não pode transferir para si mesmo.']);
        }

        $amount = $request->amount;

        if ($sender->wallet->balance < $amount) {
            return back()->withErrors(['amount' => 'Saldo insuficiente.']);
        }

        DB::transaction(function () use ($sender, $receiver, $amount) {
            $sender->wallet->decrement('balance', $amount);
            $receiver->wallet->increment('balance', $amount);

            Transaction::create([
                'user_id' => $sender->id,
                'type' => 'transfer',
                'amount' => $amount,
                'receiver_id' => $receiver->id,
            ]);
        });

        return redirect()->route('wallet.index')->with('success', 'Transferência realizada com sucesso!');
    }
}
