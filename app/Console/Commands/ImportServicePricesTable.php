<?php

namespace App\Console\Commands;

use App\Helpers\DataHelper;
use App\Models\HumanResources\Settings\Region;
use App\Models\Parts\Price;
use App\Models\Parts\Service;
use App\Models\Parts\ServicePrice;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportServicePricesTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:service_prices';

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
		ServicePrice::flushEventListeners();
		ServicePrice::getEventDispatcher();

		$entity = "tabela_preco_servicos";

		$this->info( '* Import TABELA PREÇOS SERVIÇOS' );
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
				$service = Service::where('idservico', $row->idservico)->first();

				$id = DB::table('service_prices')->insertGetId([
					'created_at'    => $row->created_at,
					'price_id'      => $price->id,
					'service_id'    => $service->id,

					'price'         => DataHelper::getReal2Float($row->price),
					'price_min'     => DataHelper::getReal2Float($row->price_min),
					'range'         => DataHelper::getReal2Float($row->range),
					'range_min'     => DataHelper::getReal2Float($row->range_min),
				]);
				$DATA = ServicePrice::find($id);

				$this->info( "****************** (" . $DATA->id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
