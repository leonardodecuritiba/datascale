<?php

namespace App\Providers;

use App\Models\Commons\Voidx;
use App\Models\HumanResources\Client;
use App\Models\HumanResources\Provider;
use App\Models\HumanResources\Settings\Region;
use App\Models\HumanResources\Settings\Segment;
use App\Models\Inputs\Equipment;
use App\Models\Inputs\Instruments\Instrument;
use App\Models\Inputs\Instruments\InstrumentBrand;
use App\Models\Inputs\Instruments\InstrumentModel;
use App\Models\Inputs\Instruments\InstrumentSetor;
use App\Models\Inputs\Settings\Label;
use App\Models\Inputs\Settings\LabelInstrument;
use App\Models\Inputs\Settings\Seal;
use App\Models\Inputs\Settings\SealInstrument;
use App\Models\Ipem\Certificate;
use App\Models\Ipem\Pam;
use App\Models\Ipem\Pattern;
use App\Models\Requests\RequestPattern;
use App\Models\Ipem\Settings\CertificatePattern;
use App\Models\Ipem\Settings\PatternVoid;
use App\Models\Requests\Settings\RequestPatternItem;
use App\Models\Parts\Part;
use App\Models\Parts\Price;
use App\Models\Parts\Service;
use App\Models\Parts\Settings\Brand;
use App\Models\Parts\Settings\Group;
use App\Models\Parts\Settings\Ncm;
use App\Models\Transactions\Apparatu;
use App\Models\Financials\Billing;
use App\Models\Transactions\Order;
use App\Models\Financials\Payment;
use App\Models\Transactions\Settings\ApparatuPart;
use App\Models\Transactions\Settings\ApparatuService;
use App\Models\Users\User;
use App\Observers\Financials\BillingObserver;
use App\Observers\Financials\PaymentObserver;
use App\Observers\HumanResources\ClientObserver;
use App\Observers\HumanResources\ProviderObserver;
use App\Observers\HumanResources\Settings\RegionObserver;
use App\Observers\HumanResources\Settings\SegmentObserver;
use App\Observers\Inputs\Settings\LabelInstrumentObserver;
use App\Observers\Inputs\Settings\LabelObserver;
use App\Observers\Inputs\Settings\SealInstrumentObserver;
use App\Observers\Inputs\Settings\SealObserver;
use App\Observers\Ipem\CertificateObserver;
use App\Observers\Ipem\PamObserver;
use App\Observers\Ipem\PatternObserver;
use App\Observers\Requests\RequestPatternObserver;
use App\Observers\Ipem\Settings\CertificatePatternObserver;
use App\Observers\Ipem\Settings\PatternVoidObserver;
use App\Observers\Requests\Settings\RequestPatternItemObserver;
use App\Observers\Ipem\VoidxObserver;
use App\Observers\Parts\Settings\BrandObserver;
use App\Observers\Parts\Settings\EquipmentObserver;
use App\Observers\Parts\Settings\GroupObserver;
use App\Observers\Parts\Settings\InstrumentBrandObserver;
use App\Observers\Parts\Settings\InstrumentModelObserver;
use App\Observers\Parts\Settings\InstrumentObserver;
use App\Observers\Parts\Settings\InstrumentSetorObserver;
use App\Observers\Parts\Settings\NcmObserver;
use App\Observers\Parts\Settings\PartObserver;
use App\Observers\Parts\Settings\PriceObserver;
use App\Observers\Parts\Settings\ServiceObserver;
use App\Observers\Transactions\ApparatuObserver;
use App\Observers\Transactions\ApparatuPartObserver;
use App\Observers\Transactions\ApparatuServiceObserver;
use App\Observers\Transactions\OrderObserver;
use App\Observers\Users\UserObserver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Faker\Generator as FakerGenerator;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		Schema::defaultStringLength(191);

		User::observe( UserObserver::class );

		Segment::observe( SegmentObserver::class );
		Provider::observe( ProviderObserver::class );

		Ncm::observe( NcmObserver::class );
		Brand::observe( BrandObserver::class );
		Group::observe( GroupObserver::class );
		Part::observe( PartObserver::class );
		Service::observe( ServiceObserver::class );
		Price::observe( PriceObserver::class );

		Region::observe( RegionObserver::class );

		Client::observe( ClientObserver::class );

		Equipment::observe( EquipmentObserver::class );
		InstrumentBrand::observe( InstrumentBrandObserver::class );
		InstrumentModel::observe( InstrumentModelObserver::class );
		Pam::observe( PamObserver::class );
		InstrumentSetor::observe( InstrumentSetorObserver::class );
		Instrument::observe( InstrumentObserver::class );

		Payment::observe( PaymentObserver::class );
		Billing::observe( BillingObserver::class );
		Order::observe( OrderObserver::class );
		Apparatu::observe( ApparatuObserver::class );
		Seal::observe( SealObserver::class );
		Label::observe( LabelObserver::class );
		SealInstrument::observe( SealInstrumentObserver::class );
		LabelInstrument::observe( LabelInstrumentObserver::class );

		ApparatuService::observe( ApparatuServiceObserver::class );
		ApparatuPart::observe( ApparatuPartObserver::class );

		Certificate::observe( CertificateObserver::class );
		Pattern::observe( PatternObserver::class );
		Voidx::observe( VoidxObserver::class );

		CertificatePattern::observe( CertificatePatternObserver::class );
		PatternVoid::observe( PatternVoidObserver::class );

		RequestPattern::observe( RequestPatternObserver::class );
		RequestPatternItem::observe( RequestPatternItemObserver::class );

		// =====================================================================
		// =====================================================================
		// =====================================================================


		Validator::extend('unique_client', function ($attribute, $value, $parameters, $validator) {
			// Get the parameters passed to the rule
			// Check the table and return true only if there are no entries matching
			// both the first field name and the user input value as well as
			// the second field name and the second field value
			if (count($parameters) > 4) {
				list($table, $field, $field2, $field2Value, $field_not, $field_notValue) = $parameters;

				return DB::table($table)
					       ->where($field, $value)
					       ->where($field2, $field2Value)
					       ->where($field_not, '<>', $field_notValue)
					       ->count() == 0;
			} else {
				list($table, $field, $field2, $field2Value) = $parameters;

				return DB::table($table)
					       ->where($field, $value)
					       ->where($field2, $field2Value)
					       ->count() == 0;

			}

		});
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->singleton( FakerGenerator::class, function () {
			return FakerFactory::create( 'pt_BR' );
		} );
	}
}
