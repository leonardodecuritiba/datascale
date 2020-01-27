<?php

namespace App\Console\Commands;

use App\Helpers\DataHelper;
use App\Models\Parts\Service;
use App\Models\Parts\Settings\Group;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportServicesTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:services';

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
		Service::flushEventListeners();
		Service::getEventDispatcher();

		$entity = "servicos";

		$this->info( '* Import SERVIÇOS' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
//	    $file =  'storage' . DIRECTORY_SEPARATOR . 'imports' . DIRECTORY_SEPARATOR . $filename;
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);

		set_time_limit(3600);

		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$DATA = Service::whereDescription($row->description)->first();
				if($DATA == NULL){
					$group = Group::where('idgrupo',$row->idgrupo)->first();
					if($group == NULL){
						$this->alert('SEM GRUPO: ' . $row->idgrupo . ', idservico: ' . $row->idservico);
					}

					$id = DB::table('services')->insertGetId([
						'created_at'    => $row->created_at,
						'idservico'     => $row->idservico,
						'name'          => $row->name,
						'description'   => $row->description,
						'value'         => DataHelper::getReal2Float($row->value),
						'group_id'      => optional($group)->id,
						'unity_id'      => $row->idunidade,
					]);
					$DATA = Service::find($id);
				} else {
					$this->alert('SERVIÇO EXISTENTE: ' . $DATA->description . ', idservico: ' . $DATA->idservico);
				}

				$this->info( "****************** (" . $DATA->id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
