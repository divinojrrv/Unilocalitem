<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ManifestacoesController;
use App\Http\Controllers\ResgatesController;
use App\Http\Controllers\UserController;








Route::get('/', [HomeController::class, 'index'])->name('login.telainicial');
Route::post('/', [HomeController::class, 'index']);

Route::get('/Usuario/CadastrarUser', [HomeController::class, 'cadastro']);
Route::post('/Home', [LoginController::class, 'realizar_Login']);





Route::middleware(['auth'])->group(function () {
<<<<<<< HEAD
  
  Route::get('/Home', [HomeController::class, 'homepubli'])->name('usuario.telainicial');
=======
>>>>>>> 3424f59d6f1afff9d452f9671e9ab8acfbc5137d

  Route::middleware(['web'])->group(function () {

      Route::post('/Home', [LoginController::class, 'realizar_Login']);
      Route::get('/Home', [HomeController::class, 'homepubli'])->name('usuario.telainicial');

      //Resgatar
      Route::get('/Publicacao/SolicitarResgate/{ID}', [ResgatesController::class, 'EditarPubliParaResgate'])->name('publicacoes.editresgate');
      Route::put('/SolicitarResgate-publicacao/{ID}', [ResgatesController::class, 'resgatarPublicacao'])->name('publicacoes.resgate');
      Route::put('/Publicacao/SolicitarResgate/{ID}', [ResgatesController::class, 'resgatarPublicacaoCancel'])->name('publicacoes.resgateCancel');

      Route::get('/Publicacao/Visualizar/{ID}', [ResgatesController::class, 'SolicitacaoResgateVisualizar'])->name('publicacoes.solicitacaoDeResgateVizualizar');
      Route::put('/ResgateConcluir-publicacao/{id}', [ResgatesController::class, 'resgatarPublicacaoConcluir'])->name('publicacoes.resgateConcluir');
      Route::delete('/Publicacao/SolicitarResgate/{ID}', [ResgatesController::class, 'destroy'])->name('publicacoes.resgateDelete');

      Route::get('/Publicacao/SolicitarResgateEdit/{ID}/{IdResgate}', [ResgatesController::class, 'ResgateEdit'])->name('resgate.edit');
      Route::put('/Publicacao/SolicitarResgateEdit/EditResgate-publicacao/{ID}/{IdResgate}', [ResgatesController::class, 'resgatarPublicacaoUpdate'])->name('publicacoes.resgateUpdate');

      Route::match(['get', 'put'], '/Publicacao/VisualizarSolicitacao', [ResgatesController::class, 'VisualizarSolicitacao'])->name('publicacoes.resgateVizualizar');

      //Publicacoes
      Route::get('/Publicacao/criar_alterar-publicacao/{ID}', [HomeController::class, 'EditarPubli'])->name('publicacoes.edit');
      Route::get('/Publicacao/criar_alterar-publicacao', [HomeController::class, 'CadastrarPubli'])->name('publicacoes.sget');
      Route::post('/Publicacao/criar_alterar-publicacao', [HomeController::class, 'NewPubli'])->name('publicacoes.store');
      Route::get('/Publicacao/criar_alterar-publicacao/{ID}', [HomeController::class, 'EditarPubli'])->name('publicacoes.edit');
      Route::put('/Publicacao/criar_alterar-publicacao/{ID}', [HomeController::class, 'update'])->name('publicacoes.update');
      Route::delete('/Publicacao/PubliPendentesUserComum/{ID}', [HomeController::class, 'destroy'])->name('publicacoes.delete');

      Route::get('/Publicacao/PubliPendentesUserComum', [HomeController::class, 'Publi_Pendente'])->name('publicacoes.pendentesView');
      Route::get('/Publicacao/PublicacoesPendentes', [HomeController::class, 'Publi_PendenteADM']);

      Route::get('/Publicacao/NaoAceitas', [HomeController::class, 'NaoAceitas'])->name('publicacoes.naceitas');
      Route::get('/Publicacao/NaoAceitasaADM', [HomeController::class, 'NaoAceitasaADM']);

      Route::get('/Publicacao/Visualizar', [HomeController::class, 'VisualizarResgate']);


      Route::get('/Publicacao/Consultar', [HomeController::class, 'Consultar']);
      Route::post('/Publicacao/Consultar', [HomeController::class, 'RealizarConsulta'])->name('consultar.publicacoes');

<<<<<<< HEAD
 
  Route::get('/Usuario/VisualizarUser', [HomeController::class, 'listar_user']);
  Route::get('/Usuario/alteraruser', [HomeController::class, 'AlterarUser_Engrenagem']);
  Route::get('/Usuario/alteraruserADM', [HomeController::class, 'AlterarUserADM']);
=======
      Route::get('/Usuario/CadastrarUser', [HomeController::class, 'cadastro']);
      Route::get('/Usuario/VisualizarUser', [HomeController::class, 'listar_user']);
      Route::get('/Usuario/alteraruser', [HomeController::class, 'AlterarUser_Engrenagem']);
      Route::get('/Usuario/alteraruserADM', [HomeController::class, 'AlterarUserADM']);
>>>>>>> 3424f59d6f1afff9d452f9671e9ab8acfbc5137d

      Route::get('/Usuario', [HomeController::class, 'store']);
      Route::post('/Usuario', [LoginController::class, 'store']);  
      Route::post('/Publicacao', [HomeController::class, 'cadastrar_resgate']);

      Route::put('/usuario/alteraruser/{ID}', [UserController::class, 'update'])->name('usuario.update');


      Route::get('/usuario/edit/{id}', [UserController::class, 'edit'])->name('usuario.edit');

      Route::match(['get', 'put'], '/Publicacao/PublicacoesPendentes', [HomeController::class, 'Publi_PendenteADM'])->name('publicacoes.pendentes');
      Route::put('/Publicacao/PublicacoesPendentes/atualizar-status/{ID}/{acaoValue?}', [HomeController::class, 'atualizarStatus_naoaceitasADM'])->name('atualizar.status');

      Route::get('/Usuario/alteraruserADM/{ID}', [UserController::class, 'editADM'])->name('usuario.editADM');
      Route::put('/Usuario/alteraruserADM/{ID}', [UserController::class, 'updateADM'])->name('usuario.updateADM');

      //Manifestar
      Route::put('/manifestar-publicacao/{id}', [ManifestacoesController::class, 'manifestarPublicacao'])->name('manifestar.publicacao');

      Route::put('/manifestaAceitar-publicacao/{id}', [ManifestacoesController::class, 'manifestaAceitar'])->name('manifestar.aceitar');
      Route::put('/manifestaRecusar-publicacao/{id}', [ManifestacoesController::class, 'manifestaRecusar'])->name('manifestar.recusar');

      Route::get('/Publicacao/ManifestacoesPublicacoes', [ManifestacoesController::class, 'ManifestacoesPublicacoes'])->name('manifestacoes.ManifestacoesPublicacoes');
      Route::get('/Publicacao/Manifestadas', [ManifestacoesController::class, 'Manifestadas'])->name('manifestacoes.manifestadas');


<<<<<<< HEAD

  
=======
      //Route::get('/', [HomeController::class, 'NaoAceitasADM'])->name('publicacoes.naoaceitasADM');
      //Route::get('/usuario/edit/{id}', [UsuarioController::class, 'editADM'])->name('usuario.editADM');


      //Route::get('/welcome', '\App\Http\Controllers\HomeController@welcome')->name('welcome');

      //Route::get('/login', 'LoginController@showLoginForm')->name('login');

      //Route::get('/', function () {
        // return view('login');
      //});

      require __DIR__.'/auth.php';

  });
>>>>>>> 3424f59d6f1afff9d452f9671e9ab8acfbc5137d

});

require __DIR__.'/auth.php';
