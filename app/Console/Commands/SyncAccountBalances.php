<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Account;

class SyncAccountBalances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accounts:sync-balances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate fetching balances from providers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->info("Syncing account balances...");

        $accounts = Account::all();

        foreach ($accounts as $account) {
            $account->balance = rand(100, 80000); // Mocked balance
            $account->save();
            $this->line("Updated {$account->type} ({$account->identifier}): KES {$account->balance}");
        }

        $this->info("Balance sync complete.");
    }
}
