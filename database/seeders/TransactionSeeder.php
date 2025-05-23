<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::all();

        for ($i = 0; $i < 20; $i++) {
            $sender = $users->random();
            $receiver = $users->where('id', '!=', $sender->id)->random();

            Transaction::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'amount' => rand(100, 1000),
                'status' => 'completed',
                'reference' => Str::uuid(),
            ]);
        }
    }
}
