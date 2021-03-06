<?php

namespace App\Console\Commands;

use App\Models\Inputs\Instruments\InstrumentBrand;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportInstrumentBrandsTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:instrument_brands';

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
		InstrumentBrand::flushEventListeners();
		InstrumentBrand::getEventDispatcher();

		$entity = "instrument_brands";

		$this->info( '* Import INSTRUMENT BRANDS' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
		set_time_limit(3600);
		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$DATA = InstrumentBrand::whereDescription($row->description)->first();
				if($DATA == NULL){
					$DATA = InstrumentBrand::create([
						'created_at'            => $row->created_at,
						'idinstrumento_marca'   => $row->idinstrumento_marca,
						'description'           => $row->description,
					]);
				} else {
					$this->command->alert('GRUPO EXISTENTE: ' . $DATA->description . ', idinstrumento_marca: ' . $DATA->idinstrumento_marca);
				}

				$this->info( "****************** (" . $DATA->id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
