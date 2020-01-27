<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	protected $signature = 'import:tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
	    $this->call( 'db:seed', [ '--class' => 'DatabaseSeeder' ] );
	    $path    = storage_path( 'imports' );
	    $file    = DIRECTORY_SEPARATOR . 'exports';
	    $command = 'rm ' . $path . $file . ' -r';
	    exec( $command );

	    $command = 'unzip ' . $path . $file . '.zip -d ' . $path;
	    exec( $command );

        $this->call('import:brands');
        $this->call('import:groups');
        $this->call('import:regions');
        $this->call('import:segments');
        $this->call('import:ncms');
        $this->call('import:services');
        $this->call('import:providers');
        $this->call('import:parts');
        $this->call('import:prices');
        $this->call('import:service_prices');
        $this->call('import:part_prices');
        $this->call('import:clients');

        $this->call('import:equipments');
        $this->call('import:instrument_brands');
        $this->call('import:instrument_models');
        $this->call('import:instrument_setors');
        $this->call('import:pams');
        $this->call('import:instruments');

        $this->call('import:users');

        $this->call('import:payments');
        $this->call('import:billings');
        $this->call('import:orders');
        $this->call('import:apparatus');

        $this->call('import:seals');
        $this->call('import:labels');

        $this->call('import:seal_instruments');
        $this->call('import:label_instruments');

        $this->call('import:apparatu_services');
        $this->call('import:apparatu_parts');
        $this->call('import:requests');
        $this->call('import:portions');

        $this->call('export:db');

	    $this->call( 'db:seed', [ '--class' => 'FranchiseSeeder' ] );
//	    $command = 'rm ' . $path . $file . ' -r';
//	    exec( $command );
    }
}
