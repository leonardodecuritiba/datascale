<?php

namespace App\Models\HumanResources;

use App\Helpers\DataHelper;
use App\Models\Commons\Picture;
use App\Models\Commons\Setting;
use App\Models\HumanResources\Settings\Address;
use App\Models\HumanResources\Settings\Contact;
use App\Models\HumanResources\Settings\LegalPerson;
use App\Models\HumanResources\Settings\Segment;
use App\Models\Inputs\Equipment;
use App\Models\Inputs\Instruments\Instrument;
use App\Models\Parts\Price;
use App\Models\Financials\Billing;
use App\Models\Transactions\Order;
use App\Traits\ActiveTrait;
use App\Traits\Billings\BillingIssueTypeTrait;
use App\Traits\Billings\PaymentFormTrait;
use App\Traits\ClientServicesTrait;
use App\Traits\DateTimeTrait;
use App\Traits\Relashionships\PictureTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
	use ClientServicesTrait;

	use SoftDeletes;
	use PaymentFormTrait;
	use BillingIssueTypeTrait;
    use DateTimeTrait;
    use StringTrait;
    use ActiveTrait;
	use PictureTrait;
	public $timestamps = true;
	static public $img_path = 'clients';

	protected $fillable = [

		'cost_center_id',
		'address_id',
		'contact_id',
		'segment_id',
		'legal_person_id',
		'picture_id',

		'responsible_name',
		'cpf',
		'email_budget',
		'email_bill',

		'technical_price_id',
		'technical_form_payment_id',
		'technical_billing_issue_type_id',
		'technical_due_payment',
		'technical_credit_limit',

		'commercial_price_id',
		'commercial_form_payment_id',
		'commercial_billing_issue_type_id',
		'commercial_due_payment',
		'commercial_credit_limit',

		'cost_center',

		'distance',
		'tolls',
		'other_costs',
		'called_number',
		'validated_at',

		'active',


		'idcliente',
		'idcliente_centro_custo',
	];

	protected $appends = [
		'cpf_formatted',
		'ie_formatted',
		'fantasy_name_text',
		'social_reason_text',
		'short_description',
		'short_document',
	];


	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

	public function sendNF($link)
	{
		DD('SENT');
// Setup a new SmtpTransport instance for Gmail
		$transport = SmtpTransport::newInstance(
			env('MAIL_HOST'),
			env('MAIL_PORT'),
			env('MAIL_ENCRYPTION')
		);

		$transport->setUsername(env('MAIL_USERNAME_FATURAMENTO'));
		$transport->setPassword(env('MAIL_PASSWORD_FATURAMENTO'));
		$email = new Swift_Mailer($transport);
		Mail::setSwiftMailer($email);

		$cliente = [
			'nome' => $this->nome_responsavel,
			'email' => $this->email_nota
		];
		return Mail::send('emails.clientes.send_nf', ['link' => $link, 'cliente' => $this], function ($m) use ($cliente) {
			$m->from(env('MAIL_USERNAME_FATURAMENTO'), env('MAIL_NAME_FATURAMENTO'));
			$m->to(['silva.zanin@gmail.com', 'comercial@atlastecnologia.com.br'], $cliente['nome'])
			  ->subject('Nota Fiscal');
		});

	}

	//============================================================
	//======================== ACCESSORS =========================
	//============================================================

    public function getName()
    {
	    return $this->short_description;
    }

    public function isLegalPerson()
    {
        return ($this->getAttribute('legal_person_id') != NULL);
    }

	public function getIeFormattedAttribute()
	{
        return $this->isLegalPerson() ? $this->legal_person->ie_formatted : NULL;
	}

	public function getShortDescriptionAttribute()
	{
        return $this->isLegalPerson() ? $this->legal_person->fantasy_name : $this->getAttribute('responsible_name');
	}

	public function getShortDocumentAttribute()
	{
        return $this->isLegalPerson() ? $this->legal_person->cnpj_formatted : $this->cpf_formatted;
	}

	public function getTypeNameTextAttribute()
	{
		return $this->isLegalPerson() ? 'Pessoa Jurídica' : 'Pessoa Física';
	}

	public function getFantasyNameTextAttribute()
	{
		return $this->isLegalPerson() ? $this->legal_person->fantasy_name : $this->getAttribute('responsible_name');
	}

	public function getSocialReasonTextAttribute()
	{
		return $this->isLegalPerson() ? $this->legal_person->social_reason : $this->getAttribute('responsible_name');
	}

	public function getCpfFormattedAttribute()
	{
		return DataHelper::mask($this->getAttribute('cpf'), '###.###.###-##');
	}

	public function getTotalTravelCost()
	{
		return $this->getAttribute('distance') * DataHelper::getReal2Float(Setting::getByMetaKey('custo_km')->meta_value);
	}

	public function verifyTechnicalDuePayment($id)
	{
	    return json_decode($this->technical_due_payment)->id == $id;
	}

	public function getTechnicalDuePaymentExtras()
	{
	    return json_decode($this->technical_due_payment)->extras;
	}

	//============================================================
	//======================== MUTATORS ==========================
	//============================================================

    //============================================================
    //======================== SCOPE =============================
    //============================================================

    public function scopeHasCostCenter($query)
    {
        return $query->whereNotNull('idcliente_centro_custo');
    }
	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

    //Function to unset center cost
    public function unsetCenterCost()
    {
        return $this->update([
            'cost_center_id' => NULL
        ]);
    }

	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

	//======================== FUNCTIONS =========================

//	public function has_instrumento()
//	{
//		return ($this->instrumentos()->count() > 0);
//	}
//
//	public function has_equipamento()
//	{
//		return ($this->equipamentos()->count() > 0);
//	}
//
//	public function has_ordem_servicos()
//	{
//		return ($this->ordem_servicos()->count() > 0);
//	}



	//======================== BELONGS ===========================


	public function address()
	{
		return $this->belongsTo(Address::class, 'address_id');
	}

	public function contact()
	{
		return $this->belongsTo(Contact::class, 'contact_id');
	}

	public function segment()
	{
		return $this->belongsTo(Segment::class, 'segment_id');
	}

	public function legal_person()
	{
		return $this->belongsTo(LegalPerson::class, 'legal_person_id');
	}

	public function cost_center_of() //quem é o centro de custo do cliente
	{
		return $this->belongsTo(self::class, 'cost_center_id','id');
	}

	public function technical_price()
	{
		return $this->belongsTo(Price::class, 'technical_price_id');
	}

	public function commercial_price()
	{
		return $this->belongsTo(Price::class, 'commercial_price_id');
	}

    public function picture()
    {
        return $this->belongsTo(Picture::class, 'picture_id');
    }

	//======================== HASONE ============================

	//======================== HASMANY ===========================

	public function cost_center_for($client_id = NULL) //listagens para quem o cliente é centro de custo
	{
		$query = $this->hasMany(Client::class, 'cost_center_id','id');
		if($client_id != NULL) $query->where('id', '!=',$client_id);
		return $query->get();
	}

	public function equipments()
	{
		return $this->hasMany(Equipment::class, 'client_id');
	}

	public function instruments()
	{
		return $this->hasMany(Instrument::class, 'client_id');
	}

	public function center_cost_for($client_id = NULL) //listagens para quem o cliente é centro de custo
	{
		$query = $this->hasMany(self::class, 'cost_center_id','client_id');
		if($client_id != NULL) $query->where('client_id', '!=',$client_id);
		return $query->get();
	}

	public function billings()
	{
		return $this->hasMany(Billing::class, 'client_id');
	}


	public function orders()
	{
		return $this->hasMany(Order::class, 'client_id');
	}

	public function orders_cost_center()
	{
		return $this->hasMany( Order::class, 'cost_center_id', 'id' );
	}

	// ************************** HAS **********************************








//
//
//
//
//
//
//	// =====================================================================
//	// ======================== NEW FUNCTIONS ==============================
//	// =====================================================================



//	// ************ Corrigir depois quando Houver VENDA ************
//	public function getData(){
//		$data = $this->toArray();
//		$available_limit_tecnica = $this->getAvailableLimitTecnica();
//		$available_limit_comercial = $this->getAvailableLimitComercial();
//		return json_encode(array_merge($data,[
//			'available_limit_tecnica'               => $available_limit_tecnica,
//			'available_limit_tecnica_formatted'     => $this->getAvailableLimitTecnicaFormatted($available_limit_tecnica),
//			'available_limit_comercial'             => $available_limit_comercial,
//			'available_limit_comercial_formatted'   => $this->getAvailableLimitComercialFormatted($available_limit_comercial),
//		]));
//
//	}
//
//	public function getAvailableLimitCentroCusto($type = 'tecnica'){
//		$ordem_servicos = $this->ordem_servicos_centro_custo;
//		$sum = $ordem_servicos->whereIn('idsituacao_ordem_servico',
//			[
//				OrdemServico::_STATUS_FINALIZADA_,
//				OrdemServico::_STATUS_AGUARDANDO_PECA_,
//				OrdemServico::_STATUS_EQUIPAMENTO_NA_OFICINA_,
//				OrdemServico::_STATUS_FATURAMENTO_PENDENTE_,
//			])->sum('valor_final');
//		return $sum;
//	}
//

//
//	public function getAvailableLimitTecnica()
//	{
//		return $this->getAvailableLimit($type = 'tecnica');
//	}
//
//	public function getAvailableLimitTecnicaFormatted($value = NULL)
//	{
//		$value = ($value == NULL) ? $this->getAvailableLimitTecnica() : $value;
//		return DataHelper::getFloat2RealMoeda($value);
//	}
//
//	public function getAvailableLimitComercial()
//	{
//		return $this->getAvailableLimit($type = 'comercial');
//	}
//
//	public function getAvailableLimitComercialFormatted($value = NULL)
//	{
//		$value = ($value == NULL) ? $this->getAvailableLimitComercial() : $value;
//		return DataHelper::getFloat2RealMoeda($value);
//	}
//
//
//	static public function findByText($search)
//	{
//		$query = (new self)->newQuery();
//		if ($search != NULL) {
//			$pj_ids = PessoaJuridica::where('razao_social', 'like', '%' . $search . '%')
//			                        ->orWhere('nome_fantasia', 'like', '%' . $search . '%')
//			                        ->pluck('idpjuridica');
//			if($pj_ids->count() > 0){
//				$query->whereIn('idpjuridica', $pj_ids);
//			}
//
//			$numbers = DataHelper::getOnlyNumbers($search);
//			if($numbers != ""){
//				$pf_ids = PessoaFisica::where('cpf', 'like', '%' . DataHelper::getOnlyNumbers($search) . '%')->pluck('idpfisica');
//				if($pf_ids->count() > 0){
//					$query->whereIn('idpfisica', $pf_ids);
//				}
//			}
//
//		}
////        $query->orWhere('nome_responsavel', 'like', '%' . $search . '%');
//		return $query
//			->with('pessoa_juridica', 'pessoa_fisica');
//	}
//
//
//	public function getLimitCentroCusto($client_id = NULL)
//	{
//		$max = $this->attributes['limite_credito_tecnica'];
//		$soma = $this->centro_custo_para($client_id)->sum(function($c){
//			return $c->attributes['limite_credito_tecnica'];
//		});
//
//		return $max - $soma;
//	}
//
//	public function getLimitCentroCustoFormatted()
//	{
//		return DataHelper::getFloat2RealMoeda($this->getLimitCentroCusto($client_id = NULL));
//	}
//
//	public function getMaxCentroCusto()
//	{
//		return $this->centro_custo_de->getLimitCentroCusto();
//	}
//
//	public function isCentroCusto()
//	{
//		return ($this->attributes['idcliente_centro_custo'] != NULL);
//	}
//
//
//	public function getRazaoSocial()
//	{
//		return ($this->is_pjuridica()) ?
//			$this->pessoa_juridica()->first()->razao_social :
//			$this->attributes['nome_responsavel'];
//	}
//
//	public function getTipoEmissao($option)
//	{
//		$tipo = ($option == 'tecnica') ? $this->tipo_emissao_tecnica : $this->tipo_emissao_comercial;
//		return $tipo->descricao;
//	}
//
//	public function getFormaPagamento($option)
//	{
//		$tipo = ($option == 'tecnica') ? $this->forma_pagamento_tecnica : $this->forma_pagamento_comercial;
//		return $tipo->descricao;
//	}
//
//	public function getPrazoPagamentoText($option)
//	{
//		if ($option == 'tecnica') {
//			$data = $this->prazo_pagamento_tecnica;
//		} else {
//			$data = $this->prazo_pagamento_comercial;
//		}
//
//		if ($data->id) {
//			$parcelas = implode(', ', $data->extras);
//			$text = 'PARCELADO: ' . $parcelas . ' dias';
//		} else {
//			$text = 'À VISTA';
//		}
//		return $text;
//	}
//
//
//	public function getShortName()
//	{
//		return str_limit($this->getName(),20);
//	}
//
//	public function getDocument()
//	{
//		return ($this->is_pjuridica()) ?
//			$this->pessoa_juridica()->first()->cnpj :
//			$this->pessoa_fisica()->first()->cpf;
//	}
//
//	public function getResponsibleName()
//	{
//		return $this->attributes['nome_responsavel'];
//	}
//
//	public function getPhone()
//	{
//		return $this->contato->telefone;
//	}
//
//	// =====================================================================
//	// ======================== SITUATION ==================================
//	// =====================================================================
//
//	public function getValidatedColor()
//	{
//		return $this->validado() ? 'success' : 'danger';
//	}
//
//	public function getValidatedText()
//	{
//		return $this->validado() ? 'Validado' : 'Não Validado';
//	}
//
//	// =====================================================================
//	// ======================== COSTS FUNCTIONS ============================
//	// =====================================================================
//
//	public function getCostDisplacement()
//	{
//		return ($this->attributes['distancia'] * DataHelper::getReal2Float(Setting::getByMetaKey('custo_km')->meta_value));
//	}
//
//	public function getCostDisplacementFormatted()
//	{
//		return DataHelper::getReal2Float($this->getCostDisplacement());
//	}
//
//	public function getCostToll()
//	{
//		return $this->attributes['pedagios'];
//	}
//
//	public function getCostTollFormatted()
//	{
//		return DataHelper::getReal2Float($this->getCostToll());
//	}
//
//	public function getCostOther()
//	{
//		return $this->attributes['outros_custos'];
//	}
//
//	public function getCostOtherFormatted()
//	{
//		return DataHelper::getReal2Float($this->getCostOther());
//	}
//
//
//	// =====================================================================
//	// =====================================================================
//	// =====================================================================
//
//	// ************************ EMAIL-FUNCTIONS ******************************
//
//	static public function getInvalidos()
//	{
//		return self::whereNull('idcolaborador_validador')->whereNull('validated_at')->get();
//	}
//
//
//	// ************************ FUNCTIONS ******************************
//
//
//	static public function getValidosOrdemServico()
//	{
//		return self::whereNotNull('validated_at')
//		           ->orWhere('created_at', '<', Carbon::now()->subDay());
//
//		return self::whereNotNull('validated_at')
//		           ->orWhere(function ($query) {
//			           $query->whereNull('validated_at');
//			           $query->where('created_at', '<', Carbon::now()->subDay());
//		           });
//
//		return self::whereNull('validated_at')
//		           ->orWhere('created_at', '<', Carbon::now()->subDay());
//	}
//
//	public function scopeValidos($query)
//	{
////        return $query->where(function ($q) {
////            $q->whereNotNull('validated_at')
////                ->orWhere('created_at', '<', Carbon::now()->subDay());
////        });
//		return $query->whereNotNull('validated_at');
//	}
//
//
//
////    public function setPrazoPagamentoTecnicaAttribute($value)
////    {
////        return json_encode($value);
////    }
////    public function setPrazoPagamentoComercialAttribute($value)
////    {
////        return json_encode($value);
////    }
//
//	public function updatePrazo($dataUpdate)
//	{
//		foreach (['tecnica', 'comercial'] as $tipo) {
//			$prazo_pagamento['id'] = $dataUpdate['prazo_pagamento_' . $tipo];
//			switch ($dataUpdate['prazo_pagamento_' . $tipo]) {
//				case PrazoPagamento::_STATUS_A_VISTA_:
//					$prazo_pagamento['extras'] = '';
//					break;
//				case PrazoPagamento::_STATUS_PARCELADO_:
//					$prazo_pagamento['extras'] = $dataUpdate['parcela_' . $tipo];
//					break;
//			}
//			$this->{'prazo_pagamento_' . $tipo} = json_encode($prazo_pagamento);
//		}
//		$this->save();
//
//	}
//
//	public function getPrazoPagamentoTecnicaAttribute($value)
//	{
//		return json_decode($value);
//	}
//
//	public function getPrazoPagamentoComercialAttribute($value)
//	{
//		return json_decode($value);
//	}
//
//	public function getCreatedAtAttribute($value)
//	{
//		return DataHelper::getPrettyDateTime($value);
//	}
//
//	public function getEnderecoResumido() {
//		$contato = $this->contato()->first();
//		$retorno[0] = $contato->cidade;
//		$retorno[1] = $contato->estado;
//		return $retorno;
//	}
//
//	public function contato()
//	{
//		return $this->hasOne('App\Contato', 'idcontato', 'idcontato');
//	}
//
//	public function getEndereco() {
//		$contato = $this->contato()->first();
//		$retorno[0] = $contato->cidade;
//		$retorno[1] = $contato->estado;
//		return implode(" / ",$retorno);
//	}
//
//	public function getFones() {
//		$contato = $this->contato()->first();
//		$retorno[0] = $contato->telefone;
//		$retorno[1] = $contato->celular;
//		return implode(" / ",$retorno);
//	}
//
//	public function is_pjuridica()
//	{
//		return ($this->attributes['idpjuridica'] != NULL);
//	}
//
//	public function getType()
//	{
//		if ($this->attributes['idpjuridica'] != NULL) {
//			$retorno = (object)[
//				'idcliente' => $this->idcliente,
//				'tipo_cliente' => 1,
//				'tipo' => 'CNPJ',
//				'entidade' => $this->pessoa_juridica()->first()->cnpj,
//				'nome_principal' => $this->pessoa_juridica()->first()->nome_fantasia,
//				'razao_social' => $this->pessoa_juridica()->first()->razao_social,
//				'ie' => $this->pessoa_juridica()->first()->ie,
//				'documento' => 'CNPJ: ' . $this->pessoa_juridica()->first()->cnpj,
//			];
//		} else {
//			$retorno = (object)[
//				'idcliente' => $this->idcliente,
//				'tipo_cliente' => 0,
//				'tipo' => 'CPF',
//				'entidade' => $this->pessoa_fisica()->first()->cpf,
//				'nome_principal' => $this->attributes['nome_responsavel'],
//				'razao_social' => $this->attributes['nome_responsavel'],
//				'ie' => '-',
//				'documento' => 'CPF: ' . $this->pessoa_fisica()->first()->cpf,
//			];
//		}
//
//
//		return $retorno;
//	}
//
//	//Mutattors
//
//	public function getURLFoto()
//	{
//		return ($this->attributes['foto'] != '') ? asset('uploads/' . $this->table . '/thumb_' . $this->attributes['foto']) : asset('imgs/user.png');
//	}
//
//	public function getLimiteCreditoTecnicaAttribute($value)
//	{
//		return DataHelper::getFloat2Real($value);
//	}
//
//	public function getLimiteCreditoComercialAttribute($value)
//	{
//		return DataHelper::getFloat2Real($value);
//	}
//
//	public function validado()
//	{
//		//testa se o cadastro foi validado
//		return (($this->attributes['idcolaborador_validador'] != NULL) && ($this->attributes['validated_at'] != NULL));
//	}
//
//	public function cadastro_invalido()
//	{
//		//testa se o cadastro é inválido a mais de 24h
//		if ($this->attributes['validated_at'] == NULL) {
//			return true;
//		}
//		$now = Carbon::now();
//		$created_at = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at']);
//		return ($created_at->diffInHours($now) > 24);
//	}
//
//	public function criado_em()
//	{
//		$criacao = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at']);
//		return $criacao->diffForHumans(Carbon::now());
////        return Carbon::now()->diffForHumans(Carbon::createFromFormat('Y-m-d H:i:s',$this->attributes['created_at']));
//	}
//
//	public function setDistanciaAttribute($value)
//	{
//		$this->attributes['distancia'] = DataHelper::getReal2Float($value);
//	}
//
//	public function getDistanciaAttribute($value)
//	{
//		return DataHelper::getFloat2Real($value);
//	}
//
////    public function setPedagiosAttribute($value)
////    {
////	    $this->attributes['pedagios'] = DataHelper::getReal2Float($value);
////    }
//
//	public function getPedagiosAttribute($value)
//	{
//		return DataHelper::getFloat2Real($value);
//	}
//
//	// ******************** RELASHIONSHIP ******************************
//	// ************************** HAS **********************************
//
//	public function getOutrosCustosAttribute($value)
//	{
//		return DataHelper::getFloat2Real($value);
//	}
//
//	public function has_instrumento()
//	{
//		return ($this->instrumentos()->count() > 0);
//	}
//
//	public function instrumentos()
//	{
//		return $this->hasMany('App\Instrumento', 'idcliente');
//	}
//
//	public function has_equipamento()
//	{
//		return ($this->equipamentos()->count() > 0);
//	}
//
//	public function equipamentos()
//	{
//		return $this->hasMany('App\Equipamento', 'idcliente');
//	}
//
//	public function has_ordem_servicos()
//	{
//		return ($this->ordem_servicos()->count() > 0);
//	}
//
//	public function ordem_servicos()
//	{
//		return $this->hasMany('App\OrdemServico', 'idcliente');
//	}
//
//	public function ordem_servicos_centro_custo()
//	{
//		return $this->hasMany(OrdemServico::class, 'idcentro_custo', 'idcliente');
//	}
//	// ********************** BELONGS ********************************
//
//	public function segmento()
//	{
//		return $this->hasOne('App\Models\Settings\RecursosHumanos\Clientes\Segmento', 'idsegmento', 'idsegmento');
//	}
//
//	public function tabela_preco_tecnica()
//	{
//		return $this->belongsTo('App\TabelaPreco', 'idtabela_preco_tecnica');
//	}
//
//	public function tipo_emissao_tecnica()
//	{
//		return $this->belongsTo(TipoEmissaoFaturamento::class, 'idemissao_tecnica');
//	}
//
//	public function forma_pagamento_tecnica()
//	{
//		return $this->belongsTo(FormaPagamento::class, 'idforma_pagamento_tecnica');
//	}
//
//	public function tabela_preco_comercial()
//	{
//		return $this->belongsTo('App\TabelaPreco', 'idtabela_preco_comercial');
//	}
//
//	public function tipo_emissao_comercial()
//	{
//		return $this->belongsTo(TipoEmissaoFaturamento::class, 'idemissao_comercial');
//	}
//
//	public function forma_pagamento_comercial()
//	{
//		return $this->belongsTo(FormaPagamento::class, 'idforma_pagamento_comercial');
//	}
//
//
//	// ************************** HASMANY **********************************
//
//
//	public function pessoa_juridica()
//	{
//		return $this->hasOne('App\PessoaJuridica', 'idpjuridica', 'idpjuridica');
//	}
//
//	public function pessoa_fisica()
//	{
//		return $this->hasOne('App\PessoaFisica', 'idpfisica', 'idpfisica');
//	}
//
//	public function centro_custo_de() //quem é o centro de custo do cliente
//	{
//		return $this->belongsTo(Cliente::class, 'idcliente_centro_custo','idcliente');
//	}
//
//
//	public function centro_custo_para($client_id = NULL) //listagens para quem o cliente é centro de custo
//	{
//		$query = $this->hasMany(Cliente::class, 'idcliente_centro_custo','idcliente');
//		if($client_id != NULL) $query->where('idcliente', '!=',$client_id);
//		return $query->get();
//	}
//
//	public function faturamento()
//	{
//		return $this->hasMany('App\Models\Faturamento', 'idcliente');
//	}
}
