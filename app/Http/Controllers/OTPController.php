<?php

namespace App\Http\Controllers;

use App\Models\VerificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class OTPController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'identifier' => 'required|string', // phone or email
        ]);

        $code = rand(100000, 999999);

        VerificationCode::create([
            'user_id' => Auth::id(),
            'identifier' => $data['identifier'],
            'code' => $code,
            'expires_at' => now()->addMinutes(5),
        ]);

        // Simulate SMS/Email
        Log::info("OTP for {$data['identifier']}: {$code}");

        return response()->json(['message' => 'OTP sent']);
    }
    public function verify(Request $request)
    {
        $data = $request->validate([
            'identifier' => 'required|string',
            'code' => 'required|string'
        ]);

        $otp = VerificationCode::where('identifier', $data['identifier'])
            ->where('code', $data['code'])
            ->where('verified', false)
            ->where('expires_at', '>', now())
            ->first();

        if (! $otp) {
            return response()->json(['error' => 'Invalid or expired OTP'], 400);
        }

        $otp->update(['verified' => true]);

        return response()->json(['message' => 'OTP verified']);
    }
}
