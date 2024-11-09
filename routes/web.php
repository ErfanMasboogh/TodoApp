<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TodoController;
use App\Http\Middleware\LoginCheck;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;


Route::middleware(LoginCheck::class)->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get(
        '/dashboard',
        [CategoryController::class, 'dashboard']
    )->middleware(['auth', 'verified'])->name('dashboard');
    # ------------------------------
    Route::get('/new', [TodoController::class, 'new'])->name('todo.new');
    Route::post('/new', [TodoController::class, 'store'])->name('todo.store');
    Route::get('/completed', [TodoController::class, 'completed'])->name('todo.completed');
    Route::get('/uncompleted', [TodoController::class, 'uncompleted'])->name('todo.uncompleted');
    Route::post('/', [HomeController::class, 'statusChanged'])->name('todo.statusChanged');
    Route::delete('/delete/{todo}', [TodoController::class, 'delete'])->name('todo.delete');
    Route::put('/edit/{todo}', [TodoController::class, 'edit'])->name('todo.edit');
    Route::post('/edit/{todo}', [TodoController::class, 'update'])->name('todo.update');

    Route::group(['prefix' => '/category'], function () {
        Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
        Route::post('/update/{category}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/delete/{category}', [CategoryController::class, 'delete'])->name('category.delete');
    });
    # ------------------------------

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
