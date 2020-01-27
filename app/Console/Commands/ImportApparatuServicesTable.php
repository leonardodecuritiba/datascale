<?php

namespace App\Console\Commands;

use App\Models\Parts\Service;
use App\Models\Transactions\Apparatu;
use App\Models\Transactions\Settings\ApparatuService;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportApparatuServicesTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:apparatu_services';

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
		ApparatuService::flushEventListeners();
		ApparatuService::getEventDispatcher();

		$entity = "servicos_prestados";

		$this->info( '* Import servicos_prestados' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
		set_time_limit(3600);
		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$apparatu = Apparatu::where('idaparelho_manutencao',$row->idaparelho_manutencao)->first();
				if($apparatu == NULL){
					$this->info( "****************** idaparelho_manutencao ******************");
					DD($row);
				}
				$service = Service::where('idservico',$row->idservico)->first();
				if($service == NULL){
					$this->info( "****************** idservico ******************");
					DD($row);
				}

				$id = DB::table('apparatu_services')->insertGetId([
					'created_at'            => $row->created_at,
					'idservico_prestado'    => $row->idservico_prestado,
					'apparatu_id'           => $apparatu->id,
					'service_id'            => $service->id,
					'value'                 => $row->valor,
					'quantity'              => $row->quantidade,
					'discount'              => $row->desconto
				]);

				$this->info( "****************** (" . $id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
