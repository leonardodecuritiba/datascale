<?php

namespace App\Console\Commands;

use App\Models\HumanResources\Settings\Region;
use App\Models\Parts\Price;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportPricesTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:prices';

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
		Price::flushEventListeners();
		Price::getEventDispatcher();

		$entity = "tabela_precos";

		$this->info( '* Import TABELA PREÇOS' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
//	    $file =  'storage' . DIRECTORY_SEPARATOR . 'imports' . DIRECTORY_SEPARATOR . $filename;
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);

		set_time_limit(3600);

		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$id = DB::table('prices')->insertGetId([
					'created_at'    => $row->created_at,
					'idtabela_preco'=> $row->idtabela_preco,
					'name'          => $row->description,
					'description'   => $row->description,
				]);
				$DATA = Price::find($id);

				$this->info( "****************** (" . $DATA->id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
