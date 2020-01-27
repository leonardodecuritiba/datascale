<?php

namespace App\Models\Parts;

use App\Helpers\DataHelper;
use App\Models\HumanResources\Provider;
use App\Models\Parts\Settings\Brand;
use App\Models\Parts\Settings\Group;
use App\Models\Parts\Settings\Ncm;
use App\Models\Transactions\Settings\ApparatuService;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\Relashionships\PictureTrait;
use App\Traits\StringTrait;
use App\Traits\TaxationPartTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    use DateTimeTrait;
    use StringTrait;
    use ActiveTrait;
    public $timestamps = true;

    protected $fillable = [
        'group_id',
        'unity_id',
        'name',
        'description',
        'value',

	    'idservico',
    ];

    protected $appends = [
        'created_at_time','created_at_formatted',

        'unity_text',
        'value_formatted',

    ];

    //============================================================
    //======================== FUNCTIONS =========================
    //============================================================
    public function getName()
    {
        return $this->getAttribute('name');
    }

    public function getGroupName()
    {
        return optional($this->group)->getName();
    }

    public function getContent()
    {
        return $this->getAttribute('description');
    }

    public function getShortDescriptions()
    {
        return $this->getAttribute('description');
    }

    //============================================================
    //======================== ACCESSORS =========================
    //============================================================

    public function getValueFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('value'));
    }
    public function getUnityTextAttribute()
    {
        return config('variables.unities.' . $this->getAttribute('unity_id'));
    }


    //============================================================
    //======================== MUTATORS ==========================
    //============================================================

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = DataHelper::getReal2Float($value);
    }


    //============================================================
    //======================== SCOPES ============================
    //============================================================


    //============================================================
    //======================== RELASHIONSHIP =====================
    //============================================================
	//======================== FUNCTIONS =========================
	/*
	public function tabela_preco_by_name($value)
	{
		$id = TabelaPreco::where('descricao', $value)->pluck('idtabela_preco');
		return $this->hasMany('App\TabelaPrecoServico', 'idservico')
			->where('idtabela_preco', $id)
			->first();
	}
	*/
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
	public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

	//======================== HASMANY ===========================
	public function prices()
	{
		return $this->hasMany(ServicePrice::class, 'service_id');
	}

	public function apparatu_services()
	{
		return $this->hasMany(ApparatuService::class, 'service_id');
	}



}
