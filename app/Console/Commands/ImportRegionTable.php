<?php

namespace App\Console\Commands;

use App\Models\HumanResources\Settings\Region;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportRegionTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:regions';

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
		Region::flushEventListeners();
		Region::getEventDispatcher();

		$entity = "regioes";

		$this->info( '* Import REGIÕES' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
//	    $file =  'storage' . DIRECTORY_SEPARATOR . 'imports' . DIRECTORY_SEPARATOR . $filename;
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);

		set_time_limit(3600);

		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$DATA = Region::whereDescription($row->description)->first();
				if($DATA == NULL){
					$id = DB::table('regions')->insertGetId([
						'created_at'            => $row->created_at,
						'idregiao'      => $row->idregiao,
						'description'   => $row->description,
					]);
					$DATA = Region::find($id);
				} else {
					$this->alert('REGIÃO EXISTENTE: ' . $DATA->description . ', idmarca: ' . $DATA->id);
				}

				$this->info( "****************** (" . $DATA->id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
