<?php

namespace App\Models\Parts;

use App\Helpers\DataHelper;
use App\Models\Commons\Picture;
use App\Models\HumanResources\Provider;
use App\Models\Parts\Settings\Brand;
use App\Models\Parts\Settings\Group;
use App\Models\Parts\Settings\Ncm;
use App\Models\Transactions\Settings\ApparatuPart;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\Relashionships\PictureTrait;
use App\Traits\StringTrait;
use App\Traits\TaxationPartTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Part extends Model
{
	use SoftDeletes;
	use TaxationPartTrait;
	use DateTimeTrait;
	use StringTrait;
	use ActiveTrait;
	use PictureTrait;
	public $timestamps = true;
	static public $img_path = 'parts';

	protected $fillable = [

		'provider_id',
		'brand_id',
		'group_id',
		'picture_id',

		'unity_id',
		'type',

		'auxiliar_code',
		'bar_code',
		'description',
		'technical_description',

		'sub_group',
		'warranty',


		//taxation
		'ncm_id',
		'cfop_id',
		'cst_id',
		'nature_operation_id',
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

        'technical_commission',
        'seller_commission',
		'valor_frete',
		'valor_seguro',
		'valor_total',


		'idpeca',

	];

	protected $appends = [
		'created_at_time','created_at_formatted',

		'type_text',
		'technical_commission_formatted',
		'seller_commission_formatted',

		//taxation
		'cfop_text',
		'cst_text',
		'unity_text',
		'nature_operation_text',

		'icms_base_calculo_formatted',
		'icms_valor_total_formatted',
		'icms_base_calculo_st_formatted',
		'icms_valor_total_st_formatted',

		'valor_unitario_comercial_formatted',
		'unidade_tributavel_formatted',
		'valor_unitario_tributavel_formatted',

		'valor_ipi_formatted',
		'valor_frete_formatted',
		'valor_seguro_formatted',
		'valor_total_formatted',

		'value',

	];

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================
	public function getName()
	{
		return $this->getAttribute('description');
	}

	public function getContent()
	{
		return $this->getAttribute('description');
	}

	public function getShortDescriptions()
	{
		return $this->getAttribute('description') . ' - ' . $this->getBrandName();
	}

	//============================================================
	//======================== ACCESSORS =========================
	//============================================================
	public function getValueAttribute()
	{
		return $this->attributes['valor_total'];
	}

	public function getTypeTextAttribute()
	{
		return ($this->attributes['type'] == 'part') ? 'Peça' : 'Produto';
	}

	public function getTechnicalCommissionFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->attributes['technical_commission']);
	}

	public function getSellerCommissionFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->attributes['seller_commission']);
	}


	//============================================================
	//======================== MUTATORS ==========================
	//============================================================

	public function setTypeAttribute($value)
	{
		$this->attributes['type'] = ($value == 'Part' || $value == 'part') ? 'part' : 'product';
	}

	public function setTechnicalCommissionAttribute($value)
	{
		$this->attributes['technical_commission'] = DataHelper::getPercent2Float($value);
	}

	public function setSellerCommissionAttribute($value)
	{
		$this->attributes['seller_commission'] = DataHelper::getPercent2Float($value);
	}

	//============================================================
	//======================== SCOPES ============================
	//============================================================

	/**
	 * Scope a query to only include inactive.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopePart($query)
	{
		return $query->where('type', 'part');
	}

	/**
	 * Scope a query to only include inactive.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeProduct($query)
	{
		return $query->where('type', 'product');
	}
	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

	//======================== FUNCTIONS =========================

	public function getProviderName()
	{
		return ($this->provider != NULL) ? $this->provider->getName() : NULL;
	}

	public function getBrandName()
	{
		return ($this->brand != NULL) ? $this->brand->getName() : NULL;
	}

	static public function client_prices($price_id)
	{
		return self::active()->get()->map( function ( $s ) use ($price_id) {
			$price = $s->client_table($price_id);
			return [
				'id'                => $s->id,
				'description'       => $s->getName(),
				'price'             => $price->price,
				'price_formatted'   => $price->price_formatted,
			];
		} );
	}

	public function client_table($price_id)
	{
		return $this->prices->where('price_id', $price_id)->first();
	}
	//======================== BELONGS ===========================

    public function ncm()
    {
        return $this->belongsTo(Ncm::class, 'ncm_id');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

	public function picture()
	{
		return $this->belongsTo(Picture::class, 'picture_id');
	}

	//======================== HASMANY ===========================

	public function prices()
	{
		return $this->hasMany(PartPrice::class, 'part_id');
	}

	public function apparatu_parts()
	{
		return $this->hasMany(ApparatuPart::class, 'part_id');
	}


	//======================== HASONE ============================

	/*
	public function tabela_preco_by_name($value)
	{
		$id = TabelaPreco::where('descricao', $value)->pluck('idtabela_preco');
		return $this->hasMany('App\TabelaPrecoPeca', 'idpeca')
		            ->where('idtabela_preco', $id)
		            ->first();
	}

	*/
}
