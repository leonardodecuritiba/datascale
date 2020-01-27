<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExportDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	protected $signature = 'export:db';

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
	    $host = env('DB_HOST');
	    $username = env('DB_USERNAME');
	    $password = env('DB_PASSWORD');
	    $database = env('DB_DATABASE');

	    $filename = public_path() . DIRECTORY_SEPARATOR . 'dump.sql';
	    $command = sprintf('mysqldump -h %s -u %s -p\'%s\' %s > %s', $host, $username, $password, $database, $filename);
	    exec($command);


	    $path    = public_path( 'uploads' );
	    $command = 'zip -r ' . $path . '.zip ' . $path . ' ' . $filename;
	    exec( $command );

    }
}
