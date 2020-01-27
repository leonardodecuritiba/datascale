<?php

namespace App\Console\Commands;

use App\Helpers\DataHelper;
use App\Models\Commons\CepCities;
use App\Models\Commons\CepStates;
use App\Models\HumanResources\Provider;
use App\Models\HumanResources\Settings\Address;
use App\Models\HumanResources\Settings\Contact;
use App\Models\HumanResources\Settings\LegalPerson;
use App\Models\HumanResources\Settings\Segment;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportProvidersTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:providers';

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
		Provider::flushEventListeners();
		Provider::getEventDispatcher();

		$entity = "fornecedores";

		$this->info( '* Import FORNECEDORES' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
//	    $file =  'storage' . DIRECTORY_SEPARATOR . 'imports' . DIRECTORY_SEPARATOR . $filename;
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);

		set_time_limit(3600);

		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$segment = Segment::whereDescription($row->segment_name)->first();
				if($segment == NULL){
					$this->alert('SEM SEGMENTO: ' . $row->segment_name . ', idfornecedor: ' . $row->idfornecedor);
					if($row->segment_name != NULL){
						$segment = Segment::create([
							'description' => $row->segment_name
						]);
						$this->alert('SEGMENTO NOVO: ' . $row->segment_name . ', idfornecedor: ' . $row->idfornecedor);
					}
				}


				$state = CepStates::whereShortName($row->state_name)->first();
				if($state == NULL){
					$state = CepStates::whereName($row->state_name)->first();
				}
				if($state == NULL){
					$this->alert('SEM ESTADO: ' . $row->state_name . ', idfornecedor: ' . $row->idfornecedor);
				}

				$city = CepCities::whereName($row->city_name);
				if($state != NULL) {
					$city = $city->whereStateId($state->id);
				}
				$city->first();
				if($city == NULL){
					$this->alert('SEM CIDADE: ' . $row->city_name . ', idfornecedor: ' . $row->idfornecedor);
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
					'district'          => strval($row->district),
					'street'            => strval($row->street),
					'number'            => strval($row->number),
					'complement'        => strval($row->complement),
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
					$legal_person = LegalPerson::create($legal_person);
				} else {
					$cpf = strval($row->cpf);
				}
//			    dd($legal_person);

				/*
					'address_id',
					'contact_id',
					'segment_id',
					'legal_person_id',
					'budget_email',
					'group',
					'responsible_name',
					'cpf',
				 * */
				$provider = [
					'created_at'            => $row->created_at,
//				    'security_id'           => $security->id,
					'idfornecedor'          => intval($row->idfornecedor),
					'address_id'            => $address->id,
					'contact_id'            => $contact->id,
					'segment_id'            => optional($segment)->id,
					'legal_person_id'       => optional($legal_person)->id,
					'budget_email'          => $row->budget_email,
					'group'                 => $row->group,
					'responsible_name'      => $row->responsible_name,
					'cpf'                   => $cpf,
				];

				$id = DB::table('providers')->insertGetId($provider);


				$this->info( "****************** (" . $id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
