<?php

namespace App\Console\Commands;

use App\Models\Requests\Request;
use App\Models\Users\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportRequestTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:requests';

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
		Request::flushEventListeners();
		Request::getEventDispatcher();

		$entity = "requests";

		$this->info( '* Import REQUESTS' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
//	    $file =  'storage' . DIRECTORY_SEPARATOR . 'imports' . DIRECTORY_SEPARATOR . $filename;
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);

		set_time_limit(3600);

		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$requester = User::where('iduser', $row->requester_id)->first();
				$manager = User::where('iduser', $row->manager_id)->first();

				$id = DB::table('requests')->insertGetId([
					'created_at'            => $row->created_at,
					'type'      => $row->type,
					'status'      => $row->status,
					'requester_id'      => optional($requester)->id,
					'manager_id'      => optional($manager)->id,
					'reason'   => $row->reason,
					'parameters'   => $row->parameters,
					'response'   => $row->response,
					'end_at'   => $row->end_at,
				]);

				$this->info( "****************** (" . $id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
