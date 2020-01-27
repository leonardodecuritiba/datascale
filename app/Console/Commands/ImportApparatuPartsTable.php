<?php

namespace App\Console\Commands;

use App\Models\Parts\Part;
use App\Models\Transactions\Apparatu;
use App\Models\Transactions\Settings\ApparatuPart;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportApparatuPartsTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:apparatu_parts';

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
		ApparatuPart::flushEventListeners();
		ApparatuPart::getEventDispatcher();

		$entity = "pecas_utilizadas";

		$this->info( '* Import pecas_utilizadas' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
		set_time_limit(3600);
		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$apparatu = Apparatu::where('idaparelho_manutencao',$row->idaparelho_manutencao)->first();
				$part = Part::where('idpeca',$row->idpeca)->first();

				$id = DB::table('apparatu_parts')->insertGetId([
					'created_at'            => $row->created_at,
					'idpeca_utilizada'      => $row->idpeca_utilizada,
					'apparatu_id'           => $apparatu->id,
					'part_id'               => $part->id,
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
