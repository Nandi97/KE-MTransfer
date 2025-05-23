<?php


## ✅ 1. Create Interface: `PaymentServiceInterface.php`


namespace App\Services\Contracts;

interface PaymentServiceInterface
{
    public function getBalance(string $identifier): float;
    public function transferFunds(string $from, string $to, float $amount): bool;
}
