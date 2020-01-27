<?php

namespace App\Console\Commands;

use App\Models\Commons\Picture;
use App\Models\HumanResources\Client;
use App\Models\Inputs\Instruments\Instrument;
use App\Models\Inputs\Instruments\InstrumentSetor;
use App\Models\Ipem\Pam;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;
use Intervention\Image\ImageManagerStatic as Image;

class ImportInstrumentsTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:instruments';

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
		Instrument::flushEventListeners();
		Instrument::getEventDispatcher();

		$entity = "instruments";

		$this->info( '* Import INSTRUMENTS' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
		set_time_limit(3600);

		$new_path = public_path('uploads/instruments/');
		File::deleteDirectory($new_path);

		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$client = Client::where('idcliente', $row->idcliente)->first();
				if($client == NULL) dd('error:idcliente');
				$DATA = Instrument::where('serial_number', $row->serial_number)
				                  ->where('patrimony', $row->patrimony)
				                  ->where('inventory', $row->inventory)
				                  ->where('client_id', $client->id)
				                  ->where('ip', $row->ip)
				                  ->where('address', $row->address)
				                  ->first();
				//idinstrumento_modelo	idinstrumento_marca
				if($DATA == NULL){
					$pam = Pam::where('idinstrumento_base', $row->idinstrumento_base)->first();
					if($pam == NULL) dd('error:idinstrumento_base');
					$instrument_setor = InstrumentSetor::where('idinstrumento_setor', $row->idinstrumento_setor)->first();
					if($instrument_setor == NULL) dd('error:idinstrumento_setor');


					$label_identification = NULL;
//                    verificar se foto existe
					$new_path = public_path('uploads/instruments/');

					if($row->etiqueta_identificacao != NULL){
						$path = storage_path('imports/exports/instruments/' . $row->etiqueta_identificacao);
						if(File::exists($path)){
							if(!File::exists($new_path)) {
								// path does not exist
								File::makeDirectory($new_path, $mode = 0777, true, true);
							}
							$label_identification = Picture::create([
								'src'   => $row->etiqueta_identificacao,
								'title' => NULL,
							]);
							$copy = File::copy($path, $new_path . $row->etiqueta_identificacao);

							$file_path = $new_path . $row->etiqueta_identificacao;
							$thumb_path = $new_path . 'thumb_' . $row->etiqueta_identificacao;

							// create instance
							$img = Image::make($file_path)->resize(null, 48*2, function ($constraint) {
								$constraint->aspectRatio();
								$constraint->upsize();
							});

							// resize image to fixed size
							$img->save($thumb_path);

							$this->alert('NOVA etiqueta_identificacao : ' . $row->etiqueta_identificacao . ', idinstrumento: ' . $row->idinstrumento);
						} else {
							$this->alert('FOTO INEXISTENTE: ' . $row->etiqueta_identificacao . ', idinstrumento_base: ' . $row->idinstrumento);
							$row->foto = NULL;
						}
					}


					$label_inventory = NULL;
//                    verificar se foto existe
					$new_path = public_path('uploads/instruments/');

					if($row->etiqueta_inventario != NULL){
						$path = storage_path('imports/exports/instruments/' . $row->etiqueta_inventario);
						if(File::exists($path)){
							if(!File::exists($new_path)) {
								// path does not exist
								File::makeDirectory($new_path, $mode = 0777, true, true);
							}
							$label_inventory = Picture::create([
								'src'   => $row->etiqueta_inventario,
								'title' => NULL,
							]);
							$copy = File::copy($path, $new_path . $row->etiqueta_inventario);

							$file_path = $new_path . $row->etiqueta_inventario;
							$thumb_path = $new_path . 'thumb_' . $row->etiqueta_inventario;

							// create instance
							$img = Image::make($file_path)->resize(null, 48*2, function ($constraint) {
								$constraint->aspectRatio();
								$constraint->upsize();
							});

							// resize image to fixed size
							$img->save($thumb_path);


							$this->alert('NOVA etiqueta_inventario : ' . $row->etiqueta_inventario . ', idinstrumento: ' . $row->idinstrumento);
						} else {
							$this->alert('FOTO INEXISTENTE: ' . $row->etiqueta_inventario . ', idinstrumento_base: ' . $row->idinstrumento);
							$row->foto = NULL;
						}
					}

					$id = DB::table('instruments')->insertGetId([
						'created_at'                => $row->created_at,
						'idinstrumento'             => $row->idinstrumento,
						'client_id'                 => $client->id,
						'pam_id'                    => optional($pam)->id,
						'instrument_setor_id'       => optional($instrument_setor)->id,
						'label_identification_id'   => optional($label_identification)->id,
						'label_inventory_id'        => optional($label_inventory)->id,

						'serial_number'         => $row->serial_number,
						'inventory'             => $row->inventory,
						'patrimony'             => $row->inventory,
						'year'                  => $row->year,
						'ip'                    => $row->ip,
						'address'               => $row->address,

					]);

				} else {
					$id = $DATA->id;
					$this->alert('INSTRUMENT EXISTENTE: ' . $DATA->serial_number . ', idinstrumento: ' . $DATA->idinstrumento);
				}

				$this->info( "****************** (" . $id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
