<?php
/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
|
Route::get('getSelosDisponiveis', 'AjaxController@getSelosDisponiveis')->name('getAvailableLabels');
Route::get('getLacresDisponiveis', 'AjaxController@getLacresDisponiveis')->name('getLacresDisponiveis');
*/
Route::get( 'state-city', 'AjaxController@getStateCityToSelect' )->name( 'ajax.get.state-city' );
Route::get( 'set-active', 'AjaxController@setActive' )->name( 'ajax.set.active' );

Route::get( 'get-available-labels', 'AjaxController@getAvailableLabels' )->name( 'ajax.get.available-labels' );
Route::get( 'get-available-seals', 'AjaxController@getAvailableSeals' )->name( 'ajax.get.available-seals' );
Route::get( 'get-available-voids', 'AjaxController@getAvailableVoids' )->name( 'ajax.get.available-voids' );
Route::get( 'get-available-patterns', 'AjaxController@getAvailablePatterns' )->name( 'ajax.get.available-patterns' );
/*
|--------------------------------------------------------------------------
| INPUTS Routes
|--------------------------------------------------------------------------
|
*/
Route::namespace('Inputs')->middleware('auth')->prefix('settings')->group( function () {
//	Route::resource('instruments', 'Instruments\InstrumentController');
//	Route::resource('equipments', 'EquipmentController');
    Route::group( [ 'prefix' => 'equipments' ], function () {
        Route::get('values', 'EquipmentController@show')->name( 'ajax.equipments.values' );
    });
    Route::namespace('Instruments')->prefix( 'instruments')->group( function () {
        Route::get('values', 'InstrumentController@show')->name( 'ajax.instruments.values' );
    });
});

/*
|--------------------------------------------------------------------------
| OPERAÇÕES Routes
|--------------------------------------------------------------------------
|
*/
Route::namespace('Transactions')->middleware('auth')->prefix('transactions')->group( function () {

	Route::group( [ 'prefix' => 'orders' ], function () {

		Route::get('values/{order}', 'OrderController@values')->name('ajax.orders.values');
		Route::post('add-input/{apparatu}', 'OrderController@addInput')->name('ajax.orders.add-input');

		Route::delete('rem-input/{apparatu}', 'OrderController@removeInput')->name('ajax.orders.rem-input');


		Route::get('show-input/{apparatu}', 'OrderController@showInput')->name('ajax.orders.show-input');
		Route::post('save-input', 'OrderController@saveInput')->name('ajax.orders.save-input');

		Route::delete('rem-apparatu/{order}', 'OrderController@removeApparatu')->name('ajax.orders.rem-apparatu');
//		Route::get('rem-apparatu/{order}', 'OrderController@removeApparatu')->name('ajax.orders.rem-apparatu');

	} );
});

/*
|--------------------------------------------------------------------------
| OPERAÇÕES Routes
|--------------------------------------------------------------------------
|
*/
Route::namespace('HumanResources')->middleware('auth')->prefix('human_resources')->group( function () {

	Route::get('show/{client}', 'ClientController@show')->name('ajax.clients.show');

	Route::post( 'read-notification/{id}', 'NotificationController@read' )->name( 'ajax.human_resources.notification.read' );
	Route::post( 'read-all-notification', 'NotificationController@readAll' )->name( 'ajax.human_resources.notification.read-all' );

});