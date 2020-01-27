<?php

namespace App\Models\HumanResources;

use App\Helpers\DataHelper;
use App\Models\HumanResources\Settings\Address;
use App\Models\HumanResources\Settings\Contact;
use App\Models\HumanResources\Settings\FisicalPerson;
use App\Models\HumanResources\Settings\LegalPerson;
use App\Models\HumanResources\Settings\Segment;
use App\Models\Parts\Part;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Relashionships\PictureTrait;

class Provider extends Model
{
	use SoftDeletes;
    use DateTimeTrait;
    use StringTrait;
    use ActiveTrait;
    use PictureTrait;
	public $timestamps = true;
	static public $img_path = 'providers';
	protected $fillable = [
		'address_id',
		'contact_id',
		'segment_id',
		'picture_id',

		'legal_person_id',
		'budget_email',
		'group',
		'responsible_name',
		'cpf',
		'active',


		'idfornecedor',
	];

	protected $appends = [
		'cpf_formatted',
		'type_name_text',
		'short_description'
	];

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

	public function getShortDescriptionAttribute()
	{
        return $this->isLegalPerson() ? $this->legal_person->fantasy_name : $this->getAttribute('responsible_name');
	}

	public function getTypeNameTextAttribute()
	{
		return $this->isLegalPerson() ? 'Pessoa Jurídica' : 'Pessoa Física';
	}

	public function getCpfFormattedAttribute()
	{
		return DataHelper::mask($this->getAttribute('cpf'), '###.###.###-##');
	}

	//============================================================
	//======================== MUTATORS ==========================
	//============================================================
//	public function setCpfAttribute($value)
//	{
//		return DataHelper::getOnlyNumbers($value);
//	}

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

	// ********************** BELONGS ****************************
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

	public function parts()
	{
		return $this->hasMany(Part::class, 'provider_id');
	}
}
