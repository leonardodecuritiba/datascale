<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	protected $signature = 'import:db';

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

	    $command = sprintf('mysql -h %s -u %s -p\'%s\' DROP DATABASE %s', $host, $username, $password, $database);
	    exec($command);
	    $command = sprintf('mysql -h %s -u %s -p\'%s\' CREATE DATABASE %s', $host, $username, $password, $database);
	    exec($command);

	    DB::unprepared(file_get_contents('public/dump.sql'));
    }
}
