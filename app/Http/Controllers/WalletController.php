<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function balance()
    {
        $wallet = Auth::user()->wallet;
        return response()->json(['balance' => $wallet->balance]);
    }

    public function fund(Request $request)
    {
        $amount = $request->validate([
            'amount' => 'required|numeric|min:1'
        ])['amount'];

        $wallet = Auth::user()->wallet;
        $wallet->balance += $amount;
        $wallet->save();

        return response()->json(['message' => 'Wallet funded.', 'balance' => $wallet->balance]);
    }

    public function withdraw(Request $request)
    {
        $amount = $request->validate([
            'amount' => 'required|numeric|min:1'
        ])['amount'];

        $wallet = Auth::user()->wallet;
        if ($wallet->balance < $amount) {
            return response()->json(['error' => 'Insufficient balance'], 400);
        }

        $wallet->balance -= $amount;
        $wallet->save();

        return response()->json(['message' => 'Withdrawn successfully.', 'balance' => $wallet->balance]);
    }
}
