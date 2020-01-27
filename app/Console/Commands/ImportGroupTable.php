<?php

namespace App\Console\Commands;

use App\Models\Parts\Settings\Group;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportGroupTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:groups';

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
		Group::flushEventListeners();
		Group::getEventDispatcher();

		$entity = "grupos";

		$this->info( '* Import GROUPS' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
		set_time_limit(3600);
		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$DATA = Group::whereDescription($row->description)->first();
				$id = optional($DATA)->id;
				if($DATA == NULL){
//					dd($row->created_at);
					$id = DB::table('groups')->insertGetId([
						'created_at'    => $row->created_at,
						'idgrupo'       => $row->idgrupo,
						'description'   => $row->description,
					]);
				} else {
					$this->command->alert('GRUPO EXISTENTE: ' . $DATA->description . ', idgrupo: ' . $DATA->idgrupo);
				}

				$this->info( "****************** (" . $id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
