<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Carbon\Carbon;

class ImportTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Transactions CSV into database.';

    /**
     * Location of transactions csv files.
     * 
     * @var string
     */
    private $path = '/storage/app/data/transactions/transactions.csv';

    /**
     * Location of archile transactions csv after it is imported.
     *
     * @TODO: Archive imported transactions csv file.
     * 
     * @var string
     */
    private $archive = '/storage/app/data/transactions/archive';

    /**
     * Store imported transaction record.
     *
     * @var string
     */
    private $transactions = [];

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
        $this->import()->save();
    }

    /**
     * Import the csv row into the array.
     *
     * @return $this
     */
    private function import()
    {
        $csv = Reader::createFromPath(base_path() . $this->path, 'r')
                ->setHeaderOffset(0);        

        $records = (new Statement())->process($csv);  

        foreach ($records as $record) {
            if (empty($record)) {
                continue; 
            }

            $transaction['store_id'] = $record['STORE ID'];
            $transaction['transaction_id'] = $record['TRANSACTION ID'];
            $transaction['total_amount'] = $record['TOTAL AMOUNT'];
            $transaction['currency'] = $record['CURRENCY'];
            $transaction['created_at'] = Carbon::parse($record['CREATED AT']);

            array_push($this->transactions, $transaction);
        }

        return $this;
    }

    /**
     * Persist csv record into transactions table.
     *
     * @return $this
     */
    private function save()
    {        
        if (empty($this->transactions)) {
            return false;
        }

        foreach ($this->transactions as $transaction) {
            try{
                \App\Transaction::insert($transaction);
            } catch(\Exception $e) {
                \Log::warning('Error: Inserting Record. Skip the record. Error Message : ' . $e->getMessage());                
                continue;
            }
        }

        return $this;
    }
}
