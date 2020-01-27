<?php

namespace App\Console\Commands;

use App\Helpers\DataHelper;
use App\Models\Commons\Picture;
use App\Models\Users\Role;
use App\Models\Users\User;
use Illuminate\Support\Facades\File;
use App\Models\Commons\CepCities;
use App\Models\Commons\CepStates;
use App\Models\HumanResources\Settings\Address;
use App\Models\HumanResources\Settings\Contact;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ImportUsersTable extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:users';

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
		User::flushEventListeners();
        User::getEventDispatcher();

		$entity = "users";

		$this->info( '* Import USERS' );
		$start = microtime(true);

		$filename = $entity . '.xls';

		$this->info( "*** Iniciando o Upload (" . $entity . ") ***");
//	    $file =  'storage' . DIRECTORY_SEPARATOR . 'imports' . DIRECTORY_SEPARATOR . $filename;
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . 'exports' . DIRECTORY_SEPARATOR . $filename);

		set_time_limit(3600);

		$new_path = public_path('uploads/users/');
		File::deleteDirectory($new_path);

		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {

				$picture = NULL;
//                    verificar se foto existe
				$new_path = public_path('uploads/users/');

				$fields = ['cnh', 'carteira_trabalho', 'carteira_imetro', 'carteira_ipem'];
				$pictures = [];
				foreach ($fields as $field){
                    if($row->{$field} != NULL){
                        $path = storage_path('imports/exports/users/' . $row->{$field});
                        if(File::exists($path)){
                            if(!File::exists($new_path)) {
                                // path does not exist
                                File::makeDirectory($new_path, $mode = 0777, true, true);
                            }
                            $pictures[$field] = Picture::create([
                                'src'   => $row->{$field},
                                'title' => NULL,
                            ]);
                            $copy = File::copy($path, $new_path . $row->{$field});
                            $this->alert('NOVA FOTO : ' . $row->{$field} . ', iduser: ' . $row->iduser);
                        } else {
                            $this->alert('FOTO INEXISTENTE: ' . $row->{$field} . ', iduser: ' . $row->iduser);
                            $row->{$field} = NULL;
                        }
                    }
                }


                //--------------------- ADDRESS ---------------------
                $state = CepStates::whereShortName(trim($row->state_name))->first();
                if($state == NULL){
                    $state = CepStates::whereName(trim($row->state_name))->first();
                }
                if($state == NULL){
                    $this->alert('SEM ESTADO: ' . $row->state_name . ', idcliente: ' . $row->idcliente);
                }

                $city = CepCities::whereName(trim($row->city_name))->first();
                if($city == NULL){
                    $this->alert('SEM CIDADE: ' . $row->city_name . ', idcliente: ' . $row->idcliente);
                }

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

                //--------------------- CONTACT ---------------------
                $contact = [
                    'phone'             => strval($row->phone),
                    'cellphone'         => strval($row->cellphone),
                    'skype'             => strval($row->skype),
                    'email'             => strval($row->email),
                ];
                $contact = Contact::create($contact);

                $user = [
	                'created_at'            => $row->created_at,
                    'iduser'                => $row->iduser,

				    'company_id'            => 1,
                    'address_id'            => optional($address)->id,
                    'contact_id'            => optional($contact)->id,

                    'idcolaborador'         => $row->idcolaborador,
                    'idtecnico'             => $row->idtecnico,

                    'name'                  => ($row->nome == NULL) ? 'SEM NOME' : $row->nome,
                    'email'                 => $row->email,
                    'password'              => $row->password,
                    'cpf'                   => $row->cpf,
                    'rg'                    => $row->rg,

                    'cnh_id'                => isset($pictures['cnh']) ? optional($pictures['cnh'])->id : NULL,
                    'work_permit_id'        => isset($pictures['work_permit_id']) ? optional($pictures['work_permit'])->id : NULL,
                    'inmetro_id'            => isset($pictures['inmetro_id']) ? optional($pictures['inmetro'])->id : NULL,
                    'ipem_id'               => isset($pictures['ipem_id']) ? optional($pictures['ipem'])->id : NULL,

                    'discount_max'          => DataHelper::getReal2Float($row->desconto_max),
                    'increase_max'          => DataHelper::getReal2Float($row->acrescimo_max),
                ];

				$User = User::create($user);

				$role = Role::where('name', $row->type)->first();
                $User->attachRole($role->id);


				$this->info( "****************** (" . $row->iduser . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
