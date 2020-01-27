<?php

namespace App\Console\Commands;

use App\Models\Commons\Picture;
use App\Models\Parts\Price;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Helpers\DataHelper;
use App\Models\Commons\CepCities;
use App\Models\Commons\CepStates;
use App\Models\HumanResources\Client;
use App\Models\HumanResources\Settings\Address;
use App\Models\HumanResources\Settings\Contact;
use App\Models\HumanResources\Settings\LegalPerson;
use App\Models\HumanResources\Settings\Segment;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;
use Intervention\Image\ImageManagerStatic as Image;

class ImportClientsTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:clients';

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
		Client::flushEventListeners();
		Client::getEventDispatcher();

		$entity = "clientes";

		$this->info( '* Import CLIENTES' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
//	    $file =  'storage' . DIRECTORY_SEPARATOR . 'imports' . DIRECTORY_SEPARATOR . $filename;
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);

		set_time_limit(3600);

		$new_path = public_path('uploads/clients/');
		File::deleteDirectory($new_path);

		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$picture = NULL;
//                    verificar se foto existe
				$new_path = public_path('uploads/clients/');
				if($row->foto != NULL){
					$path = storage_path('imports/exports/clientes/' . $row->foto);
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

						$ext = pathinfo($file_path, PATHINFO_EXTENSION);
						// create instance
						if(in_array ( $ext , [ 'png', 'jpg', 'jpeg', 'gif', 'tif', 'bmp'])){

							$img = Image::make($file_path)->resize(null, 48*2, function ($constraint) {
								$constraint->aspectRatio();
								$constraint->upsize();
							});

							// resize image to fixed size
							$img->save($thumb_path);

							$this->alert('NOVA FOTO : ' . $row->foto . ', idcliente: ' . $row->idcliente);

						} else {
							$this->alert('FOTO COM FORMATO INADEQUADO: ' . $row->foto . ', idcliente: ' . $row->idcliente);
							$row->foto = NULL;

						}
					} else {
						$this->alert('FOTO INEXISTENTE: ' . $row->foto . ', idcliente: ' . $row->idcliente);
						$row->foto = NULL;
					}
				}

				$segment = Segment::whereDescription($row->segment_name)->first();
				if($segment == NULL){
					$this->alert('SEM SEGMENTO: ' . $row->segment_name . ', idcliente: ' . $row->idcliente);
					if($row->segment_name != NULL){
						$segment = Segment::create([
							'description' => $row->segment_name
						]);
						$this->alert('SEGMENTO NOVO: ' . $row->segment_name . ', idcliente: ' . $row->idcliente);
					}
				}


				$technical_price = Price::where('idtabela_preco', $row->technical_price_id)->first();
				if($technical_price == NULL){
					$this->alert('SEM TABELA PRECO TECNICA idcliente: ' . $row->idcliente);
					exit;
				}

				$commercial_price = Price::where('idtabela_preco', $row->commercial_price_id)->first();
				if($commercial_price == NULL){
					$this->alert('SEM TABELA PRECO COMERCIAL idcliente: ' . $row->idcliente);
					exit;
				}


				$state = CepStates::whereShortName(trim($row->state_name))->first();
				if($state == NULL){
					$state = CepStates::whereName(trim($row->state_name))->first();
				}
				if($state == NULL){
					$this->alert('SEM ESTADO: ' . $row->state_name . ', idcliente: ' . $row->idcliente);
				}

				$city = CepCities::whereName(trim($row->city_name))->first();
				/*
				if($city == NULL) {
					$city = CepCities::whereStateId($state->id)->first();
				}
				*/
				if($city == NULL){
					$this->alert('SEM CIDADE: ' . $row->city_name . ', idcliente: ' . $row->idcliente);
				}

//			    $now = \Carbon\Carbon::now();
//
//			    $security = [
//				    'creator_id'    => 1,
//				    'validator_id'  => 1,
//				    'verb'          => 'IMPORT',
//				    'validated_at'  => $now->toDateTimeString(),
//			    ];
//			    $security = Security::create($security);
				/*
				'state_id',
				'city_id',
				'city_code',
				'zip',
				'district',
				'street',
				'number',
				'complement'
				 * */
				$address = [
					'state_id'          => optional($state)->id,
					'city_id'           => optional($city)->id,
					'city_code'         => strval($row->city_code),
					'zip'               => intval($row->zip),
					'district'          => trim(strval($row->district)),
					'street'            => trim(strval($row->street)),
					'number'            => trim(strval($row->number)),
					'complement'        => trim(strval($row->complement)),
				];

				$address = Address::create($address);

				/*
				'phone',
				'cellphone',
				'skype',
				'email',
				 * */
				$contact = [
					'phone'             => strval($row->phone),
					'cellphone'         => strval($row->cellphone),
					'skype'             => strval($row->skype),
					'email'             => strval($row->email),
				];
				$contact = Contact::create($contact);

				$legal_person = NULL;
				$cpf = NULL;
				if($row->type == 'legal_person'){
					/*
					'cnpj',
					'ie',
					'exemption_ie',
					'social_reason',
					'fantasy_name',
					'ativ_economica',
					'sit_cad_vigente',
					'sit_cad_status',
					'data_sit_cad',
					'reg_apuracao',
					'data_credenciamento',
					'ind_obrigatoriedade',
					'data_ini_obrigatoriedade'
					 */
					$legal_person = [
						'cnpj'                      => strval($row->cnpj),
						'ie'                        => strval($row->ie),
						'exemption_ie'              => strval($row->exemption_ie),
						'social_reason'             => strval($row->social_reason),
						'fantasy_name'              => strval($row->fantasy_name),
						'ativ_economica'            => strval($row->ativ_economica),
						'sit_cad_vigente'           => strval($row->sit_cad_vigente),
						'sit_cad_status'            => strval($row->sit_cad_status),
						'data_sit_cad'              => DataHelper::getPrettyDate($row->data_sit_cad),
						'reg_apuracao'              => strval($row->reg_apuracao),
						'data_credenciamento'       => DataHelper::getPrettyDate($row->data_credenciamento),
						'ind_obrigatoriedade'       => strval($row->ind_obrigatoriedade),
						'data_ini_obrigatoriedade'  => DataHelper::getPrettyDate($row->data_ini_obrigatoriedade),
					];

//                    dd($legal_person);
					$legal_person = LegalPerson::create($legal_person);
				}

				$idcliente_centro_custo = intval($row->idcliente_centro_custo);




				$client = [
					'created_at'            => $row->created_at,
//				    'security_id'           => $security->id,
					'idcliente'             => intval($row->idcliente),
					'idcliente_centro_custo'=> ($idcliente_centro_custo == 0)?NULL:$idcliente_centro_custo,

					'cost_center_id'        => NULL,

					'address_id'            => optional($address)->id,
					'contact_id'            => optional($contact)->id,
					'segment_id'            => optional($segment)->id,
					'legal_person_id'       => optional($legal_person)->id,

					'picture_id'            => optional($picture)->id, //ler do arquivo correto
					'responsible_name'      => $row->responsible_name,
					'cpf'                   => strval($row->cpf),

					'email_budget'          => $row->email_budget,
					'email_bill'            => $row->email_bill,

					//intval($row->technical_price_id)
					'technical_price_id'                => optional($technical_price)->id,
					'technical_form_payment_id'         => intval($row->technical_form_payment_id),
					'technical_billing_issue_type_id'   => intval($row->technical_billing_issue_type_id),
					'technical_due_payment'             => $row->technical_due_payment,
					'technical_credit_limit'            => DataHelper::getReal2Float($row->technical_credit_limit),


					'commercial_price_id'                => optional($commercial_price)->id,
					'commercial_form_payment_id'         => intval($row->commercial_form_payment_id),
					'commercial_billing_issue_type_id'   => intval($row->commercial_billing_issue_type_id),
					'commercial_due_payment'             => $row->commercial_due_payment,
					'commercial_credit_limit'            => DataHelper::getReal2Float($row->commercial_credit_limit),


					'cost_center'               => strval($row->cost_center),
					'distance'                  => DataHelper::getReal2Float($row->distance),
					'tolls'                     => DataHelper::getReal2Float($row->tolls),
					'other_costs'               => DataHelper::getReal2Float($row->other_costs),
					'called_number'             => strval($row->called_number),

				];
				$id = DB::table('clients')->insertGetId($client);

				$this->info( "****************** (" . $id . ") ******************");

			});
		})->ignoreEmpty();

		$this->info( "UDATING COST ID");

		foreach(Client::hasCostCenter()->get() as $client){
			$id = Client::where('idcliente', $client->idcliente_centro_custo)->first()->id;
			$client->update([
				'cost_center_id' => $id
			]);
			$this->info( "****************** (" . $client->id . ") ******************");

		}

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
