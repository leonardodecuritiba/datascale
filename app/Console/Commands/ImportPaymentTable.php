<?php

namespace App\Console\Commands;

use App\Models\Parts\Settings\Group;
use App\Models\Financials\Billing;
use App\Models\Financials\Payment;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportPaymentTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:payments';

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
		Payment::flushEventListeners();
        Payment::getEventDispatcher();

		$entity = "pagamentos";

		$this->info( '* Import PAGAMENTOS' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
		set_time_limit(3600);
		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$id = DB::table('payments')->insertGetId([
					'created_at'    => $row->created_at,
					'idpagamentos'  => $row->idpagamento,
					'set_date'      => $row->data_baixa,
					'status'        => $row->status,
				]);
				$DATA = Payment::find($id);

				$this->info( "****************** (" . $DATA->id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
