<?php

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

//Route::get('/', function () {
//    return view('welcome');
//});
//
Auth::routes();

// ROUTES FOR WEBSITE START

//php artisan route:clear
//php artisan cache:clear
//composer update

Route::get('/dashboard', 'SiteController@dashboard');

Route::get('/', 'SiteController@index');
Route::get('/home', 'SiteController@index')->name('home');
Route::get('/inicio', 'SiteController@inicio')->name('inicio');
Route::get('/contacto', 'SiteController@contacto')->name('contacto');
Route::get('/galleria/{pagina_id}', 'SiteController@galleria')->name('galleria');
Route::get('/artigos/{pagina_id}', 'SiteController@artigo')->name('artigos');
Route::get('/artigo/{id}', 'SiteController@artigo_details')->name('artigo-details');
Route::get('/peixes', 'SiteController@peixes')->name('peixes');
Route::get('/peixe/{id}', 'SiteController@peixe')->name('peixe-detalhe');
Route::get('/carrinho', 'SiteController@carrinho')->name('carrinho');
Route::get('/confirmado', 'SiteController@confirmado')->name('confirmado');
Route::get('/perfil', 'SiteController@perfil')->name('perfil');
Route::post('/fazerlogin', 'SiteController@fazer_login');
Route::get('/fazer-logoff', 'SiteController@fazer_logoff');
Route::post('/registar_internauta', 'SiteController@registar_internauta');
Route::post('/perfil/atualizar', 'SiteController@update_internauta');
Route::post('/resetar_senha', 'SiteController@resetar_senha');
Route::post('/receber_notificacao', 'SiteController@cliente_notificacao_envia_email');
Route::post('/contactar_multicojex', 'SiteController@contactar_multicojex');
Route::post('/alterar_senha', 'SiteController@alterar_senha');
Route::get('/not_found', 'SiteController@peixe')->name('peixe-detalhe');

Route::get('auth/{provider}','SiteController@redirectToProvider');
Route::get('auth/{provider}/callback','SiteController@handleProviderCallback');
Route::get('/provider_simulator/{provider}','SiteController@user_provider_simulator');

// ROUTES FOR WEBSITE END

// ROUTES FOR ADMIN START

//Route::get('/', 'DashboardController@index');
//Route::get('/dashboard', 'DashboardController@index');
//Route::get('/home', 'DashboardController@index');

Route::get('/cpanel/admin/dashboard', 'DashboardController@index');
Route::get('/cpanel/admin/fontawesome', 'DashboardController@fontawesome');
Route::get('/cpanel/admin/eleganticon', 'DashboardController@eleganticon');

Route::post('/cpanel/admin/imagem/adicionar', 'ImagemController@store');
Route::get('/cpanel/admin/imagem/{id}/remover', 'ImagemController@remover');

Route::post('/cpanel/admin/utilizador/fazer_login', 'UtilizadorController@fazer_login');
Route::post('/cpanel/admin/utilizador/resetar_senha', 'UtilizadorController@resetar_senha');
Route::post('/cpanel/admin/utilizador/alterar_senha', 'UtilizadorController@alterar_senha');
Route::post('/cpanel/admin/utilizador/alterar_senha_app', 'UtilizadorController@alterar_senha_app');

Route::get('/cpanel/admin/utilizador/lista', 'UtilizadorController@index');
Route::get('/cpanel/admin/utilizador/{id}/editar', 'UtilizadorController@edit');
Route::post('/cpanel/admin/utilizador/{id}/atualizar', 'UtilizadorController@update');
Route::get('/cpanel/admin/utilizador/novo','UtilizadorController@create');
Route::post('/cpanel/admin/utilizador/gravar', 'UtilizadorController@store');
Route::get('/cpanel/admin/utilizador/{id}/activar', 'UtilizadorController@activar');
Route::get('/cpanel/admin/utilizador/{id}/desactivar', 'UtilizadorController@desactivar');
Route::get('/cpanel/admin/utilizador/{array_id}/{estado}/activar_desactivar_conjunto', 'UtilizadorController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/utilizador/{id}/remover', 'UtilizadorController@remover');
Route::get('/cpanel/admin/utilizador/{array_id}/remover_conjunto', 'UtilizadorController@remover_conjunto');

Route::get('/cpanel/admin/slider/lista', 'SliderController@index');
Route::get('/cpanel/admin/slider/{id}/editar', 'SliderController@edit');
Route::post('/cpanel/admin/slider/{id}/atualizar', 'SliderController@update');
Route::get('/cpanel/admin/slider/novo','SliderController@create');
Route::post('/cpanel/admin/slider/gravar', 'SliderController@store');
Route::get('/cpanel/admin/slider/{id}/{estado}/activar_desactivar', 'SliderController@activar_desactivar');
Route::get('/cpanel/admin/slider/{array_id}/{estado}/activar_desactivar_conjunto', 'SliderController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/slider/{id}/remover', 'SliderController@remover');
Route::get('/cpanel/admin/slider/{array_id}/remover_conjunto', 'SliderController@remover_conjunto');
Route::get('/cpanel/admin/slider/{id}/{estado}/galeria_on_off', 'SliderController@galeria_on_off');
Route::get('/cpanel/admin/slider/{array_id}/{estado}/galeria_on_off_conjunto', 'SliderController@galeria_on_off_conjunto');


Route::get('/cpanel/admin/galleria/lista', 'GalleriaController@index');
Route::get('/cpanel/admin/galleria/{id}/editar', 'GalleriaController@edit');
Route::post('/cpanel/admin/galleria/{id}/atualizar', 'GalleriaController@update');
Route::get('/cpanel/admin/galleria/novo','GalleriaController@create');
Route::post('/cpanel/admin/galleria/gravar', 'GalleriaController@store');
Route::get('/cpanel/admin/galleria/{id}/{estado}/activar_desactivar', 'GalleriaController@activar_desactivar');
Route::get('/cpanel/admin/galleria/{array_id}/{estado}/activar_desactivar_conjunto', 'GalleriaController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/galleria/{id}/remover', 'GalleriaController@remover');
Route::get('/cpanel/admin/galleria/{array_id}/remover_conjunto', 'GalleriaController@remover_conjunto');
Route::get('/cpanel/admin/galleria/{id}/{estado}/galeria_on_off', 'GalleriaController@galeria_on_off');
Route::get('/cpanel/admin/galleria/{array_id}/{estado}/galeria_on_off_conjunto', 'GalleriaController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/especificidade/lista', 'EspecificidadeController@index');
Route::get('/cpanel/admin/especificidade/{id}/editar', 'EspecificidadeController@edit');
Route::post('/cpanel/admin/especificidade/{id}/atualizar', 'EspecificidadeController@update');
Route::get('/cpanel/admin/especificidade/novo','EspecificidadeController@create');
Route::post('/cpanel/admin/especificidade/gravar', 'EspecificidadeController@store');
Route::get('/cpanel/admin/especificidade/{id}/{estado}/activar_desactivar', 'EspecificidadeController@activar_desactivar');
Route::get('/cpanel/admin/especificidade/{array_id}/{estado}/activar_desactivar_conjunto', 'EspecificidadeController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/especificidade/{id}/remover', 'EspecificidadeController@remover');
Route::get('/cpanel/admin/especificidade/{array_id}/remover_conjunto', 'EspecificidadeController@remover_conjunto');
Route::get('/cpanel/admin/especificidade/{id}/{estado}/galeria_on_off', 'EspecificidadeController@galeria_on_off');
Route::get('/cpanel/admin/especificidade/{array_id}/{estado}/galeria_on_off_conjunto', 'EspecificidadeController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/servico/lista', 'ServicoController@index');
Route::get('/cpanel/admin/servico/{id}/editar', 'ServicoController@edit');
Route::post('/cpanel/admin/servico/{id}/atualizar', 'ServicoController@update');
Route::get('/cpanel/admin/servico/novo','ServicoController@create');
Route::post('/cpanel/admin/servico/gravar', 'ServicoController@store');
Route::get('/cpanel/admin/servico/{id}/{estado}/activar_desactivar', 'ServicoController@activar_desactivar');
Route::get('/cpanel/admin/servico/{array_id}/{estado}/activar_desactivar_conjunto', 'ServicoController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/servico/{id}/remover', 'ServicoController@remover');
Route::get('/cpanel/admin/servico/{array_id}/remover_conjunto', 'ServicoController@remover_conjunto');
Route::get('/cpanel/admin/servico/{id}/{estado}/galeria_on_off', 'ServicoController@galeria_on_off');
Route::get('/cpanel/admin/servico/{array_id}/{estado}/galeria_on_off_conjunto', 'ServicoController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/produto/lista', 'ProdutoController@index');
Route::get('/cpanel/admin/produto/{id}/editar', 'ProdutoController@edit');
Route::post('/cpanel/admin/produto/{id}/atualizar', 'ProdutoController@update');
Route::get('/cpanel/admin/produto/novo','ProdutoController@create');
Route::post('/cpanel/admin/produto/gravar', 'ProdutoController@store');
Route::get('/cpanel/admin/produto/{id}/{estado}/activar_desactivar', 'ProdutoController@activar_desactivar');
Route::get('/cpanel/admin/produto/{array_id}/{estado}/activar_desactivar_conjunto', 'ProdutoController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/produto/{id}/remover', 'ProdutoController@remover');
Route::get('/cpanel/admin/produto/{array_id}/remover_conjunto', 'ProdutoController@remover_conjunto');
Route::get('/cpanel/admin/produto/{id}/{estado}/galeria_on_off', 'ProdutoController@galeria_on_off');
Route::get('/cpanel/admin/produto/{array_id}/{estado}/galeria_on_off_conjunto', 'ProdutoController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/categoria/lista', 'CategoriaController@index');
Route::get('/cpanel/admin/categoria/{id}/editar', 'CategoriaController@edit');
Route::post('/cpanel/admin/categoria/{id}/atualizar', 'CategoriaController@update');
Route::get('/cpanel/admin/categoria/novo','CategoriaController@create');
Route::post('/cpanel/admin/categoria/gravar', 'CategoriaController@store');
Route::get('/cpanel/admin/categoria/{id}/{estado}/activar_desactivar', 'CategoriaController@activar_desactivar');
Route::get('/cpanel/admin/categoria/{array_id}/{estado}/activar_desactivar_conjunto', 'CategoriaController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/categoria/{id}/remover', 'CategoriaController@remover');
Route::get('/cpanel/admin/categoria/{array_id}/remover_conjunto', 'CategoriaController@remover_conjunto');
Route::get('/cpanel/admin/categoria/{id}/{estado}/galeria_on_off', 'CategoriaController@galeria_on_off');
Route::get('/cpanel/admin/categoria/{array_id}/{estado}/galeria_on_off_conjunto', 'CategoriaController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/tipo/lista', 'TipoController@index');
Route::get('/cpanel/admin/tipo/{id}/editar', 'TipoController@edit');
Route::post('/cpanel/admin/tipo/{id}/atualizar', 'TipoController@update');
Route::get('/cpanel/admin/tipo/novo','TipoController@create');
Route::post('/cpanel/admin/tipo/gravar', 'TipoController@store');
Route::get('/cpanel/admin/tipo/{id}/{estado}/activar_desactivar', 'TipoController@activar_desactivar');
Route::get('/cpanel/admin/tipo/{array_id}/{estado}/activar_desactivar_conjunto', 'TipoController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/tipo/{id}/remover', 'TipoController@remover');
Route::get('/cpanel/admin/tipo/{array_id}/remover_conjunto', 'TipoController@remover_conjunto');
Route::get('/cpanel/admin/tipo/{id}/{estado}/galeria_on_off', 'TipoController@galeria_on_off');
Route::get('/cpanel/admin/tipo/{array_id}/{estado}/galeria_on_off_conjunto', 'TipoController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/cargo/lista', 'cargoController@index');
Route::get('/cpanel/admin/cargo/{id}/editar', 'cargoController@edit');
Route::post('/cpanel/admin/cargo/{id}/atualizar', 'cargoController@update');
Route::get('/cpanel/admin/cargo/novo','cargoController@create');
Route::post('/cpanel/admin/cargo/gravar', 'cargoController@store');
Route::get('/cpanel/admin/cargo/{id}/{estado}/activar_desactivar', 'cargoController@activar_desactivar');
Route::get('/cpanel/admin/cargo/{array_id}/{estado}/activar_desactivar_conjunto', 'cargoController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/cargo/{id}/remover', 'cargoController@remover');
Route::get('/cpanel/admin/cargo/{array_id}/remover_conjunto', 'cargoController@remover_conjunto');
Route::get('/cpanel/admin/cargo/{id}/{estado}/galeria_on_off', 'cargoController@galeria_on_off');
Route::get('/cpanel/admin/cargo/{array_id}/{estado}/galeria_on_off_conjunto', 'cargoController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/funcionario/lista', 'FuncionarioController@index');
Route::get('/cpanel/admin/funcionario/{id}/editar', 'FuncionarioController@edit');
Route::post('/cpanel/admin/funcionario/{id}/atualizar', 'FuncionarioController@update');
Route::get('/cpanel/admin/funcionario/novo','FuncionarioController@create');
Route::post('/cpanel/admin/funcionario/gravar', 'FuncionarioController@store');
Route::get('/cpanel/admin/funcionario/{id}/{estado}/activar_desactivar', 'FuncionarioController@activar_desactivar');
Route::get('/cpanel/admin/funcionario/{array_id}/{estado}/activar_desactivar_conjunto', 'FuncionarioController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/funcionario/{id}/remover', 'FuncionarioController@remover');
Route::get('/cpanel/admin/funcionario/{array_id}/remover_conjunto', 'FuncionarioController@remover_conjunto');
Route::get('/cpanel/admin/funcionario/{id}/{estado}/galeria_on_off', 'FuncionarioController@galeria_on_off');
Route::get('/cpanel/admin/funcionario/{array_id}/{estado}/galeria_on_off_conjunto', 'FuncionarioController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/contacto/lista', 'ContactoController@index');
Route::get('/cpanel/admin/contacto/{id}/editar', 'ContactoController@edit');
Route::post('/cpanel/admin/contacto/{id}/atualizar', 'ContactoController@update');
Route::get('/cpanel/admin/contacto/novo','ContactoController@create');
Route::post('/cpanel/admin/contacto/gravar', 'ContactoController@store');
Route::get('/cpanel/admin/contacto/{id}/{estado}/activar_desactivar', 'ContactoController@activar_desactivar');
Route::get('/cpanel/admin/contacto/{array_id}/{estado}/activar_desactivar_conjunto', 'ContactoController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/contacto/{id}/remover', 'ContactoController@remover');
Route::get('/cpanel/admin/contacto/{array_id}/remover_conjunto', 'ContactoController@remover_conjunto');
Route::get('/cpanel/admin/contacto/{id}/{estado}/galeria_on_off', 'ContactoController@galeria_on_off');
Route::get('/cpanel/admin/contacto/{array_id}/{estado}/galeria_on_off_conjunto', 'ContactoController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/chat/lista', 'ChatController@index');
Route::get('/cpanel/admin/chat/com/{id}', 'ChatController@chat_com');
Route::post('/cpanel/admin/chat/{id}/atualizar', 'ChatController@update');
Route::get('/cpanel/admin/chat/novo','ChatController@create');
Route::post('/cpanel/admin/chat/gravar', 'ChatController@store');
Route::get('/cpanel/admin/chat/{id}/{estado}/activar_desactivar', 'ChatController@activar_desactivar');
Route::get('/cpanel/admin/chat/{array_id}/{estado}/activar_desactivar_conjunto', 'ChatController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/chat/{id}/remover', 'ChatController@remover');
Route::get('/cpanel/admin/chat/{array_id}/remover_conjunto', 'ChatController@remover_conjunto');
Route::get('/cpanel/admin/chat/{id}/{estado}/galeria_on_off', 'ChatController@galeria_on_off');
Route::get('/cpanel/admin/chat/{array_id}/{estado}/galeria_on_off_conjunto', 'ChatController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/sobre_nos/lista', 'SobreNosController@index');
Route::get('/cpanel/admin/sobre_nos/{id}/editar', 'SobreNosController@edit');
Route::get('/cpanel/admin/sobre_nos/{sobre_id}/paragrafo/{paragrafo_id}/editar', 'SobreNosController@edit_paragrafo');
Route::post('/cpanel/admin/sobre_nos/{id}/atualizar', 'SobreNosController@update');
Route::post('/cpanel/admin/sobre_nos/paragrafo/{paragrafo_id}/atualizar', 'SobreNosController@update_paragrafo');
Route::get('/cpanel/admin/sobre_nos/novo','SobreNosController@create');
Route::post('/cpanel/admin/sobre_nos/gravar', 'SobreNosController@store');
Route::post('/cpanel/admin/sobre_nos/paragrafo/gravar', 'SobreNosController@store_paragrafo');
Route::get('/cpanel/admin/sobre_nos/{id}/{estado}/activar_desactivar', 'SobreNosController@activar_desactivar');
Route::get('/cpanel/admin/sobre_nos/{array_id}/{estado}/activar_desactivar_conjunto', 'SobreNosController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/sobre_nos/{id}/remover', 'SobreNosController@remover');
Route::get('/cpanel/admin/sobre_nos/paragrafo/{id}/remover', 'SobreNosController@remover_paragrafo');
Route::get('/cpanel/admin/sobre_nos/{array_id}/remover_conjunto', 'SobreNosController@remover_conjunto');
Route::get('/cpanel/admin/sobre_nos/{id}/{estado}/galeria_on_off', 'SobreNosController@galeria_on_off');
Route::get('/cpanel/admin/sobre_nos/{array_id}/{estado}/galeria_on_off_conjunto', 'SobreNosController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/noticia/lista', 'NoticiaController@index');
Route::get('/cpanel/admin/noticia/{id}/editar', 'NoticiaController@edit');
Route::post('/cpanel/admin/noticia/{id}/atualizar', 'NoticiaController@update');
Route::get('/cpanel/admin/noticia/novo','NoticiaController@create');
Route::post('/cpanel/admin/noticia/gravar', 'NoticiaController@store');
Route::get('/cpanel/admin/noticia/{id}/{estado}/activar_desactivar', 'NoticiaController@activar_desactivar');
Route::get('/cpanel/admin/noticia/{array_id}/{estado}/activar_desactivar_conjunto', 'NoticiaController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/noticia/{id}/remover', 'NoticiaController@remover');
Route::get('/cpanel/admin/noticia/{array_id}/remover_conjunto', 'NoticiaController@remover_conjunto');
Route::get('/cpanel/admin/noticia/{id}/{estado}/galeria_on_off', 'NoticiaController@galeria_on_off');
Route::get('/cpanel/admin/noticia/{array_id}/{estado}/galeria_on_off_conjunto', 'NoticiaController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/parceiro/lista', 'ParceiroController@index');
Route::post('/cpanel/admin/parceiro/consultar', 'ParceiroController@consultar');
Route::get('/cpanel/admin/parceiro/{id}/editar', 'ParceiroController@edit');
Route::post('/cpanel/admin/parceiro/{id}/atualizar', 'ParceiroController@update');
Route::get('/cpanel/admin/parceiro/novo','ParceiroController@create');
Route::post('/cpanel/admin/parceiro/gravar', 'ParceiroController@store');
Route::get('/cpanel/admin/parceiro/{id}/{estado}/activar_desactivar', 'ParceiroController@activar_desactivar');
Route::get('/cpanel/admin/parceiro/{array_id}/{estado}/activar_desactivar_conjunto', 'ParceiroController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/parceiro/{id}/remover', 'ParceiroController@remover');
Route::get('/cpanel/admin/parceiro/{array_id}/remover_conjunto', 'ParceiroController@remover_conjunto');
Route::get('/cpanel/admin/parceiro/{id}/{estado}/galeria_on_off', 'ParceiroController@galeria_on_off');
Route::get('/cpanel/admin/parceiro/{array_id}/{estado}/galeria_on_off_conjunto', 'ParceiroController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/curso/lista', 'CursoController@index');
Route::get('/cpanel/admin/curso/{id}/editar', 'CursoController@edit');
Route::post('/cpanel/admin/curso/{id}/atualizar', 'CursoController@update');
Route::get('/cpanel/admin/curso/novo','CursoController@create');
Route::post('/cpanel/admin/curso/gravar', 'CursoController@store');
Route::get('/cpanel/admin/curso/{id}/{estado}/activar_desactivar', 'CursoController@activar_desactivar');
Route::get('/cpanel/admin/curso/{array_id}/{estado}/activar_desactivar_conjunto', 'CursoController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/curso/{id}/remover', 'CursoController@remover');
Route::get('/cpanel/admin/curso/{array_id}/remover_conjunto', 'CursoController@remover_conjunto');
Route::get('/cpanel/admin/curso/{id}/{estado}/galeria_on_off', 'CursoController@galeria_on_off');
Route::get('/cpanel/admin/curso/{array_id}/{estado}/galeria_on_off_conjunto', 'CursoController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/horario/lista', 'HorarioController@index');
Route::get('/cpanel/admin/horario/{id}/editar', 'HorarioController@edit');
Route::post('/cpanel/admin/horario/{id}/atualizar', 'HorarioController@update');
Route::get('/cpanel/admin/horario/novo','HorarioController@create');
Route::post('/cpanel/admin/horario/gravar', 'HorarioController@store');
Route::get('/cpanel/admin/horario/{id}/{estado}/activar_desactivar', 'HorarioController@activar_desactivar');
Route::get('/cpanel/admin/horario/{array_id}/{estado}/activar_desactivar_conjunto', 'HorarioController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/horario/{id}/remover', 'HorarioController@remover');
Route::get('/cpanel/admin/horario/{array_id}/remover_conjunto', 'HorarioController@remover_conjunto');
Route::get('/cpanel/admin/horario/{id}/{estado}/galeria_on_off', 'HorarioController@galeria_on_off');
Route::get('/cpanel/admin/horario/{array_id}/{estado}/galeria_on_off_conjunto', 'HorarioController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/testemunho/lista', 'TestemunhoController@index');
Route::get('/cpanel/admin/testemunho/{id}/editar', 'TestemunhoController@edit');
Route::post('/cpanel/admin/testemunho/{id}/atualizar', 'TestemunhoController@update');
Route::get('/cpanel/admin/testemunho/novo','TestemunhoController@create');
Route::post('/cpanel/admin/testemunho/gravar', 'TestemunhoController@store');
Route::get('/cpanel/admin/testemunho/{id}/{estado}/activar_desactivar', 'TestemunhoController@activar_desactivar');
Route::get('/cpanel/admin/testemunho/{array_id}/{estado}/activar_desactivar_conjunto', 'TestemunhoController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/testemunho/{id}/remover', 'TestemunhoController@remover');
Route::get('/cpanel/admin/testemunho/{array_id}/remover_conjunto', 'TestemunhoController@remover_conjunto');
Route::get('/cpanel/admin/testemunho/{id}/{estado}/galeria_on_off', 'TestemunhoController@galeria_on_off');
Route::get('/cpanel/admin/testemunho/{array_id}/{estado}/galeria_on_off_conjunto', 'TestemunhoController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/internauta/lista', 'InternautaController@index');
Route::get('/cpanel/admin/internauta/{id}/editar', 'InternautaController@edit');
Route::post('/cpanel/admin/internauta/{id}/atualizar', 'InternautaController@update');
Route::get('/cpanel/admin/internauta/novo','InternautaController@create');
Route::post('/cpanel/admin/internauta/gravar', 'InternautaController@store');
Route::get('/cpanel/admin/internauta/{id}/{estado}/activar_desactivar', 'InternautaController@activar_desactivar');
Route::get('/cpanel/admin/internauta/{array_id}/{estado}/activar_desactivar_conjunto', 'InternautaController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/internauta/{id}/remover', 'InternautaController@remover');
Route::get('/cpanel/admin/internauta/{array_id}/remover_conjunto', 'InternautaController@remover_conjunto');
Route::get('/cpanel/admin/internauta/{id}/{estado}/galeria_on_off', 'InternautaController@galeria_on_off');
Route::get('/cpanel/admin/internauta/{array_id}/{estado}/galeria_on_off_conjunto', 'InternautaController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/comentario/{post_id}/{post_tipo}/listar', 'ComentarioController@index');
Route::get('/cpanel/admin/comentario/{id}/editar', 'ComentarioController@edit');
Route::post('/cpanel/admin/comentario/{id}/atualizar', 'ComentarioController@update');
Route::get('/cpanel/admin/comentario/novo','ComentarioController@create');
Route::post('/cpanel/admin/comentario/gravar', 'ComentarioController@gravar');
Route::get('/cpanel/admin/comentario/{id}/{estado}/activar_desactivar', 'ComentarioController@activar_desactivar');
Route::get('/cpanel/admin/comentario/{array_id}/{estado}/activar_desactivar_conjunto', 'ComentarioController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/comentario/{id}/remover', 'ComentarioController@remover');
Route::get('/cpanel/admin/comentario/{array_id}/remover_conjunto', 'ComentarioController@remover_conjunto');
Route::get('/cpanel/admin/comentario/{id}/{estado}/galeria_on_off', 'ComentarioController@galeria_on_off');
Route::get('/cpanel/admin/comentario/{array_id}/{estado}/galeria_on_off_conjunto', 'ComentarioController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/faqs/lista', 'FaqsController@index');
Route::get('/cpanel/admin/faqs/{id}/editar', 'FaqsController@edit');
Route::post('/cpanel/admin/faqs/{id}/atualizar', 'FaqsController@update');
Route::get('/cpanel/admin/faqs/novo','FaqsController@create');
Route::post('/cpanel/admin/faqs/gravar', 'FaqsController@store');
Route::get('/cpanel/admin/faqs/{id}/{estado}/activar_desactivar', 'FaqsController@activar_desactivar');
Route::get('/cpanel/admin/faqs/{array_id}/{estado}/activar_desactivar_conjunto', 'FaqsController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/faqs/{id}/remover', 'FaqsController@remover');
Route::get('/cpanel/admin/faqs/{array_id}/remover_conjunto', 'FaqsController@remover_conjunto');
Route::get('/cpanel/admin/faqs/{id}/{estado}/galeria_on_off', 'FaqsController@galeria_on_off');
Route::get('/cpanel/admin/faqs/{array_id}/{estado}/galeria_on_off_conjunto', 'FaqsController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/taxa_fatura/lista', 'TaxaFaturaController@index');
Route::get('/cpanel/admin/taxa_fatura/{id}/editar', 'TaxaFaturaController@edit');
Route::post('/cpanel/admin/taxa_fatura/{id}/atualizar', 'TaxaFaturaController@update');
Route::get('/cpanel/admin/taxa_fatura/novo','TaxaFaturaController@create');
Route::post('/cpanel/admin/taxa_fatura/gravar', 'TaxaFaturaController@store');
Route::get('/cpanel/admin/taxa_fatura/{id}/{estado}/activar_desactivar', 'TaxaFaturaController@activar_desactivar');
Route::get('/cpanel/admin/taxa_fatura/{array_id}/{estado}/activar_desactivar_conjunto', 'TaxaFaturaController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/taxa_fatura/{id}/remover', 'TaxaFaturaController@remover');
Route::get('/cpanel/admin/taxa_fatura/{array_id}/remover_conjunto', 'TaxaFaturaController@remover_conjunto');
Route::get('/cpanel/admin/taxa_fatura/{id}/{estado}/galeria_on_off', 'TaxaFaturaController@galeria_on_off');
Route::get('/cpanel/admin/taxa_fatura/{array_id}/{estado}/galeria_on_off_conjunto', 'TaxaFaturaController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/carrinho/lista', 'CarrinhoController@index');
Route::get('/cpanel/admin/carrinho/{internauta_id}/criar', 'CarrinhoController@criar_carrinho');
Route::get('/cpanel/admin/carrinho/{id}/remover', 'CarrinhoController@remover');
Route::get('/cpanel/admin/carrinho/{array_id}/remover_conjunto', 'CarrinhoController@remover_conjunto');

Route::get('/cpanel/admin/carrinho_produto/{carrinho_id}/editar', 'CarrinhoProdutoController@index');
Route::get('/cpanel/admin/carrinho_produto/{json_produto_array}/criar', 'CarrinhoProdutoController@store');
Route::get('/cpanel/admin/carrinho_produto/{json_produto_array}/atualizar', 'CarrinhoProdutoController@atualizar');
Route::get('/cpanel/admin/carrinho_produto/{imposto_array}/{carrinho_id}/atualizar_imposto', 'CarrinhoProdutoController@atualizar_imposto');
Route::get('/cpanel/admin/carrinho_produto/{array_id}/remover_conjunto', 'CarrinhoProdutoController@remover_conjunto');
Route::get('/cpanel/admin/carrinho_produto/{enderecos}/{carrinho_id}/{pagamento}/finalizarcompra', 'CarrinhoProdutoController@finalizarcompra');
Route::get('/cpanel/admin/carrinho_produto/{carrinho_id}/comprafinalizada', 'CarrinhoProdutoController@venda_realizada');
Route::get('/cpanel/admin/carrinho_produto/factura/{carrinho_id}', 'CarrinhoProdutoController@gerarFactura');
Route::get('/cpanel/admin/carrinho_produto/facturaProforma/{carrinho_id}', 'CarrinhoProdutoController@gerarProformaFactura');

Route::get('/cpanel/admin/empresa/lista', 'EmpresaController@index');
Route::get('/cpanel/admin/empresa/{id}/editar', 'EmpresaController@edit');
Route::post('/cpanel/admin/empresa/{id}/atualizar', 'EmpresaController@update');
Route::get('/cpanel/admin/empresa/novo','EmpresaController@create');
Route::post('/cpanel/admin/empresa/gravar', 'EmpresaController@store');
Route::get('/cpanel/admin/empresa/{id}/{estado}/activar_desactivar', 'EmpresaController@activar_desactivar');
Route::get('/cpanel/admin/empresa/{array_id}/{estado}/activar_desactivar_conjunto', 'EmpresaController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/empresa/{id}/remover', 'EmpresaController@remover');
Route::get('/cpanel/admin/empresa/{array_id}/remover_conjunto', 'EmpresaController@remover_conjunto');
Route::get('/cpanel/admin/empresa/{id}/{estado}/galeria_on_off', 'EmpresaController@galeria_on_off');
Route::get('/cpanel/admin/empresa/{array_id}/{estado}/galeria_on_off_conjunto', 'EmpresaController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/embarcacao/lista', 'EmbarcacaoController@index');
Route::get('/cpanel/admin/embarcacao/{id}/editar', 'EmbarcacaoController@edit');
Route::post('/cpanel/admin/embarcacao/{id}/atualizar', 'EmbarcacaoController@update');
Route::get('/cpanel/admin/embarcacao/novo','EmbarcacaoController@create');
Route::post('/cpanel/admin/embarcacao/gravar', 'EmbarcacaoController@store');
Route::get('/cpanel/admin/embarcacao/{id}/{estado}/activar_desactivar', 'EmbarcacaoController@activar_desactivar');
Route::get('/cpanel/admin/embarcacao/{array_id}/{estado}/activar_desactivar_conjunto', 'EmbarcacaoController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/embarcacao/{id}/remover', 'EmbarcacaoController@remover');
Route::get('/cpanel/admin/embarcacao/{array_id}/remover_conjunto', 'EmbarcacaoController@remover_conjunto');
Route::get('/cpanel/admin/embarcacao/{id}/{estado}/galeria_on_off', 'EmbarcacaoController@galeria_on_off');
Route::get('/cpanel/admin/embarcacao/{array_id}/{estado}/galeria_on_off_conjunto', 'EmbarcacaoController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/banco/lista', 'BancoController@index');
Route::get('/cpanel/admin/banco/{id}/editar', 'BancoController@edit');
Route::post('/cpanel/admin/banco/{id}/atualizar', 'BancoController@update');
Route::get('/cpanel/admin/banco/novo','BancoController@create');
Route::post('/cpanel/admin/banco/gravar', 'BancoController@store');
Route::get('/cpanel/admin/banco/{id}/{estado}/activar_desactivar', 'BancoController@activar_desactivar');
Route::get('/cpanel/admin/banco/{array_id}/{estado}/activar_desactivar_conjunto', 'BancoController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/banco/{id}/remover', 'BancoController@remover');
Route::get('/cpanel/admin/banco/{array_id}/remover_conjunto', 'BancoController@remover_conjunto');
Route::get('/cpanel/admin/banco/{id}/{estado}/galeria_on_off', 'BancoController@galeria_on_off');
Route::get('/cpanel/admin/banco/{array_id}/{estado}/galeria_on_off_conjunto', 'BancoController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/candidato/lista', 'CandidatoController@index');
Route::get('/cpanel/admin/candidato/{id}/editar', 'CandidatoController@edit');
Route::post('/cpanel/admin/candidato/{id}/atualizar', 'CandidatoController@update');
Route::get('/cpanel/admin/candidato/novo','CandidatoController@create');
Route::post('/cpanel/admin/candidato/gravar', 'CandidatoController@store');
Route::get('/cpanel/admin/candidato/{id}/{estado}/activar_desactivar', 'CandidatoController@activar_desactivar');
Route::get('/cpanel/admin/candidato/{array_id}/{estado}/activar_desactivar_conjunto', 'CandidatoController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/candidato/{id}/remover', 'CandidatoController@remover');
Route::get('/cpanel/admin/candidato/{array_id}/remover_conjunto', 'CandidatoController@remover_conjunto');
Route::get('/cpanel/admin/candidato/{id}/{estado}/galeria_on_off', 'CandidatoController@galeria_on_off');
Route::get('/cpanel/admin/candidato/{array_id}/{estado}/galeria_on_off_conjunto', 'CandidatoController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/entradaproduto/lista', 'EntradaProdutoController@index');
Route::get('/cpanel/admin/entradaproduto/{produtos}/criar', 'EntradaProdutoController@entrada_de_produto');
Route::get('/cpanel/admin/entradaproduto/{id}/remover', 'EntradaProdutoController@remover');
Route::get('/cpanel/admin/entradaproduto/{array_id}/remover_conjunto', 'EntradaProdutoController@remover_conjunto');

Route::get('/cpanel/admin/pais/lista', 'PaisController@index');
Route::get('/cpanel/admin/pais/{id}/editar', 'PaisController@edit');
Route::post('/cpanel/admin/pais/{id}/atualizar', 'PaisController@update');
Route::get('/cpanel/admin/pais/novo','PaisController@create');
Route::post('/cpanel/admin/pais/gravar', 'PaisController@store');
Route::get('/cpanel/admin/pais/{id}/{estado}/activar_desactivar', 'PaisController@activar_desactivar');
Route::get('/cpanel/admin/pais/{array_id}/{estado}/activar_desactivar_conjunto', 'PaisController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/pais/{id}/remover', 'PaisController@remover');
Route::get('/cpanel/admin/pais/{array_id}/remover_conjunto', 'PaisController@remover_conjunto');
Route::get('/cpanel/admin/pais/{id}/{estado}/galeria_on_off', 'PaisController@galeria_on_off');
Route::get('/cpanel/admin/pais/{array_id}/{estado}/galeria_on_off_conjunto', 'PaisController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/provincia/lista', 'ProvinciaController@index');
Route::get('/cpanel/admin/provincia/{id}/editar', 'ProvinciaController@edit');
Route::post('/cpanel/admin/provincia/{id}/atualizar', 'ProvinciaController@update');
Route::get('/cpanel/admin/provincia/novo','ProvinciaController@create');
Route::post('/cpanel/admin/provincia/gravar', 'ProvinciaController@store');
Route::get('/cpanel/admin/provincia/{id}/{estado}/activar_desactivar', 'ProvinciaController@activar_desactivar');
Route::get('/cpanel/admin/provincia/{array_id}/{estado}/activar_desactivar_conjunto', 'ProvinciaController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/provincia/{id}/remover', 'ProvinciaController@remover');
Route::get('/cpanel/admin/provincia/{array_id}/remover_conjunto', 'ProvinciaController@remover_conjunto');
Route::get('/cpanel/admin/provincia/{id}/{estado}/galeria_on_off', 'ProvinciaController@galeria_on_off');
Route::get('/cpanel/admin/provincia/{array_id}/{estado}/galeria_on_off_conjunto', 'ProvinciaController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/municipio/lista', 'MunicipioController@index');
Route::get('/cpanel/admin/municipio/{id}/editar', 'MunicipioController@edit');
Route::post('/cpanel/admin/municipio/{id}/atualizar', 'MunicipioController@update');
Route::get('/cpanel/admin/municipio/novo','MunicipioController@create');
Route::post('/cpanel/admin/municipio/gravar', 'MunicipioController@store');
Route::get('/cpanel/admin/municipio/{id}/{estado}/activar_desactivar', 'MunicipioController@activar_desactivar');
Route::get('/cpanel/admin/municipio/{array_id}/{estado}/activar_desactivar_conjunto', 'MunicipioController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/municipio/{id}/remover', 'MunicipioController@remover');
Route::get('/cpanel/admin/municipio/{array_id}/remover_conjunto', 'MunicipioController@remover_conjunto');
Route::get('/cpanel/admin/municipio/{id}/{estado}/galeria_on_off', 'MunicipioController@galeria_on_off');
Route::get('/cpanel/admin/municipio/{array_id}/{estado}/galeria_on_off_conjunto', 'MunicipioController@galeria_on_off_conjunto');

Route::get('/cpanel/admin/governante/lista', 'GovernanteController@index');
Route::get('/cpanel/admin/governante/{id}/editar', 'GovernanteController@edit');
Route::post('/cpanel/admin/governante/{id}/atualizar', 'GovernanteController@update');
Route::get('/cpanel/admin/governante/novo','GovernanteController@create');
Route::post('/cpanel/admin/governante/gravar', 'GovernanteController@store');
Route::get('/cpanel/admin/governante/{id}/{estado}/activar_desactivar', 'GovernanteController@activar_desactivar');
Route::get('/cpanel/admin/governante/{array_id}/{estado}/activar_desactivar_conjunto', 'GovernanteController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/governante/{id}/remover', 'GovernanteController@remover');
Route::get('/cpanel/admin/governante/{array_id}/remover_conjunto', 'GovernanteController@remover_conjunto');
Route::get('/cpanel/admin/governante/{id}/{estado}/galeria_on_off', 'GovernanteController@galeria_on_off');
Route::get('/cpanel/admin/governante/{array_id}/{estado}/galeria_on_off_conjunto', 'GovernanteController@galeria_on_off_conjunto');
Route::get('/cpanel/admin/governante/provincias/{pais_id}', 'GovernanteController@provincias');
Route::get('/cpanel/admin/governante/municipios/{provincia_id}', 'GovernanteController@municipios');
Route::get('/cpanel/admin/governante/pais/{provincia_id}', 'GovernanteController@pais');

Route::get('/cpanel/admin/continente/lista', 'ContinenteController@index');
Route::get('/cpanel/admin/continente/{id}/editar', 'ContinenteController@edit');
Route::post('/cpanel/admin/continente/{id}/atualizar', 'ContinenteController@update');
Route::get('/cpanel/admin/continente/novo','ContinenteController@create');
Route::post('/cpanel/admin/continente/gravar', 'ContinenteController@store');
Route::get('/cpanel/admin/continente/{id}/{estado}/activar_desactivar', 'ContinenteController@activar_desactivar');
Route::get('/cpanel/admin/continente/{array_id}/{estado}/activar_desactivar_conjunto', 'ContinenteController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/continente/{id}/remover', 'ContinenteController@remover');
Route::get('/cpanel/admin/continente/{array_id}/remover_conjunto', 'ContinenteController@remover_conjunto');
Route::get('/cpanel/admin/continente/{id}/{estado}/galeria_on_off', 'ContinenteController@galeria_on_off');
Route::get('/cpanel/admin/continente/{array_id}/{estado}/galeria_on_off_conjunto', 'ContinenteController@galeria_on_off_conjunto');
Route::get('/cpanel/admin/continente/provincias/{pais_id}', 'ContinenteController@provincias');
Route::get('/cpanel/admin/continente/pais/{provincia_id}', 'ContinenteController@pais');

Route::get('/cpanel/admin/turismo/app_turismo_request', 'TurismoController@app_turismo_lista');
Route::get('/cpanel/admin/turismo/lista', 'TurismoController@index');
Route::get('/cpanel/admin/turismo/{id}/editar', 'TurismoController@edit');
Route::post('/cpanel/admin/turismo/{id}/atualizar', 'TurismoController@update');
Route::get('/cpanel/admin/turismo/novo','TurismoController@create');
Route::post('/cpanel/admin/turismo/gravar', 'TurismoController@store');
Route::get('/cpanel/admin/turismo/{id}/{estado}/activar_desactivar', 'TurismoController@activar_desactivar');
Route::get('/cpanel/admin/turismo/{array_id}/{estado}/activar_desactivar_conjunto', 'TurismoController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/turismo/{id}/remover', 'TurismoController@remover');
Route::get('/cpanel/admin/turismo/{array_id}/remover_conjunto', 'TurismoController@remover_conjunto');
Route::get('/cpanel/admin/turismo/{id}/{estado}/galeria_on_off', 'TurismoController@galeria_on_off');
Route::get('/cpanel/admin/turismo/{array_id}/{estado}/galeria_on_off_conjunto', 'TurismoController@galeria_on_off_conjunto');
Route::get('/cpanel/admin/turismo/provincias/{pais_id}', 'TurismoController@provincias');
Route::get('/cpanel/admin/turismo/pais/{provincia_id}', 'TurismoController@pais');
Route::get('/cpanel/admin/turismo/incrementar_pontos/{turismo_id}/{qtd}', 'TurismoController@incrementar_pontos');
Route::get('/cpanel/admin/turismo/decrementar_pontos/{turismo_id}/{qtd}', 'TurismoController@decrementar_pontos');
Route::get('/cpanel/admin/turismo/incrementar_sugestao/{turismo_id}/{qtd}', 'TurismoController@incrementar_sugestao');
Route::get('/cpanel/admin/turismo/decrementar_sugestao/{turismo_id}/{qtd}', 'TurismoController@decrementar_sugestao');

Route::get('/cpanel/admin/informacao/{turismo_id}/{turismo_classe}/{tipo}/listar', 'InformacaoParagrafoController@index');
Route::get('/cpanel/admin/informacao/novo/{turismo_id}/{turismo_classe}/{tipo}','InformacaoParagrafoController@create');
Route::get('/cpanel/admin/informacao/editar/{paragrafo_id}/{turismo_id}/{turismo_classe}/{tipo}','InformacaoParagrafoController@edit');
Route::post('/cpanel/admin/informacao/gravar', 'InformacaoParagrafoController@store');
Route::post('/cpanel/admin/informacao/{id}/atualizar', 'InformacaoParagrafoController@update');
Route::get('/cpanel/admin/informacao/{id}/remover', 'InformacaoParagrafoController@remover');
Route::get('/cpanel/admin/informacao/{id}/{estado}/activar_desactivar', 'InformacaoParagrafoController@activar_desactivar');
Route::get('/cpanel/admin/informacao/{array_id}/{estado}/activar_desactivar_conjunto', 'InformacaoParagrafoController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/informacao/{id}/remover', 'InformacaoParagrafoController@remover');
Route::get('/cpanel/admin/informacao/{array_id}/remover_conjunto', 'InformacaoParagrafoController@remover_conjunto');

Route::post('/cpanel/admin/contaBancaria/{id}/atualizar', 'ContaBancariaController@update');
Route::post('/cpanel/admin/contaBancaria/gravar', 'ContaBancariaController@store');
Route::get('/cpanel/admin/contaBancaria/{id}/{estado}/activar_desactivar', 'ContaBancariaController@activar_desactivar');
Route::get('/cpanel/admin/contaBancaria/{array_id}/{estado}/activar_desactivar_conjunto', 'ContaBancariaController@activar_desactivar_conjunto');
Route::get('/cpanel/admin/contaBancaria/{id}/remover', 'ContaBancariaController@remover');
Route::get('/cpanel/admin/contaBancaria/{array_id}/remover_conjunto', 'ContaBancariaController@remover_conjunto');

Route::get('/cpanel/admin/faturacao/excel_entradas', 'FaturacaoController@excel_entradas');
Route::post('/cpanel/admin/faturacao/excel_entradas_filtros', 'FaturacaoController@excel_entradas_filtros');
Route::get('/cpanel/admin/faturacao/excel_entradas_total_comissao', 'FaturacaoController@excel_entradas_total_comissao');
Route::post('/cpanel/admin/faturacao/excel_entradas_total_comissao_filtros', 'FaturacaoController@excel_entradas_total_comissao_filtros');
Route::get('/cpanel/admin/faturacao/lista', 'FaturacaoController@index');
Route::get('/cpanel/admin/faturacao/total_por_parceiro', 'FaturacaoController@total_por_parceiro');
Route::post('/cpanel/admin/faturacao/total_por_parceiro_consulta', 'FaturacaoController@consultar_total_faturacao_por_parceiro');
Route::post('/cpanel/admin/faturacao/consultar', 'FaturacaoController@consultar');
Route::get('/cpanel/admin/faturacao/{objectos_json}/salvar_da_tabela', 'FaturacaoController@salvar_da_tabela');
Route::post('/cpanel/admin/faturacao/gravar', 'FaturacaoController@store');
Route::get('/cpanel/admin/faturacao/{id}/remover', 'FaturacaoController@remover');
Route::get('/cpanel/admin/faturacao/{array_id}/remover_conjunto', 'FaturacaoController@remover_conjunto');

Route::post('/cpanel/admin/captura/excel_capturas', 'CapturaController@excel_capturas');
Route::post('/cpanel/admin/captura/excel_captura_por_embarcacao', 'CapturaController@excel_consultar_captura_por_embarcacao');
Route::post('/cpanel/admin/captura/excel_captura_por_especie', 'CapturaController@excel_consultar_captura_por_especie');
Route::post('/cpanel/admin/captura/total_anual_consulta_excel', 'CapturaController@total_anual_consulta_excel');

Route::get('/cpanel/admin/captura/{id}/remover', 'CapturaController@remover');
Route::get('/cpanel/admin/captura/{array_id}/remover_conjunto', 'CapturaController@remover_conjunto');

Route::get('/cpanel/admin/captura/lista', 'CapturaController@index');
Route::post('/cpanel/admin/captura/consultar', 'CapturaController@consultar');
Route::get('/cpanel/admin/captura/captura_por_embarcacao', 'CapturaController@captura_por_embarcacao');
Route::post('/cpanel/admin/captura/consultar_por_embarcacao', 'CapturaController@consultar_captura_por_embarcacao');
Route::get('/cpanel/admin/captura/captura_por_especie', 'CapturaController@captura_por_especie');
Route::post('/cpanel/admin/captura/consultar_por_especie', 'CapturaController@consultar_captura_por_especie');
Route::post('/cpanel/admin/captura/total_anual_consulta', 'CapturaController@total_anual_consulta');

Route::get('/cpanel/admin/captura/anual', 'CapturaController@captura_anual');
Route::post('/cpanel/admin/captura/gravar', 'CapturaController@store');
Route::post('/cpanel/admin/captura/actualizar', 'CapturaController@update');

Route::get('/cpanel/admin/captura/app_captura_request', 'CapturaController@app_captura_lista');
Route::get('/cpanel/admin/captura/app_especies_request', 'CapturaController@app_especie_lista');
Route::post('/cpanel/admin/captura/filtro_android', 'CapturaController@filtro_android');

// ROUTES FOR ADMIN END
