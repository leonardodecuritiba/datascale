<?php

namespace App\Console\Commands;

use App\Models\Commons\Picture;
use App\Models\HumanResources\Client;
use Illuminate\Support\Facades\File;
use App\Models\Inputs\Equipment;
use App\Models\Parts\Settings\Brand;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;
use Intervention\Image\ImageManagerStatic as Image;

class ImportEquipmentsTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:equipments';

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
		Equipment::flushEventListeners();
		Equipment::getEventDispatcher();

		$entity = "equipamentos";

		$this->info( '* Import EQUIPAMENTOS' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
		set_time_limit(3600);

		$new_path = public_path('uploads/equipments/');
		File::deleteDirectory($new_path);

		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$picture = NULL;
//                    verificar se foto existe
				$new_path = public_path('uploads/equipments/');
				if($row->foto != NULL){
					$path = storage_path('imports/exports/equipamentos/' . $row->foto);
					if(File::exists($path)){
						if(!File::exists($new_path)) {
							// path does not exist
							File::makeDirectory($new_path, $mode = 0777, true, true);
						}
						$picture = Picture::create([
							'src'   => $row->foto,
							'title' => NULL,
						]);
						$copy = File::copy($path, $new_path . $row->foto);

						$file_path = $new_path . $row->foto;
						$thumb_path = $new_path . 'thumb_' . $row->foto;

						// create instance
						$img = Image::make($file_path)->resize(null, 48*2, function ($constraint) {
							$constraint->aspectRatio();
							$constraint->upsize();
						});

						// resize image to fixed size
						$img->save($thumb_path);


						$this->alert('NOVA FOTO : ' . $row->foto . ', idequipamento: ' . $row->idequipamento);
					} else {
						$this->alert('FOTO INEXISTENTE: ' . $row->foto . ', idequipamento: ' . $row->idequipamento);
						$row->foto = NULL;
					}
				}

				$brand = Brand::where('idmarca', $row->idmarca)->first();
				if($brand == NULL){
					$this->alert('SEM MARCA: ' . $row->idmarca . ', idequipamento: ' . $row->idequipamento);
				}
				$idcliente = intval($row->idcliente);
				$client = Client::where('idcliente', $idcliente)->first();

				$equipment = [
					'created_at'            => $row->created_at,
					'idequipamento'         => $row->idequipamento,
					'client_id'             => optional($client)->id,
					'brand_id'              => optional($brand)->id,
					'picture_id'            => optional($picture)->id,
					'description'           => $row->description,
					'model'                 => $row->model,
					'serial_number'         => strval($row->serial_number),

				];
				Equipment::create($equipment);

				$this->info( "****************** (" . $row->idequipamento . ") ******************");

			});
		})->ignoreEmpty();



		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
