<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MpesaService
{
    public function getAccessToken(): string
    {
        return Cache::remember('mpesa_token', 3500, function () {
            $response = Http::withOptions([
                'verify' => false // ⛔ disable SSL check (safe for dev only)
            ])->withBasicAuth(
                config('mpesa.consumer_key'),
                config('mpesa.consumer_secret')
            )->get(config('mpesa.base_url') . '/oauth/v1/generate?grant_type=client_credentials');

            return $response->json()['access_token'] ?? '';
        });
    }

    public function getAccountBalance()
    {
        $token = $this->getAccessToken();

        $payload = [
            "Initiator" => config('mpesa.initiator_name'),
            "SecurityCredential" => config('mpesa.initiator_password'),
            "CommandID" => "AccountBalance",
            "PartyA" => config('mpesa.shortcode'),
            "IdentifierType" => "4",
            "Remarks" => "Check balance",
            "QueueTimeOutURL" => config('mpesa.timeout_url'),
            "ResultURL" => config('mpesa.result_url')
        ];

        $response = Http::withOptions([
            'verify' => false // ⛔ disable SSL check here too
        ])->withToken($token)
            ->post(config('mpesa.base_url') . '/mpesa/accountbalance/v1/query', $payload);

        return $response->json();
    }
}
