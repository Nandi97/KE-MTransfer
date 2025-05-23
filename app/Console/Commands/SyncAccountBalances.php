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
    protected $signature = 'accounts:sync-balances {--type= : Only sync a specific account type (mpesa, airtel, bank)}';

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
        $type = $this->option('type');

        $this->info("Syncing account balances" . ($type ? " for type: $type" : ''));

        $query = Account::query();

        if ($type) {
            $query->where('type', $type);
        }

        $accounts = $query->get();

        foreach ($accounts as $account) {
            $account->balance = rand(100, 80000); // Simulated value
            $account->save();

            $this->line("Updated {$account->type} ({$account->identifier}): KES {$account->balance}");
        }

        $this->info("Balance sync complete.");
    }
}
