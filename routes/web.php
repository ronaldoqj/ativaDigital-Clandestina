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

// Route::match(['get', 'post'], '/selectEvents/{param?}', 'WelcomeController@selectEvents')->name('welcome');
Route::any('/ajax_selectEvents/{paginacao?}/{NRegistros?}/{mes?}/{dia?}/{cat?}/{search?}/{PesquisaRelacionada?}', 'WelcomeController@ajax_selectEvents')->name('selectEvents');
Route::any('/ajax_selectLugares/{paginacao?}/{NRegistros?}/{cat?}/{search?}', 'WelcomeController@ajax_selectLugares')->name('selectLugares');
Route::any('/ajax_selectConteudo/{paginacao?}/{NRegistros?}/{cat?}/{search?}', 'WelcomeController@ajax_selectConteudo')->name('selectConteudo');
Route::any('/ajax_registerNewsLetter', 'WelcomeController@ajax_registerNewsLetter')->name('registerNewsLetter');
Route::any('/ajax_bannersTops/{id?}/{ativo?}/{table?}/{column?}', 'WelcomeController@ajax_bannersTops')->name('bannersTops');
Route::any('/ajax_bannersTopsOrders/{id?}/{ativo?}/{table?}/{column?}/{value?}', 'WelcomeController@ajax_bannersTopsOrders')->name('bannersTopsOrders');

Route::match(['get', 'post'], '/', 'WelcomeController@index')->name('welcome');
Route::match(['get', 'post'], '/lugares/{id?}', 'CasasController@index')->name('lugares');
Route::match(['get', 'post'], '/lugares/lugar/{id?}/{title?}', 'CasaController@index')->name('lugar');
Route::match(['get', 'post'], '/agenda/{id?}/{title?}', 'AgendaController@index')->name('agenda');
Route::match(['get', 'post'], '/evento/{id?}/{title?}', 'EventoController@index')->name('evento');
Route::match(['get', 'post'], '/conteudo/noticia/{id?}/{title?}', 'NoticiaController@index')->name('noticia');
Route::match(['get', 'post'], '/conteudo', 'ConteudoController@index')->name('conteudo');
Route::match(['get', 'post'], '/quem-somos', 'QuemSomosController@index')->name('quem-somos');
Route::match(['get', 'post'], '/parceiros', 'ParceirosController@index')->name('parceiros');
Route::match(['get', 'post'], '/contato', 'ContatoController@index')->name('contato');

Route::match(['get', 'post'], '/pesquisa', 'PesquisaController@index')->name('pesquisa');
// Route::get('/quem-somos', function () {
//     $return['menus'] = 'quem somos';
//     return view('quem-somos')->withReturn($return);
// });
// Route::get('/local', 'LocalController@index')->name('local');
// Route::get('/locais', 'LocaisController@index')->name('locais');
// Route::get('/agenda', 'AgendaController@index')->name('agenda');
// Route::get('/evento', 'EventoController@index')->name('evento');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'adm'], function () {
  Route::match(['get', 'post'], '/', 'Adm\ProgramacoesController@index');
  Route::match(['get', 'post'], '/home', 'Adm\HomeController@index')->name('adm-home');
  Route::match(['get', 'post'], '/programacoes', 'Adm\ProgramacoesController@index')->name('adm-programacoes');
  Route::match(['get', 'post'], '/programacoes-edit/{id?}', 'Adm\ProgramacoesController@update')->name('adm-programacoes-edit');
  Route::match(['get', 'post'], '/casas/{id?}', 'Adm\CasasController@index')->name('adm-casas');
  Route::match(['get', 'post'], '/casas-edit/{id?}', 'Adm\CasasController@update')->name('adm-casas-edit');
  Route::match(['get', 'post'], '/quem-somos/{id?}', 'Adm\QuemSomosController@index')->name('adm-quem-somos');
  Route::match(['get', 'post'], '/quem-somos-edit/{id?}', 'Adm\QuemSomosController@update')->name('adm-quem-somos-edit');
  Route::match(['get', 'post'], '/parceiros/{id?}', 'Adm\ParceirosController@index')->name('adm-parceiros');
  Route::match(['get', 'post'], '/parceiros-edit/{id?}', 'Adm\ParceirosController@update')->name('adm-parceiros-edit');
  Route::match(['get', 'post'], '/categorias/{id?}', 'Adm\CategoriasController@index')->name('adm-categorias');
  Route::match(['get', 'post'], '/noticias/{id?}', 'Adm\NoticiasController@index')->name('adm-noticias');
  Route::match(['get', 'post'], '/noticia-edit/{id?}', 'Adm\NoticiasController@update')->name('adm-noticias-edit');
  Route::match(['get', 'post'], '/usuario', 'Adm\UserController@index')->name('adm-usuario');
  // Route::match(['get', 'post'], '/locais/{id?}', 'Adm\LocaisController@index')->name('adm-locais');
});
