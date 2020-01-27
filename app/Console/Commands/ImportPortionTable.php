<?php

namespace App\Console\Commands;

use App\Models\Financials\Portion;
use App\Models\Financials\Payment;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportPortionTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:portions';

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
		Portion::flushEventListeners();
		Portion::getEventDispatcher();

		$entity = "parcelas";

		$this->info( '* Import PARCELAS' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
		set_time_limit(3600);
		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$payment = Payment::where('idpagamentos', $row->idpagamento)->first();

				$id = DB::table('portions')->insertGetId([
					'created_at'    => $row->created_at,
					'payment_id'    => $payment->id,
					'status'        => $row->idstatus_parcela,
					'payment_form'  => $row->idforma_pagamento,
					'due_at'        => $row->data_vencimento,
					'paid_at'       => $row->data_pagamento,
					'setted_at'     => $row->data_baixa,
					'portion_number'=> $row->numero_parcela,
					'portion_value' => $row->valor_parcela,
				]);

				$this->info( "****************** (" . $id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
