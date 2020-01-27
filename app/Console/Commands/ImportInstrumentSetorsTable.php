<?php

namespace App\Console\Commands;

use App\Models\Inputs\Instruments\InstrumentSetor;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportInstrumentSetorsTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:instrument_setors';

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
		InstrumentSetor::flushEventListeners();
		InstrumentSetor::getEventDispatcher();

		$entity = "instrument_setors";

		$this->info( '* Import INSTRUMENT SETOR' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
		set_time_limit(3600);
		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$DATA = InstrumentSetor::whereDescription($row->description)->first();
				if($DATA == NULL){
					$id = DB::table('instrument_setors')->insertGetId([
						'created_at'            => $row->created_at,
						'idinstrumento_setor'   => $row->idinstrumento_setor,
						'description'           => $row->description,

					]);

				} else {
					$this->command->alert('INSTRUMENT SETOR EXISTENTE: ' . $DATA->description . ', idinstrumento_setor: ' . $DATA->idinstrumento_setor);
					$id = $DATA->id;
				}

				$this->info( "****************** (" . $id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
