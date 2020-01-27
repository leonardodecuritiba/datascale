<?php

namespace App\Console\Commands;

use App\Helpers\DataHelper;
use App\Models\Parts\Part;
use App\Models\Parts\PartPrice;
use App\Models\Parts\Price;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportPartPricesTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:part_prices';

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
		PartPrice::flushEventListeners();
		PartPrice::getEventDispatcher();

		$entity = "tabela_preco_pecas";

		$this->info( '* Import TABELA PREÇOS PEÇAS' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
//	    $file =  'storage' . DIRECTORY_SEPARATOR . 'imports' . DIRECTORY_SEPARATOR . $filename;
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);

		set_time_limit(3600);

		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$price = Price::where('idtabela_preco', $row->idtabela_preco)->first();
				$part = Part::where('idpeca', $row->idpeca)->first();

				$id = DB::table('part_prices')->insertGetId([
					'created_at'    => $row->created_at,
					'price_id'      => $price->id,
					'part_id'       => $part->id,

					'price'         => DataHelper::getReal2Float($row->price),
					'price_min'     => DataHelper::getReal2Float($row->price_min),
					'range'         => DataHelper::getReal2Float($row->range),
					'range_min'     => DataHelper::getReal2Float($row->range_min),

				]);

				$this->info( "****************** (" . $id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
