<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [EmployeeController::class, 'index']);

Route::get('/fetchAll', [EmployeeController::class, 'fetchAll'])->name('fetchAll');
Route::post('/store', [EmployeeController::class, 'store'])->name('store');
Route::get('/edit', [EmployeeController::class, 'edit'])->name('edit');
Route::post('/update', [EmployeeController::class, 'update'])->name('update');
Route::delete('/delete', [EmployeeController::class, 'delete'])->name('delete');
