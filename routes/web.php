<?php


use App\Http\Controllers\AutorAdminController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\EditoraAdminController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\Pagamento;
use App\Http\Controllers\RequesicoesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AutoresController;
use App\Http\Controllers\EditorasController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminReviewController;
use App\Http\Controllers\ReviewsController;




Route::get('/', function () {
    return view('welcome');
});

Route::resource('livros', LivroController::class);
Route::resource('editoras', EditorasController::class);

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Livros
        Route::get('/livros/create', [LivroController::class, 'create'])->name('livros.create');
        Route::post('/livros', [LivroController::class, 'store'])->name('livros.store');
        Route::get('/livros/{livro}/edit', [LivroController::class, 'edit'])->name('livros.edit');
        Route::put('/livros/{livro}', [LivroController::class, 'update'])->name('livros.update');
        Route::delete('/livros/{livro}', [LivroController::class, 'destroy'])->name('livros.destroy');
        Route::get('/livrodetalhe/{livro}', [LivroController::class, 'show'])->name('detalhelivroadmin.show');

        // Editoras
        Route::get('/editoras', [EditorasController::class, 'index'])->name('editoras');
        Route::get('/editoras/create', [EditoraAdminController::class, 'create'])->name('editoras.create');
        Route::post('/editoras', [EditoraAdminController::class, 'store'])->name('editoras.store');
        Route::get('/editoras/{editora}/edit', [EditoraAdminController::class, 'edit'])->name('editoras.edit');
        Route::put('/editoras/{editora}', [EditoraAdminController::class, 'update'])->name('editoras.update');
        Route::delete('/editoras/{editora}', [EditoraAdminController::class, 'destroy'])->name('editoras.destroy');

        // Autores
        Route::get('/autores', action: [AutoresController::class, 'index'])->name('autores');
        Route::get('/autores/create', [AutorAdminController::class, 'create'])->name('autores.create');
        Route::post('/autores', [AutorAdminController::class, 'store'])->name('autores.store');
        Route::get('/autores/{autor}/edit', [AutorAdminController::class, 'edit'])->name('autores.edit');
        Route::put('/autores/{autor}', [AutorAdminController::class, 'update'])->name('autores.update');
        Route::delete('/autores/{autor}', [AutorAdminController::class, 'destroy'])->name('autores.destroy');

        //Admin
        Route::get('/criaradmin', [AdminController::class, 'create'])->name('criaradmin');
        Route::post('/store', [AdminController::class, 'store'])->name('store');
        Route::get('/todasrequesicoes', [ClienteController::class, 'index'])->name('todasrequesicoes');
        Route::get('/todasencomendas', [CarrinhoController::class, 'adminindex'])->name('todasencomendas');

        //GoogleBooksApi
        Route::get('/importar', [LivroController::class, 'formImportarGoogle'])->name('importarlivro.form');
        Route::post('/importar/salvar', [LivroController::class, 'salvarLivroGoogle'])->name('importarlivro.salvar');

        //Review
        Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews');
        Route::patch('/reviews/{id}/aprovar', [AdminReviewController::class, 'aprovar'])->name('reviews.aprovar');
        Route::patch('/admin/reviews/{id}/recusar', [AdminReviewController::class, 'recusar'])->name('reviews.recusar');

        Route::get('/logs', [LogController::class, 'index'])->name('log');

    });



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/autores', [AutoresController::class, 'index'])->name('autores');
    Route::get('/editoras', [EditorasController::class, 'index'])->name('editoras');
    Route::get('/requisicoes/{livro}', [RequesicoesController::class, 'show'])->name('requisicoes.show');
    Route::post('/requisicoes', [RequesicoesController::class, 'store'])->name('requisicoes.store');
    Route::get('/verequesicao', [ClienteController::class, 'show'])->name('verequesicao');
    Route::get('/livrodetalhe/{livro}', [DashboardController::class, 'show'])->name('detalhelivro.show');
    Route::post('/reviews', [ReviewsController::class, 'store'])->name('reviews.store');
    Route::post('/livro/{livro}/notificar', [DashboardController::class, 'notificar'])->name('livro.notificar');
    Route::get('/vercarrinho', [CarrinhoController::class, 'index'])->name('vercarrinho');
    Route::post('/carrinho', [CarrinhoController::class, 'store'])->name('adicionarcarrinho');
    Route::delete('/carrinho/remover/{id}', [CarrinhoController::class, 'destroy'])->name('carrinho.remover');
    Route::get('/carrinho/finalizar', [CarrinhoController::class, 'mostrarFinalizar'])->name('carrinho.finalizar');
    Route::post('/carrinho/processar', [CarrinhoController::class, 'processarPagamento'])->name('carrinho.processar');
    Route::get('/pagamento/sucesso', [Pagamento::class, 'sucesso'])->name('pagamento.sucesso');
    Route::patch('/requisicoes/{id}/devolver', [RequesicoesController::class, 'devolver'])->name('requisicoes.devolver');
    Route::put('/carrinho/{id}/atualizar', [CarrinhoController::class, 'atualizar'])->name('carrinho.atualizar');

});
