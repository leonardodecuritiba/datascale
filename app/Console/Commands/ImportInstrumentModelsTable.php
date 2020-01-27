<?php

namespace App\Console\Commands;

use App\Models\Inputs\Instruments\InstrumentBrand;
use App\Models\Inputs\Instruments\InstrumentModel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportInstrumentModelsTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:instrument_models';

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
		InstrumentModel::flushEventListeners();
		InstrumentModel::getEventDispatcher();

		$entity = "instrument_models";

		$this->info( '* Import INSTRUMENT MODELS' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
		set_time_limit(3600);
		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$DATA = InstrumentModel::whereDescription($row->description)->first();
				//idinstrumento_modelo	idinstrumento_marca
				if($DATA == NULL){
					$s = InstrumentBrand::where('idinstrumento_marca', $row->idinstrumento_marca)->first();
					if($s == NULL) dd('error');
					$DATA = InstrumentModel::create([
						'created_at'            => $row->created_at,
						'idinstrumento_modelo'  => $row->idinstrumento_modelo,
						'instrument_brand_id'   => $s->id,
						'description'           => $row->description,
					]);
				} else {
					$this->command->alert('INSTRUMENT MODELS EXISTENTE: ' . $DATA->description . ', idinstrumento_modelo: ' . $DATA->idinstrumento_modelo);
				}

				$this->info( "****************** (" . $DATA->id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
