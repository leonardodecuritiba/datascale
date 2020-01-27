<?php

namespace App\Console\Commands;

use App\Models\Commons\Picture;
use App\Models\HumanResources\Provider;
use App\Models\Parts\Settings\Cst;
use Illuminate\Support\Facades\File;
use App\Models\Parts\Part;
use App\Models\Parts\Settings\Cfop;
use App\Models\Parts\Settings\NatureOperation;
use App\Models\Parts\Settings\Unity;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;
use Intervention\Image\ImageManagerStatic as Image;

class ImportPartsTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:parts';

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
		Part::flushEventListeners();
		Part::getEventDispatcher();

		$entity = "pecas";

		$this->info( '* Import PEÇAS' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
//	    $file =  'storage' . DIRECTORY_SEPARATOR . 'imports' . DIRECTORY_SEPARATOR . $filename;
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);

		set_time_limit(3600);

		$new_path = public_path('uploads/parts/');
		File::deleteDirectory($new_path);
		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$picture = NULL;
				$new_path = public_path('uploads/parts/');
				if($row->foto != NULL){
					$path = storage_path('exports/pecas/' . $row->foto);
					if(File::exists($path)){
						if(!File::exists($new_path)) {
							// path does not exist
							File::makeDirectory($new_path, $mode = 0777, true, true);
						}
						$picture = Picture::create([
							'url'   => $row->foto,
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

						$this->alert('NOVA FOTO : ' . $row->foto . ', idpeca: ' . $row->idpeca);
					} else {
						$row->foto = NULL;
					}
				}

				$provider = Provider::where('idfornecedor', $row->idfornecedor)->first();
				if($provider == NULL){
					$this->alert('SEM FORNECEDOR: ' . $row->idfornecedor . ', idpeca: ' . $row->idpeca);
				}

				$unity = Unity::whereCode(strval($row->unity_name));
				if($unity == NULL){
					$this->alert('SEM UNIDADE: ' . $row->unity_name . ', idpeca: ' . $row->idpeca);
				}

				$cfop = Cfop::whereCode(intval($row->cfop));
				if($cfop == NULL){
					$this->alert('SEM CFOP: ' . $row->cfop . ', idpeca: ' . $row->idpeca);
				}

				$cst = Cst::whereCode(intval($row->cst));
				if($cst == NULL){
					$this->alert('SEM CST: ' . $row->cfop . ', idpeca: ' . $row->idpeca);
				}

				$nature_operation = NatureOperation::whereDescription(strval($row->nature_operation));
				if($nature_operation == NULL){
					$this->alert('SEM NATUREZA OPERAÇÃO: ' . $row->nature_operation . ', idpeca: ' . $row->idpeca);
				}

				if($row->ncm_id == NULL){
					$this->alert('SEM NCM: ' . $row->ncm_id . ', idpeca: ' . $row->idpeca);
				}

				if($row->brand_id == NULL){
					$row->brand_id = NULL;
					$this->alert('SEM MARCA: ' . $row->brand_id . ', idpeca: ' . $row->idpeca);
				} else {
					$row->brand_id = intval($row->brand_id);
				}

				if($row->group_id == NULL){
					$row->group_id = NULL;
					$this->alert('SEM MARCA: ' . $row->group_id . ', idpeca: ' . $row->idpeca);
				} else {
					$row->group_id = intval($row->group_id);
				}

				$now = \Carbon\Carbon::now();

//			    $security = [
//				    'creator_id'    => 1,
//				    'validator_id'  => 1,
//				    'verb'          => 'IMPORT',
//				    'validated_at'  => $now->toDateTimeString(),
//			    ];
//			    $security = Security::create($security);


				$part = [
					'created_at'    => $row->created_at,
//				    'security_id'   => $security->id,
					'provider_id'   => $provider->id,
					'idpeca'        => intval($row->idpeca),
					'brand_id'      => $row->brand_id,
					'group_id'      => $row->group_id,
					'picture_id'    => optional($picture)->id,

					'unity_id'      => optional($unity)->id,
					'type'          => ($row->type == 'peca')? 'part' : 'product',

					'auxiliar_code'         => strval($row->auxiliar_code),
					'bar_code'              => ($row->bar_code != NULL) ? strval($row->bar_code) : NULL,
					'description'           => strval($row->description),
					'technical_description' => strval($row->technical_description),

					'sub_group'             => ($row->sub_group != NULL) ? strval($row->sub_group) : NULL,
					'warranty'              => intval($row->warranty),
					'technical_commission'  => $row->technical_commission,
					'seller_commission'     => $row->seller_commission,

					//taxation
					'ncm_id'                => intval($row->ncm_id),
					'cfop_id'               => optional($cfop)->id,
					'cst_id'                => optional($cst)->id,
					'nature_operation_id'   => optional($nature_operation)->id,
					'cest'                  => strval($row->cest),

					'icms_base_calculo'     => ($row->icms_base_calculo),
					'icms_valor_total'      => ($row->icms_valor_total),
					'icms_base_calculo_st'  => ($row->icms_base_calculo_st),
					'icms_valor_total_st'   => ($row->icms_valor_total_st),

					'icms_origem'               => strval($row->icms_origem),
					'icms_situacao_tributaria'  => strval($row->icms_situacao_tributaria),
					'pis_situacao_tributaria'   => strval($row->pis_situacao_tributaria),
					'cofins_situacao_tributaria'=> strval($row->cofins_situacao_tributaria),

					'valor_unitario_comercial'  => ($row->valor_unitario_comercial),
					'unidade_tributavel'        => ($row->unidade_tributavel),
					'valor_unitario_tributavel' => ($row->valor_unitario_tributavel),

					'valor_ipi'                 => ($row->valor_ipi),
					'valor_frete'               => ($row->valor_frete),
					'valor_seguro'              => ($row->valor_seguro),
					'valor_total'               => ($row->valor_total),
				];
//			    dd($row);
				Part::create($part);


				/*

				'unity_name',
				'type',

				'auxiliar_code',
				'bar_code',
				'description',
				'technical_description',

				'sub_grupo',
				'warranty',
				'technical_commission',
				'seller_commission',

				//taxation
				'ncm_id',
				'cfop',
				'cst',
				'nature_operation',
				'cest',

				'icms_base_calculo',
				'icms_valor_total',
				'icms_base_calculo_st',
				'icms_valor_total_st',

				'icms_origem',
				'icms_situacao_tributaria',
				'pis_situacao_tributaria',
				'cofins_situacao_tributaria',

				'valor_unitario_comercial',
				'unidade_tributavel',
				'valor_unitario_tributavel',

				'valor_ipi',
				'valor_frete',
				'valor_seguro',
				'valor_total',

				*/

				$this->info( "****************** (" . $row->idpeca . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
