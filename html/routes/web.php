<?php

use App\Http\Controllers\CampaignsController;
use App\Models\Campaign;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// usuarios
Route::resource('users', 'UsersController');
Route::get('users/change-status/{user}', 'UsersController@changeStatus')->name('users.changeStatus');
Route::get('users/re-send-password/{user}', 'UsersController@reSendPassword')->name('users.reSendPassword');
Route::post('mi-perfil/update/{user}','ProfileController@update')->name('profile.update');
Route::get('mi-perfil','ProfileController@index')->name('profile.me');

// campañas
Route::resource('campaigns', 'CampaignsController');
Route::get('/campaigns/{campaign}/motor', 'CampaignsController@motor')->name('campaign.motor');
Route::get('/campaigns/{campaign}/getMonts', 'CampaignsController@getMonts')->name('campaign.getMonts');
Route::get('/campaigns/{campaign}/motor/expotToCSV', 'CampaignsController@expotToCSV')->name('campaign.motor-expotToCSV');

Route::get('/campaigns/{campaignMonth}/montChangeStatus/{status}', 'CampaignsController@montChangeStatus')->name('campaign.montChangeStatus');
Route::post('/campaigns/{campaign}/setCalendario/{month}', 'CampaignsController@setCalendario')->name('campaign.setCalendario');
Route::get('/campaigns/{campaign}/delete', 'CampaignsController@deleteCampaign')->name('campaign.delete');
Route::post('/campaigns/{campaign}/moveStatus', 'CampaignsController@campaigtnChangeStatus')->name('campaign.changeStatus');

/* facturas */
Route::get('downloadFacturas', 'FacturaslistadoController@downloadFacturas')->name('campaign.downloadFacturas');
Route::get('downloadGastos', 'FacturaslistadoController@downloadGastos')->name('campaign.downloadGastos');


// maestros
Route::resource('masters', 'MastersController');

//clientes
Route::resource('clients', 'ClientsController');
Route::get('clients/{client}/delete', 'ClientsController@deleteItem')->name('clients.deleteItem');

// Anunciantes
Route::resource('advertisers', 'AdvertisersController');
Route::get('advertisers/{advertiser}/delete', 'AdvertisersController@deleteItem');

// Influencers
Route::resource('influencers', 'InfluencersController');
Route::get('influencers/{influencer}/delete', 'InfluencersController@deleteItem');
Route::post('influencers/set-alert', "InfluencersController@setAlert")->name('influencers.setAlert');
Route::get('influencers/{influencer}/alerts',"InfluencersController@showMyAlerts")->name('influencers.alerts');
Route::get('influencers/{influencer}/alerts/create',"AlertController@create")->name('alerts.create');
Route::post('alerts/store',"AlertController@store")->name('alerts.store');
Route::get('alerts/{alert}/edit',"AlertController@edit")->name('alerts.edit');
Route::patch('alerts/{alert}/update',"AlertController@update")->name('alerts.update');
Route::delete('alerts/{alert}/delete',"AlertController@destroy")->name('alerts.destroy');

/*
    Dealers
*/
Route::resource('dealers', 'DealersController');
Route::get('dealers/{dealer}/delete', 'DealersController@deleteItem');
Route::post('dealers/set-alert', "DealersController@setAlert")->name('dealers.setAlert');

// Busgets
Route::resource('budgets', 'BudgetsController');


/**
 * PRODUCERS section
 */
Route::get('/producers/dashboard', 'ProducersController@dashboard')->name('producers.dashboard');
Route::get('/producers/campaign/resumen/{campaign}', 'ProducersController@campaign')->name('producers.resumen');
Route::post('/producers/campaign/bitacora/save', 'ProducersController@bitacoraSave')->name('producers.bitacorasave');
Route::get('/producers/campaign/marcar-cerrada/{campaign}', 'ProducersController@marcarCerrada')->name('producers.marcar-cerrada');
Route::post('/producers/campaign/update-image/{campaign}','ProducersController@updateImage')->name('producers.update-image');

Route::get('/producers/{campaign}/documentacion', 'ProducersDocumentsController@documentacion')->name('producers.documentacion');
Route::get('/producers/{campaign}/documentacion/agregar', 'ProducersDocumentsController@documentacionAdd')->name('producers.documentacion-add');
Route::post('/producers/{campaign}/documentacion/saveInfo', 'ProducersDocumentsController@documentacionSave')->name('producers.documentacion-save');
Route::get('/producers/{campaign}/documentacion/editInfo/{document}', 'ProducersDocumentsController@documentacionEdit')->name('producers.documentacion-edit');
Route::post('/producers/{campaign}/documentacion/editInfo/{document}', 'ProducersDocumentsController@documentacionUpdate')->name('producers.documentacion-update');
Route::get('/producers/{campaign}/documentacion/delete/{document}', 'ProducersDocumentsController@documentacionDelete')->name('producers.documentacion-delete');
Route::post('/producers/campaign/documentacion-bitacora/save', 'ProducersDocumentsController@bitacoraSave')->name('producers.bitacorasave-doc');
Route::get('/producers/{campaign}/exportToCSV', 'ProducersDocumentsController@exportToCSV')->name('producers.documentacion-exportToCSV');


Route::get('/producers/{campaign}/gastos/{mes?}', 'ProducersGastosController@index')->name('producers.gastos');
Route::post('/producers/{campaign}/gastos/save', 'ProducersGastosController@saveinfo')->name('producers.gastos-save');
Route::get('/producers/{campaign}/gastos/edit/{gasto}', 'ProducersGastosController@editinfo')->name('producers.gastos-edit');
Route::delete('/producers/gastos/destroy/{gasto}', 'ProducersGastosController@destroy')->name('producers.gastos-destroy');
Route::post('/producers/{campaign}/gastos/update/{gasto}', 'ProducersGastosController@updateInfo')->name('producers.gastos-update');


Route::get('/producers/{campaign}/facturas', 'ProducersBillsController@index')->name('producers.facturas');
Route::get('/producers/{campaign}/facturas/agregar', 'ProducersBillsController@create')->name('producers.facturas-add');
Route::post('/producers/{campaign}/facturas/getGastos', 'ProducersBillsController@getGastos')->name('producers.facturas-get-gastos');
Route::post('/producers/{campaign}/facturas/saveInfo', 'ProducersBillsController@saveInfo')->name('producers.facturas-save-info');
Route::get('/producers/{campaign}/facturas/edit/{factura}', 'ProducersBillsController@edit')->name('producers.facturas-edit');
Route::post('/producers/{campaign}/facturas/update/{factura}', 'ProducersBillsController@update')->name('producers.facturas-update');
Route::get('/producers/{campaign}/facturas/delete/{factura}', 'ProducersBillsController@deleteBill')->name('producers.facturas-delete');
Route::get('/producers/{campaign}/facturas/exportToCSV', 'ProducersBillsController@exportToCSV')->name('producers.facturas-exportToCSV');


Route::get('/producers/campaign/{campaign}/entrada-de-datos', 'ProducersController@entradaDatosIndex')->name('producers.entrada-datos');
Route::get('/producers/campaign/{campaign}/entrada-de-datos/export', 'ProducersController@entradaDatosExport')->name('producers.export-entrada-datos');


Route::get('/posicion-global', "PosicionglobalController@index" )->name('posicion-global.index');
Route::post('/posicion-global', "PosicionglobalController@getList" )->name('posicion-global.getList');
Route::get('/posicion-global/downloadCSV/{month}/{year}', "PosicionglobalController@downloadCSV" )->name('posicion-global.downloadCSV');

Route::get('/posicion-global/rules', "RulesController@index" )->name('posicion-global.rules-index');
Route::get('/posicion-global/add-rule', "RulesController@addRule" )->name('posicion-global.add-rule');
Route::post('/posicion-global/save-rule', "RulesController@saveRule" )->name('posicion-global.save-rule');
Route::get('/posicion-global/edit-rule/{rule}', "RulesController@editRule" )->name('posicion-global.edit-rule');
Route::post('/posicion-global/update-rule/{rule}', "RulesController@updateRule" )->name('posicion-global.update-rule');
Route::get('/posicion-global/del-rule/{rule}', "RulesController@delRule" )->name('posicion-global.del-rule');
