<?php
use Illuminate\Support\Facades\Route;
use Modules\SICA\Http\Controllers\academy\AcademyController;

Route::middleware(['lang'])->group(function(){
    /* RUTAS PARA EL ROL DE ADMINISTRADOR */
    Route::prefix('sica/admin')->group(function() {
        // ------------- Rutas de Academy -------------
        Route::prefix('academy')->group(function(){
            // ------------ Rutas de Trimestres ------------------
            Route::get('/quarters', [AcademyController::class, 'quarters'])->name('sica.admin.academy.quarters');

            // ------------- Rutas de Titulaciones
            Route::get('/courses', [AcademyController::class, 'courses'])->name('sica.admin.academy.courses');

            // ------------Rutas de lineas-----------
            //Listar
            Route::get('/lines', [AcademyController::class, 'lines'])->name('sica.admin.academy.lines');

            //Agregar
            Route::get('/line/create', [AcademyController::class, 'createLine'])->name('sica.admin.academy.line.create');
            Route::post('/line/store', [AcademyController::class, 'storeLine'])->name('sica.admin.academy.line.store');

            //Editar
            Route::get('/line/edit/{id}', [AcademyController::class, 'editLine'])->name('sica.admin.academy.line.edit');
            Route::post('/line/edit', [AcademyController::class, 'updateLine'])->name('sica.admin.academy.line.update');

            // Eliminar
            Route::get('/line/delete/{id}', [AcademyController::class, 'deleteLine'])->name('sica.admin.academy.line.delete');
            Route::post('/line/delete/', [AcademyController::class, 'destroyLine'])->name('sica.admin.academy.line.destroy');

            // ------------- Rutas de Redes ----------------------
            //Listar
            Route::get('/network', [AcademyController::class, 'networks'])->name('sica.admin.academy.networks');

            //Agregar
            Route::get('/network/create', [AcademyController::class, 'createNetwork'])->name('sica.admin.academy.network.create');
            Route::post('/network/store', [AcademyController::class, 'storeNetwork'])->name('sica.admin.academy.network.store');

            //Editar
            Route::get('/network/edit/{id}', [AcademyController::class, 'editNetwork'])->name('sica.admin.academy.network.edit');
            Route::post('/network/update/', [AcademyController::class, 'updateNetwork'])->name('sica.admin.academy.network.update');

            //Eliminar
            Route::get('/network/delete/{id}', [AcademyController::class, 'deleteNetwork'])->name('sica.admin.academy.network.delete');
            Route::post('/network/delete/', [AcademyController::class, 'destroyNetwork'])->name('sica.admin.academy.network.destroy');

            // ------------- Rutas de Programas de Formación ---------------------
            //Listar
            Route::get('/programs', [AcademyController::class, 'programs'])->name('sica.admin.academy.programs');

            //Agregar
            Route::get('/program/create', [AcademyController::class, 'createProgram'])->name('sica.admin.academy.program.create');
            Route::post('/program/store', [AcademyController::class, 'storeProgram'])->name('sica.admin.academy.program.store');

            //Editar
            Route::get('/program/edit/{id}', [AcademyController::class, 'editProgram'])->name('sica.admin.academy.program.edit');
            Route::post('/program/update/', [AcademyController::class, 'updateProgram'])->name('sica.admin.academy.program.update');

            // Eliminar
            Route::get('/program/delete/{id}', [AcademyController::class, 'deleteProgram'])->name('sica.admin.academy.program.delete');
            Route::post('/program/delete/', [AcademyController::class, 'destroyProgram'])->name('sica.admin.academy.program.destroy');
        });
    });
}); 