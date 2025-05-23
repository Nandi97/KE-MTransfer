<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VerificationCode;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        {
            $accounts = Auth::user()
                ->accounts()
                ->get();
            return response()->json($accounts);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        {
            $data = $request->validate([
                'type' => 'required|in:mpesa,airtel,bank',
                'identifier' => 'required|string|unique:accounts,identifier',
                'provider_name' => 'nullable|string',
                'is_primary' => 'nullable|boolean'
            ]);

            // Ensure OTP was verified
            $otp = VerificationCode::where('identifier', $data['identifier'])
                ->where('user_id', Auth::id())
                ->where('verified', true)
                ->where('expires_at', '>', now())
                ->latest()
                ->first();

            if (! $otp) {
                return response()->json(['error' => 'OTP verification required.'], 403);
            }

            // Link account
            $account = Auth::user()->accounts()->create($data);

            return response()->json([
                'message' => 'Account linked successfully',
                'account' => $account
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $account = Auth::user()->accounts()->findOrFail($id);

        $data = $request->validate([
            'provider_name' => 'nullable|string',
            'is_primary' => 'nullable|boolean',
        ]);

        if (isset($data['is_primary']) && $data['is_primary'] === true) {
            // Unset all other primaries
            Auth::user()->accounts()->where('id', '!=', $account->id)->update(['is_primary' => false]);
        }

        $account->update($data);

        return response()->json([
            'message' => 'Account updated successfully.',
            'account' => $account
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $account = Auth::user()->accounts()->findOrFail($id);
        $account->delete();

        return response()->json(['message' => 'Account removed.']);
    }

    public function refresh($id)
    {
        $account = Auth::user()->accounts()->findOrFail($id);

        // Simulate new balance
        $account->balance = rand(100, 50000);
        $account->save();

        return response()->json([
            'message' => 'Balance refreshed',
            'balance' => $account->balance
        ]);
    }

    public function primary()
    {
        $account = Auth::user()->primaryAccount()->first();

        return $account
            ? response()->json($account)
            : response()->json(['message' => 'No primary account set'], 404);
    }
}
