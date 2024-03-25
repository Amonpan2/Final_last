<?php
use App\Http\Controllers\C_todo;
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



Route::get('/', [C_todo::class,'index'] );
Route::post('/todo', [C_todo::class,'create']);
Route::put('/todo/{td_id}', [C_todo::class,'edit']);
Route::delete('/todo/{td_id}', [C_todo::class,'destroy']);


