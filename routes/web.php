<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group( [ 'prefix' => 'teste' ], function () {


	Route::get('teste-email', function () {
		$mensagem = 'olá leonardo';
		Mail::raw($mensagem, function ($message) {
			$message->to('silva.zanin@gmail.com', 'Leonardo')->subject('Contato Pelo Site!');
		});
	})->name('send-contact');

} );

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
*/
Auth::routes();

Route::group( [ 'prefix' => 'admin', 'middleware' => 'auth' ], function () {
    Route::post( 'password-change', 'Commons\CommonController@updatePassword' )->name( 'change.password' );
} );


Route::get('/', 'HomeController@index')->name('index');
Route::get( '/home', function () {
	return \Illuminate\Support\Facades\Redirect::route( 'index' );
} );
//Route::group( [ 'prefix' => 'admin', 'middleware' => [ 'role:admin' ] ], function () {
/*
|--------------------------------------------------------------------------
| INTELIGÊNCIA Routes
|--------------------------------------------------------------------------
|
*/
Route::group( [ 'prefix' => 'intelligence', 'middleware' => 'auth' ], function () {
	Route::get('goals', 'HomeController@goals')->name('goals');
	Route::get('banking_operations', 'HomeController@banking_operations')->name('banking_operations');
	Route::get('graphs', 'HomeController@graphs')->name('graphs');
	Route::get('payments', 'HomeController@payments')->name('payments');
	Route::get('reports', 'HomeController@reports')->name('reports');
} );

/*
|--------------------------------------------------------------------------
| COMUNICAÇÃO Routes
|--------------------------------------------------------------------------
|
*/
Route::group( [ 'prefix' => 'communication', 'middleware' => 'auth' ], function () {
    Route::get('schedules', 'HomeController@schedules')->name('schedules');
    Route::get('notices', 'HomeController@notices')->name('notices');
    Route::get('notifications', 'HomeController@notifications')->name('notifications');
    Route::get('calls', 'HomeController@calls')->name('calls');
} );

/*
|--------------------------------------------------------------------------
| FINANCEIRO Routes
|--------------------------------------------------------------------------
|
*/
Route::group( [ 'prefix' => 'financial', 'middleware' => 'auth' ], function () {
	Route::get('bank_charges', 'HomeController@bank_charges')->name('bank_charges');
	Route::get('bank_apis', 'HomeController@bank_apis')->name('bank_apis');
	Route::get('banks', 'HomeController@banks')->name('banks');
    Route::get('fiscals', 'HomeController@fiscals')->name('fiscals');

	Route::get('franchisees_billings', 'HomeController@franchiseesBillings')->name('billings.franchisees');



	Route::namespace('Financials')->group( function () {


		Route::namespace('Fiscals')->prefix('fiscals')->group( function () {

			Route::get('nf/{billing_id}/{debug}/{type}', 'FiscalController@sendNF')->name('fiscals.nf.send');
			Route::post('cancel-nf/{billing_id}/{debug}/{type}', 'FiscalController@cancelNF')->name('fiscals.nf.cancel');
			Route::get('resend-nf/{billing_id}/{debug}/{type}', 'FiscalController@resendNF')->name('fiscals.nf.resend');
			Route::get('nf/consulta/{billing_id}/{debug}/{type}', 'FiscalController@getNF')->name('fiscals.nf.get');
			Route::post('nf/send/email/{type}', 'FiscalController@sendEmail')->name('fiscals.nf.send-email');


//			//NOTAS FISCAIS
//			Route::get('listar-notas-fiscais/{tipo}', 'FiscalController@index')->name('notas_fiscais.index');


		} );

		Route::group( [ 'prefix' => 'clients' ], function () {
			Route::get('clients/report', 'BillingController@report')->name('billings.clients.report');
			Route::get('billings', 'BillingController@index')->name('billings.clients.index');
			Route::get('billings-cost_center', 'BillingController@cost_center')->name('billings.clients.cost_center');
			Route::get('billings/{billing}', 'BillingController@show')->name('billings.clients.show');
			Route::get('billings/closing/{client}/{cost_center}', 'BillingController@showClosing')->name('billings.closing.show');
			Route::get('billings/{billing}/delete', 'BillingController@destroy')->name('billings.destroy');
			Route::get('billings/{billing}/close', 'BillingController@close')->name('billings.close');

            Route::get('billings/bill/{client}/{cost_center}', 'BillingController@bill')->name('billings.bill');

			Route::post('portion/set', 'BillingController@setPortion')->name('billings.set.portion');

//			Route::resource('billings', 'BillingController');

		} );
	} );


    Route::namespace('Parts')->group( function () {

        Route::resource('prices', 'PriceController');

        Route::get('prices/{id}/parts', 'PriceController@part_price')->name('prices.parts');
        Route::post('part_price/update', 'PartPriceController@update')->name('prices.parts.update');

        Route::get('prices/{id}/services', 'PriceController@service_price')->name('prices.services');
        Route::post('service_price/update', 'PartPriceController@update')->name('prices.services.update');

    } );

    Route::get('stock_values', 'HomeController@stock_values')->name('stock_values');


} );

/*
|--------------------------------------------------------------------------
| IPEM Routes
|--------------------------------------------------------------------------
|
*/
Route::group( [ 'prefix' => 'ipem', 'middleware' => 'auth' ], function () {
    Route::get('technical_capacity', 'HomeController@technical_capacity')->name('technical_capacity');


	Route::group( [ 'namespace' => 'Ipem' ], function () {

		Route::resource('pams', 'PamController');
		/*
		|--------------------------------------------------------------------------
		| Certificates Routes
		|--------------------------------------------------------------------------
		|
		*/
		Route::resource( 'certificates', 'CertificateController' );
		Route::patch( 'certificates/{certificate}/attach-pattern', 'CertificateController@attachPattern' )->name( 'certificates.attach-pattern' );
		Route::delete( 'certificates/{certificate}/{certificate_pattern}/detach-pattern', 'CertificateController@detachPattern' )->name( 'certificates.detach-pattern' );
		Route::get( 'certificates/requests/recreate', 'CertificateController@recreate' )->name( 'certificates.recreate' );
		Route::get( 'certificates/requests/tracking', 'CertificateController@requests' )->name( 'certificates.requests' );

		/*
		|--------------------------------------------------------------------------
		| Labels Routes
		|--------------------------------------------------------------------------
		|
		*/
		Route::resource('labels', 'LabelController');
		Route::get('labels/requests/tracking', 'LabelController@tracking')->name('labels.tracking');
		Route::post('labels/requests/deny', 'LabelController@deny')->name('labels.tracking.deny');
		Route::post('labels/requests/accept', 'LabelController@accept')->name('labels.tracking.accept');

		/*
		|--------------------------------------------------------------------------
		| Seals Routes
		|--------------------------------------------------------------------------
		|
		*/
		Route::resource('seals', 'SealController');
		Route::get('seals/requests/tracking', 'SealController@tracking')->name('seals.tracking');
		Route::post('seals/requests/deny', 'SealController@deny')->name('seals.tracking.deny');
		Route::post('seals/requests/accept', 'SealController@accept')->name('seals.tracking.accept');


		/*
		|--------------------------------------------------------------------------
		| Labels Routes
		|--------------------------------------------------------------------------
		|
		|
		*/
		//    Route::post('selolacre/{idtecnico}', 'ColaboradoresController@selolacre_store')->name('selolacre.store');
		//    Route::post('selolacre-remanejar/{idtecnico}', 'ColaboradoresController@selolacre_remanejar')->name('selolacre.remanejar');

		Route::resource('selolacres', 'SeloLacreController');
		Route::post('lancar-selos', 'SeloLacreController@lancarSelos')->name('selolacres.lancar_selos');
		Route::post('lancar-lacres', 'SeloLacreController@lancarLacres')->name('selolacres.lancar_lacres');

		//REQUISIÇÕES
		Route::get('selolacres-requisicoes', 'SeloLacreController@listRequests')->name('selolacres.requisicoes');
		Route::get('selolacres-relatorios', 'SeloLacreController@getReports')->name('selolacres.relatorio');

		//REQUISIÇÕES - ADMIM
		Route::get('selolacres-listagem', 'SeloLacreController@index')->name('selolacres.listagem');
		Route::post('selolacres-repasse', 'SeloLacreController@postFormPassRequest')->name('selolacres.repasse');
		Route::post('selolacres-negar', 'SeloLacreController@deniedRequest')->name('selolacres.deny');















	} );

	Route::get('bulks', 'HomeController@bulks')->name('bulks');
	Route::get( 'inspections', 'HomeController@inspections' )->name( 'inspections.index' );

} );

/*
|--------------------------------------------------------------------------
| AJUSTES DE COMPLEMENTOS Routes
|--------------------------------------------------------------------------
|
*/
Route::group( [ 'namespace' => 'Parts\Settings','prefix' => 'settings', 'middleware' => 'auth' ], function () {

    Route::resource('brands', 'BrandController');
    Route::resource('ncms', 'NcmController');
    Route::resource('groups', 'GroupController');

} );
Route::group( [ 'namespace' => 'HumanResources\Settings','prefix' => 'settings', 'middleware' => 'auth' ], function () {

    Route::resource( 'regions', 'RegionController' );
    Route::resource( 'segments', 'SegmentController' );

} );
/*
|--------------------------------------------------------------------------
| INPUTS Routes
|--------------------------------------------------------------------------
|
*/
Route::namespace('Inputs')->middleware('auth')->prefix('settings')->group( function () {

	Route::group( [ 'prefix' => 'equipments' ], function () {
		Route::post('store', 'EquipmentController@store')->name( 'equipments.store' );
		Route::post('update', 'EquipmentController@update')->name( 'equipments.update' );
	});
	Route::namespace('Instruments')->prefix( 'instruments')->group( function () {
		Route::post('store', 'InstrumentController@store')->name( 'instruments.store' );
		Route::post('update', 'InstrumentController@update')->name( 'instruments.update' );
	});
});

/*
|--------------------------------------------------------------------------
| RH Routes
|--------------------------------------------------------------------------
|
*/
Route::group( [ 'namespace' => 'HumanResources','prefix' => 'human_resources', 'middleware' => 'auth' ], function () {

    Route::resource('providers', 'ProviderController');
    Route::resource('clients', 'ClientController');

	/*
	|--------------------------------------------------------------------------
	| Roles Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::get('roles', 'HomeController@roles')->name('roles.index');
	/*
	|--------------------------------------------------------------------------
	| User Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::resource( 'users', 'UserController' );
	Route::get( 'my-profile', 'UserController@profile' )->name( 'admin.profile.my' );

	/*
	|--------------------------------------------------------------------------
	| Notification Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::resource( 'notifications', 'NotificationController' );
} );

/*
|--------------------------------------------------------------------------
| OPERAÇÕES Routes
|--------------------------------------------------------------------------
|
*/
Route::group( ['prefix' => 'admin', 'middleware' => 'auth' ], function () {


    Route::get('technical_operations', 'HomeController@technical_operations')->name('technical_operations');
    Route::get('comercial_operations', 'HomeController@comercial_operations')->name('comercial_operations');

	Route::group( [ 'namespace' => 'Transactions','prefix' => 'transactions' ], function () {

		Route::get('ordem_servicos/{idordem_servico}', 'OrderController@oldShow');

		Route::resource('orders', 'OrderController');

		Route::group( [ 'prefix' => 'orders' ], function () {

			Route::post('open', 'OrderController@open')->name('transactions.orders.open');

            Route::get('resume/{order}', 'OrderController@resume')->name('transactions.orders.resume');
            Route::get('print/{order}', 'OrderController@print')->name('transactions.orders.print');
            Route::get('send/{order}', 'OrderController@send')->name('transactions.orders.send');
            Route::post('finish/{order}', 'OrderController@finish')->name('transactions.orders.finish');
            Route::get('reopen/{order}', 'OrderController@reopen')->name('transactions.orders.reopen');


            Route::post('add_apparatu/{order_id}', 'ApparatuController@addApparatu')->name('transactions.orders.add_apparatu');
            Route::resource('apparatus', 'ApparatuController');

        } );

	} );

} );


/*
|--------------------------------------------------------------------------
| PEÇAS - PRODUTOS - SERVIÇOS Routes
|--------------------------------------------------------------------------
|
*/
Route::namespace('Parts')->middleware('auth')->prefix('parts')->group( function () {
    Route::resource('parts', 'PartController');
    Route::resource('services', 'ServiceController');

    Route::get('stocks', 'HomeController@stocks')->name('stocks');
    Route::get('item_tables', 'HomeController@item_tables')->name('item_tables');
} );


/*
|--------------------------------------------------------------------------
| REQUISIÇÕES Routes
|--------------------------------------------------------------------------
|
*/
Route::namespace('Requestions')->middleware('auth')->prefix('requestions')->group( function () {

    Route::get('parts', 'HomeController@parts')->name('requestions.parts');
    Route::get('main_provider', 'HomeController@main_provider')->name('requestions.main_provider');
    Route::get('products', 'HomeController@products')->name('requestions.products');

	Route::get( 'patterns/index', 'RequestPatternController@index' )->name( 'requestions.patterns.index' );
	Route::get( 'patterns/create-by-due', 'RequestPatternController@createByDue' )->name( 'requestions.patterns.create-by-due' );
	Route::get( 'patterns/create-by-buy', 'RequestPatternController@createByBuy' )->name( 'requestions.patterns.create-by-buy' );
	Route::get( 'patterns/create-by-degradation', 'RequestPatternController@createByDegradation' )->name( 'requestions.patterns.create-by-degradation' );
	Route::get( 'patterns/create-by-entity', 'RequestPatternController@createByEntity' )->name( 'requestions.patterns.create-by-entity' );
	Route::get( 'patterns/{requestion_pattern_id}/edit', 'RequestPatternController@edit' )->name( 'requestions.patterns.edit' );

    Route::patch( 'patterns/{requestion_pattern}/attach-pattern', 'RequestPatternController@attachPattern' )->name( 'patterns.attach-pattern' );
    Route::delete( 'patterns/{requestion_pattern}/{requestion_pattern_item}/detach-pattern', 'RequestPatternController@detachPattern' )->name( 'patterns.detach-pattern' );


    Route::post( 'patterns/store', 'RequestPatternController@store' )->name( 'requestions.patterns.store' );
    Route::patch( 'patterns/update', 'RequestPatternController@update' )->name( 'requestions.patterns.update' );






	Route::get( 'labels/create', 'LabelController@create' )->name( 'requestions.labels.create' );
	Route::get( 'seals/create', 'SealController@create' )->name( 'requestions.seals.create' );


	//REQUISIÇÕES -TÉCNICO
//	Route::get('selolacres-requisicao', 'SeloLacreController@getFormRequest')->name('selolacres.requisicao');
//	Route::post('selolacres-requerer', 'SeloLacreController@postFormRequest')->name('selolacres.requerer');


	Route::get( 'labels/create', 'LabelController@create' )->name( 'requestions.labels.create' );
	Route::post( 'labels/store', 'LabelController@store' )->name( 'requestions.labels.store' );

	Route::get( 'seals/create', 'SealController@create' )->name( 'requestions.seals.create' );
	Route::post( 'seals/store', 'SealController@store' )->name( 'requestions.seals.store' );

} );

/*
|--------------------------------------------------------------------------
| CONTROLE DE PATRIMONIO Routes
|--------------------------------------------------------------------------
|
*/
Route::namespace('Patrimonies')->middleware('auth')->prefix('patrimonies')->group( function () {

    Route::get('patterns', 'HomeController@patterns')->name('patrimonies.patterns');
    Route::get('parts', 'HomeController@parts')->name('patrimonies.parts');
    Route::get('products', 'HomeController@products')->name('patrimonies.products');
    Route::get('equipments', 'HomeController@equipments')->name('patrimonies.equipments');
    Route::get('tools', 'HomeController@tools')->name('patrimonies.tools');

} );

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| INPUTS Routes
|--------------------------------------------------------------------------
|
*/
Route::namespace('Inputs')->middleware('auth')->prefix('settings')->group( function () {
    Route::resource('instrument_brands', 'Instruments\InstrumentBrandController');
    Route::resource('instrument_setors', 'Instruments\InstrumentSetorController');
    Route::resource('instrument_models', 'Instruments\InstrumentModelController');
} );

