<?php

namespace App\Console\Commands;

use App\Models\Commons\Picture;
use App\Models\Inputs\Instruments\InstrumentModel;

use App\Models\Ipem\Pam;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;
use Intervention\Image\ImageManagerStatic as Image;

class ImportPamsTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:pams';

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
		Pam::flushEventListeners();
		Pam::getEventDispatcher();

		$entity = "instrument_bases";

		$this->info( '* Import INSTRUMENT SETOR' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);
		set_time_limit(3600);

		$new_path = public_path('uploads/pams/');
		File::deleteDirectory($new_path);

		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$DATA = Pam::whereDescription($row->description)->first();

				if($DATA == NULL){
					$picture = NULL;
//                    verificar se foto existe
					$new_path = public_path('uploads/pams/');

					if($row->foto != NULL){
						$path = storage_path('imports/exports/pams/' . $row->foto);
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

							$this->alert('NOVA FOTO : ' . $row->foto . ', idinstrumento_base: ' . $row->idinstrumento_base);
						} else {
							$this->alert('FOTO INEXISTENTE: ' . $row->foto . ', idinstrumento_base: ' . $row->idinstrumento_base);
							$row->foto = NULL;
						}
					}


					$m = InstrumentModel::where('idinstrumento_modelo', $row->idinstrumento_modelo)->first();
					if($m == NULL) dd('error');

					$id = DB::table('pams')->insertGetId([
						'created_at'            => $row->created_at,
						'picture_id'            => optional($picture)->id,


						'idinstrumento_base'    => $row->idinstrumento_base,
						'instrument_model_id'   => $m->id,
						'description'           => $row->descricao,
						'division'              => $row->divisao,
						'ordinance'             => $row->portaria,
						'capacity'              => $row->capacidade,

					]);

				} else {
					$id = $DATA->id;
					$this->command->alert('PAM EXISTENTE: ' . $DATA->description . ', idinstrumento_base: ' . $DATA->idinstrumento_base);
				}

				$this->info( "****************** (" . $id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
