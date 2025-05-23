<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransferController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'receiver' => 'required', // email or phone
            'amount' => 'required|numeric|min:1'
        ]);

        $sender = Auth::user();
        $receiver = User::where('email', $data['receiver'])
            ->orWhere('phone', $data['receiver'])->first();

        if (!$receiver || $receiver->id == $sender->id) {
            return response()->json(['error' => 'Invalid recipient'], 404);
        }

        $senderWallet = $sender->wallet;
        if ($senderWallet->balance < $data['amount']) {
            return response()->json(['error' => 'Insufficient balance'], 400);
        }

        $receiverWallet = $receiver->wallet;

        // Transfer
        $senderWallet->decrement('balance', $data['amount']);
        $receiverWallet->increment('balance', $data['amount']);

        // Record Transaction
        $tx = Transaction::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'amount' => $data['amount'],
            'status' => 'completed',
            'reference' => Str::uuid(),
        ]);

        return response()->json(['message' => 'Transfer successful', 'transaction' => $tx]);
    }

    public function history()
    {
        $user = Auth::user();
        $transactions = Transaction::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->latest()
            ->get();
        return response()->json($transactions);
    }
}
