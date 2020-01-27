<?php

namespace App\Models\Users;

use App\Companies\Company;
use App\Models\Commons\Picture;
use App\Models\HumanResources\Client;
use App\Models\HumanResources\Settings\Address;
use App\Models\HumanResources\Settings\Contact;
use App\Models\Inputs\Settings\Label;
use App\Models\Inputs\Settings\Seal;
use App\Models\Ipem\Certificate;
use App\Models\Ipem\Pattern;
use App\Models\Requests\RequestPattern;
use App\Models\Requests\Request;
use App\Models\Financials\Billing;
use App\Models\Transactions\Order;
use App\Traits\ActiveTrait;
use App\Traits\AddressTrait;
use App\Traits\NotificationTrait;
use App\Traits\UserCollaboratorTrait;
use App\Traits\UserTechnicianTrait;
use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait; // add this trait to your user model
    use UserTrait;
    use AddressTrait;
    use UserTechnicianTrait;
    use UserCollaboratorTrait;
	use ActiveTrait;
	use NotificationTrait;
    use Notifiable;
    use EntrustUserTrait {
        restore as private restoreA;
    } // add this trait to your user model

    use SoftDeletes {
        restore as private restoreB;
    }

    public function restore() {
        $this->restoreA();
        $this->restoreB();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'iduser',
        'idcolaborador',
        'idtecnico',

        'company_id',
        'address_id',
        'contact_id',

        'name',
        'email',
        'password',
        'cpf',
        'rg',

        'cnh_id',
        'work_permit_id',
        'inmetro_id',
        'ipem_id',

        'discount_max',
        'increase_max',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $appends = [
        'cpf_formatted','rg_formatted',
//        'type',
    ];



	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

	static public function getAlltoSelectList() {
//		return self::active()->get()->map( function ( $s ) {
		return self::get()->map( function ( $s ) {
			return [
				'id'          => $s->id,
				'description' => $s->getName()
			];
		} )->pluck( 'description', 'id' );
	}

    public function is( $name = null ) {
        $role = $this->roles->first();
        return ( $name == null ) ? $role : ( $role->name == $name );
    }

    public function getRoleName() {
        return $this->roles->first()->name;
    }

    public function itsMe($id) {
        return ($this->id == $id);
    }


	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

    public function billings() {
        $role = $this->getRoleName();
        switch($role){
            case 'root':
                return Billing::query();
	        default:
		        return Billing::query();
//            case 'base':
//                return Collect::allBase($this->base()->id);
//            case 'client':
//                return $this->client()->collects;
        }
    }

    public function orders() {
        $role = $this->getRoleName();
        switch($role){
            case 'root':
                return Order::query();
            default:
                return Order::query();
        }
    }

    public function clients() {
        $role = $this->getRoleName();
        switch($role){
            case 'root':
                return Client::query();
            default:
                return Client::query();
//            case 'base':
//                return Collect::allBase($this->base()->id);
//            case 'client':
//                return $this->client()->collects;
        }
    }

    //--------------LABELS--------------

    public function has_labels()
    {
        return ($this->labels()->count() > 0);
    }

    public function last_label()
    {
        $data = $this->hasMany(Label::class, 'owner_id')->orderBy('number', 'dsc')->first();
        return (count($data) > 0) ? $data->number : 0;
    }

    public function used_labels()
    {
        return $this->hasMany(Label::class, 'owner_id')
            ->where('used', 1)
            ->orderBy('number', 'asc');
    }

    public function available_labels()
    {
        return $this->hasMany(Label::class, 'owner_id')
            ->where('used', 0)
            ->orderBy('number', 'asc');
    }

    public function labels_to_change($ini, $end)
    {
        return $this->labels()
            ->where('used', 0)
            ->whereNotNull('number')
            ->whereBetween('number', [$ini, $end])
            ->orderBy('number', 'desc');
    }

    //--------------SEALS--------------

    public function last_seal()
    {
        $data = $this->hasMany(Seal::class, 'owner_id')->orderBy('number', 'dsc')->first();
        return (count($data) > 0) ? $data->number : 0;
    }

    public function has_seals()
    {
        return ($this->seals()->count() > 0);
    }

    public function used_seals()
    {
        return $this->hasMany(Seal::class, 'owner_id')
            ->where('used', 1)
            ->orderBy('number', 'asc');
    }

    public function available_seals() //lacres_disponiveis
    {
        return $this->hasMany(Seal::class, 'owner_id')
            ->where('used', 0)
            ->orderBy('number', 'asc');
    }

    public function seals_to_change($ini, $end)
    {
        return $this->seals()
            ->where('used', 0)
            ->whereNotNull('number')
            ->whereBetween('number', [$ini, $end])
            ->orderBy('number', 'desc');
    }


    //======================== BELONGS ===========================
    //============================================================

	public function company()
	{
		return $this->belongsTo(Company::class, 'company_id');
	}

	public function contact()
	{
		return $this->belongsTo(Contact::class, 'contact_id');
	}

	public function address()
	{
		return $this->belongsTo(Address::class, 'address_id');
	}


	public function cnh()
	{
		return $this->belongsTo(Picture::class, 'cnh_id');
	}

	public function work_permit()
	{
		return $this->belongsTo(Picture::class, 'work_permit_id');
	}

	public function inmetro()
	{
		return $this->belongsTo(Picture::class, 'inmetro_id');
	}

	public function ipem()
	{
		return $this->belongsTo(Picture::class, 'ipem_id');
	}

	public function photo()
	{
		return $this->belongsTo(Picture::class, 'photo_id');
	}

    //======================== HASONE ============================
    //============================================================

    //======================== HASMANY ===========================
    //============================================================
    public function labels()
    {
        return $this->hasMany(Label::class, 'owner_id');
    }

    public function seals()
    {
        return $this->hasMany(Seal::class, 'owner_id');
    }

	public function patterns() {
		return $this->hasMany( Pattern::class, 'owner_id' );
	}

	public function patterns_list() {

        return $this->patterns->map( function ( $s ) {
            return [
                'id'          => $s->id,
                'description' => $s->getName()
            ];
        } )->pluck( 'description', 'id' );

	}

    public function requests()
    {
        return $this->hasMany(Request::class, 'manager_id');
    }

    public function requesteds()
    {
        return $this->hasMany(Request::class, 'requester_id');
    }

	public function requester_certificates()
    {
	    return $this->hasMany( Certificate::class, 'requester_id' );
    }

	public function manager_certificates() {
		return $this->hasMany( Certificate::class, 'manager_id' );
    }

	public function requester_request_patterns() {
		return $this->hasMany( RequestPattern::class, 'requester_id' );
	}

	public function manager_request_patterns() {
		return $this->hasMany( RequestPattern::class, 'manager_id' );
	}



    //============================================================
    //============================================================
    //======================== TECNICO ===========================
    //============================================================
    //============================================================

//    public function getIdTecnico()
//    {
//        $tenico = $this->colaborador->tecnico;
//        return ($tenico != NULL) ? $tenico->idtecnico : $tenico;
//    }

//
//    static public function getAlltoSelectList() {
//
//        return self::get()->map( function ( $s ) {
//            return [
//                'id'          => $s->idtecnico,
//                'description' => $s->getNome()
//            ];
//        } )->pluck( 'description', 'id' );
//    }
//
//    public function requisicoesSeloLacre()
//    {
//        return $this->requisicoes('selo_lacres');
//    }
//
//    public function requisicoes($type)
//    {
//        switch($type){
//            case 'selo_lacres' :
//                return $this->colaborador->requisicoes->whereIn('idtype',[TypeRequest::_TYPE_SELOS_, TypeRequest::_TYPE_LACRES_]);
//                break;
//            case 'patterns' :
//                return $this->colaborador->requisicoes->where('idtype',TypeRequest::_TYPE_PADROES_);
//                break;
//            case 'tools' :
//                return $this->colaborador->requisicoes->where('idtype',TypeRequest::_TYPE_FERRAMENTAS_);
//                break;
//            case 'parts' :
//                return $this->colaborador->requisicoes->where('idtype',TypeRequest::_TYPE_PECAS_);
//                break;
//        }
//    }
//
//    public function waitingRequisicoesSeloLacre()
//    {
//        return $this->waitingRequisicoes('selo_lacres');
//    }
//
//    public function waitingRequisicoes($type)
//    {
//        switch($type){
//            case 'selo_lacres' :
//                return $this->colaborador->requisicoes_waiting->whereIn('idtype',[TypeRequest::_TYPE_SELOS_, TypeRequest::_TYPE_LACRES_]);
//                break;
//            case 'patterns' :
//                return $this->colaborador->requisicoes_waiting->where('idtype',TypeRequest::_TYPE_PADROES_);
//                break;
//            case 'tools' :
//                return $this->colaborador->requisicoes_waiting->where('idtype',TypeRequest::_TYPE_FERRAMENTAS_);
//                break;
//            case 'parts' :
//                return $this->colaborador->requisicoes_waiting->where('idtype',TypeRequest::_TYPE_PECAS_);
//                break;
//        }
//    }
//
//    public function getMaxSelosCanRequest()
//    {
//        return $this->getMaxCanRequest('selos');
//    }
//
//    public function getMaxLacresCanRequest()
//    {
//        return $this->getMaxCanRequest('lacres');
//    }
//
//
//    public function getMaxCanRequest($type)
//    {
//        switch ($type){
//            case 'lacres':
//                return (Setting::getValueByMetaKey('requests_max_lacres') - $this->lacres_disponiveis()->count());
//                break;
//            case 'selos':
//                return (Setting::getValueByMetaKey('requests_max_selos') - $this->selos_disponiveis()->count());
//                break;
//            case 'patterns':
//                return (Setting::getValueByMetaKey('requests_max_patterns') - $this->patterns()->count());
//                break;
//            case 'tools':
//                return (Setting::getValueByMetaKey('requests_max_tools') - $this->tools()->count());
//                break;
//            case 'parts':
//                return (Setting::getValueByMetaKey('requests_max_parts') - 10);
//                break;
//        }
//
//    }
//
//
//    static public function outros($idtecnico)
//    {
//        return self::where('idtecnico', '<>', $idtecnico)->get();
//    }
//
//    public function getNome()
//    {
//        return $this->colaborador->nome;
//    }
//
//    public function setDescontoMaxAttribute($value)
//    {
//        $this->attributes['desconto_max'] = DataHelper::getReal2Float($value);
//    }
//
//    public function getDescontoMaxAttribute($value)
//    {
//        return DataHelper::getFloat2Real($value);
//    }
//
//    public function desconto_max_float()
//    {
//        return $this->attributes['desconto_max'];
//    }
//
//    public function setAcrescimoMaxAttribute($value)
//    {
//        $this->attributes['acrescimo_max'] = DataHelper::getReal2Float($value);
//    }
//
//    public function getAcrescimoMaxAttribute($value)
//    {
//        return DataHelper::getFloat2Real($value);
//    }
//
//    public function acrescimo_max_float()
//    {
//        return $this->attributes['acrescimo_max'];
//    }
//
//    public function getDocumentos()
//    {
//        return json_encode([
//            'Carteira do IMETRO' => ($this->carteira_imetro != '') ? asset('uploads/' . $this->table . '/' . $this->carteira_imetro) : asset('imgs/documents.png'),
//            'Carteira do IPEM' => ($this->carteira_ipem != '') ? asset('uploads/' . $this->table . '/' . $this->carteira_ipem) : asset('imgs/documents.png')
//        ]);
//    }


}
