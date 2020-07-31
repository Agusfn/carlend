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


// Auth
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Cuenta
Route::get('cuenta', 'UsuarioController@detalles')->name('cuenta.detalles');
Route::post('cuenta', 'UsuarioController@modificar');
Route::get('cuenta/cambiar-password', 'UsuarioController@formularioPassword')->name('cuenta.cambiar-password');
Route::post('cuenta/cambiar-password', 'UsuarioController@cambiarPassword');

// Inicio
Route::get('/', 'InicioController@index')->name('inicio');

// Choferes
Route::resource("choferes", "ChoferesController")->except(["edit"]);

// Proveedores
Route::resource("proveedores", "ProveedoresController")->except(["edit"]);

// Vehiculos
Route::resource("vehiculos", "VehiculosController")->except(["edit"]);

// Trabajos de vehiculos
Route::resource("trabajos-vehiculos", "TrabajosVehiculosController")->except(["edit", "destroy"]);

// Alquileres
Route::get('alquileres/registrar', 'AlquileresController@create')->name("alquileres.create");
Route::resource("alquileres", "AlquileresController")->except(["create", "edit", "destroy"]);
Route::get('alquileres/{id}/registrar-pago', 'AlquileresController@formularioRegistrarPago')->name("alquileres.registrar-pago");
Route::post('alquileres/{id}/registrar-pago', 'AlquileresController@registrarPago');

// Gastos adicionales
Route::resource("gastos-adicionales", "GastosAdicionalesController")->except(["edit", "destroy"]);

// Reportes
Route::get('reportes/balances', 'ReportesController@mostrarBalances')->name("reportes.balances");
Route::get('reportes/vehiculos', 'ReportesController@mostrarVehiculos')->name("reportes.vehiculos");
Route::get('reportes/choferes', 'ReportesController@mostrarChoferes')->name("reportes.choferes");