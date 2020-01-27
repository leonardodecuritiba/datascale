<?php

use Illuminate\Database\Seeder;

class ImportSettingTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    //php artisan db:seed --class=ImportSettingTable
	    $start = microtime( true );
	    $this->command->info( 'Import Settings' );
	    ini_set('memory_limit', '-1');
	    $file = storage_path('imports/settings.sql') ;
	    exec("mysql -u ".env('DB_USERNAME')." -p".env('DB_PASSWORD')." ".env('DB_DATABASE')." < " . $file);
	    $this->command->info( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
    }
}
