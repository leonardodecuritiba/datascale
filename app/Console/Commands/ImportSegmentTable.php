<?php

namespace App\Console\Commands;

use App\Models\HumanResources\Settings\Segment;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportSegmentTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:segments';

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
		Segment::flushEventListeners();
		Segment::getEventDispatcher();

		$entity = "segments";

		$this->info( '* Import SEGMENTOS' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
//	    $file =  'storage' . DIRECTORY_SEPARATOR . 'imports' . DIRECTORY_SEPARATOR . $filename;
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);

		set_time_limit(3600);

		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$DATA = Segment::whereDescription($row->description)->first();
				if($DATA == NULL){

					$id = DB::table('segments')->insertGetId([
						'created_at'    => $row->created_at,
						'idsegmento'    => $row->idsegmento,
						'description'   => $row->description,

					]);

				} else {
					$this->alert('SEGMENTO EXISTENTE: ' . $DATA->description . ', idsegmento: ' . $DATA->id);
					$id = $DATA->id;
				}

				$this->info( "****************** (" . $id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
