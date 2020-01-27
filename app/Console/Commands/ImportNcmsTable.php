<?php

namespace App\Console\Commands;

use App\Helpers\DataHelper;
use App\Models\Parts\Settings\Ncm;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportNcmsTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:ncms';

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
		Ncm::flushEventListeners();
		Ncm::getEventDispatcher();

		$entity = "ncms";

		$this->info( '* Import NCM' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
		set_time_limit(3600);
		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$DATA = Ncm::whereCode($row->codigo)->first();
				if($DATA == NULL){
					$id = DB::table('ncms')->insertGetId([
						'created_at'    => $row->created_at,
						'idncm'         => $row->idncm,
						'code'          => $row->codigo,
						'description'   => $row->descricao,
						'ipi'           => DataHelper::getReal2Float($row->aliquota_ipi),
						'pis'           => DataHelper::getReal2Float($row->aliquota_pis),
						'cofins'        => DataHelper::getReal2Float($row->aliquota_cofins),
						'nacional'      => DataHelper::getReal2Float($row->aliquota_nacional),
						'importacao'    => DataHelper::getReal2Float($row->aliquota_importacao),

					]);

				} else {
					$id = $DATA->id;
					$this->alert('NCM EXISTENTE: ' . $DATA->descricao . ', idncm: ' . $DATA->idncm);
				}

				$this->info( "****************** (" . $id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
