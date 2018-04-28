<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

class ImportStores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Sales CSV into database.';

    /**
     * Location of stores csv files.
     * 
     * @var string
     */
    private $path = '/storage/app/data/stores/stores.csv';

    /**
     * Location of archile stores csv after it is imported.
     *
     * @TODO: Archive imported store csv file.
     * 
     * @var string
     */
    private $archive = '/storage/app/data/stores/archive';

    /**
     * Store imported sales record.
     *
     * @var string
     */
    private $salesRecords = [];

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

            $salesRecord['store_id'] = $record['STORE ID'];
            $salesRecord['name'] = $record['NAME'];
            $salesRecord['address'] = $record['ADDRESS'];
            $salesRecord['postcode'] = $record['POSTCODE'];

            array_push($this->salesRecords, $salesRecord);
        }

        return $this;
    }

    /**
     * Persist csv record into sales table.
     *
     * @return $this
     */
    private function save()
    {
        if (empty($this->salesRecords)) {
            return false;
        }

        foreach ($this->salesRecords as $record) {
            try{
                \App\Store::insert($record);
            } catch(\Exception $e) {
                \Log::warning('Error: Inserting Record. Skip the record. Error Message : ' . $e->getMessage());
                continue;
            }
        }

        return $this;
    }
}
