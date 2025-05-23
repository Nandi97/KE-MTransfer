<?php

namespace App\Http\Controllers;

use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
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
    public function getBalance(MpesaService $mpesa)
    {
        $response = $mpesa->getAccountBalance();
        return response()->json($response);
    }

    public function balanceResult(Request $request)
    {
        Log::info('M-Pesa Balance Result:', $request->all());
        return response()->json(['message' => 'Received']);
    }

    public function balanceTimeout(Request $request)
    {
        Log::warning('M-Pesa Balance Timeout:', $request->all());
        return response()->json(['message' => 'Timeout handled']);
    }
}
