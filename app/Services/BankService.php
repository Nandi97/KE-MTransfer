<?php

namespace App\Services;

use App\Services\Contracts\PaymentServiceInterface;

class BankService implements PaymentServiceInterface
{
    public function getBalance(string $identifier): float
    {
        return rand(5000, 50000);
    }

    public function transferFunds(string $from, string $to, float $amount): bool
    {
        return rand(0, 1) === 1;
    }
}
