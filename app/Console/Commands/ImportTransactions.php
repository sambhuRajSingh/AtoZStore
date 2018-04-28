<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Transactions CSV into database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
