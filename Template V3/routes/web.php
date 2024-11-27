<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', [OrderController::class, 'indexAdmin'])->name('index');

// Index - Menampilkan semua order
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

// Create - Menampilkan form untuk menambah order
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');

// Store - Menyimpan order baru
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

// Edit - Menampilkan form untuk mengedit order
Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');

// Update - Memperbarui order
Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');

// Destroy - Menghapus order
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');