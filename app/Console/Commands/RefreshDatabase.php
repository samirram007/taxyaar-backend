<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RefreshDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:refresh-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback, migrate fresh, and seed the database in one go.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Rolling back migrations...');
        $this->call('migrate:rollback', ['--force' => true]);

        $this->info('🧹 Running migrate:fresh with seed...');
        $this->call('migrate:fresh', ['--seed' => true, '--force' => true]);

        $this->info('✅ Database refresh complete!');
    }
}
