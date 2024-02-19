<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//PETICIONES PARA LAS VISTAS DE LA PAGINA
//Route::get('/', function () {
//    return view('tienda.nuevo');
//});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::get('/nuevo', function () {
//    return view('tienda.nuevo');
//})->name('nuevo.index');

//Route::get('/segunda', function () {
//    return view('tienda.segunda');
//})->name('segunda.index');
//
//Route::get('/editar', function () {
//    return view('tienda.editar');
//})->middleware(['auth', 'verified', 'Admin'])->name('editar.index');

//CARRITO

Route::get('/',[App\Http\Controllers\FrontController::class, 'index'])->name('nuevo.index');
Route::post('cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('add');
Route::get('cart/checkout',[App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');
Route::get('cart/clear',[App\Http\Controllers\CartController::class, 'clear'])->name('clear');
Route::post('cart/removeitem',[App\Http\Controllers\CartController::class, 'removeItem'])->name('removeitem');

//TRAMITAR PEDIDO

use App\Http\Controllers\CartController;

Route::post('/tramitarpedido', [CartController::class, 'tramitarPedido'])->name('tramitar.pedido');


//AÑADIR PRODUCTO

// Ruta para mostrar el formulario de agregar productos
Route::get('/anadirproducto', [ProductoController::class, 'mostrarFormulario'])->name('anadir.mostrar')->middleware(['auth', 'verified', 'Admin']);

// Ruta para procesar el formulario de agregar productos
Route::post('/anadirproducto', [ProductoController::class, 'agregarProducto'])->name('anadir.agregar');

//EDITAR PRODUCTO

Route::get('/productos/{id}/editar', [ProductoController::class, 'editarProducto'])->name('productos.editar');
Route::put('/productos/{id}/actualizar', [ProductoController::class, 'actualizarProducto'])->name('productos.actualizar');

//BORRAR PRODUCTO

Route::get('/productos/borrar/{id}', [App\Http\Controllers\ProductoController::class, 'borrar'])->name('productos.borrar');

// CATEGORIAS

Route::get('/productos', [App\Http\Controllers\FrontController::class, 'showByCategory'])->name('productos.mostrar');
Route::get('/resetear-categoria', [App\Http\Controllers\FrontController::class, 'resetearCategoria'])->name('resetear.categoria');

//PETICIONES PARA EL LOGIN
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
