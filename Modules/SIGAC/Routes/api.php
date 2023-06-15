<?php
use Illuminate\Http\Request;
use Modules\SIGAC\Http\Controllers\InstructorProgramController;
use Modules\SIGAC\Http\Controllers\AuthController;
use Modules\SIGAC\Http\Controllers\AttendanceController;
use Modules\SICA\Http\Controllers\people\ApprenticeController;
use Modules\SIGAC\Http\Controllers\PersonController;
use Modules\SIGAC\Http\Controllers\PointController;
use Modules\SIGAC\Http\Controllers\ExcuseController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/sigac/register', [AuthController::class, 'register']);
Route::post('/sigac/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->get('/sigac', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('sigac')->group(function (){
        // Logout
        Route::get('/logout', [AuthController::class, 'logout']);

        // Programacion instructor
        Route::get('/instructor_program/list/{instructor}/{date}/{time}', [InstructorProgramController::class, 'list']);

        // Asistencias
        Route::post('attendances', [AttendanceController::class, 'asistencia']);
        Route::get('attendances/list', [AttendanceController::class, 'listattendance']);
        Route::put('attendances/{attendanceId}', [AttendanceController::class, 'modificarAsistencia']);

        //excusas
        Route::get('excuses/list', [ExcuseController::class, 'listexcuse']);
        Route::post('excuses', [ExcuseController::class, 'store']);
        Route::put('excuses/{excuseId}', [ExcuseController::class, 'modificarExcuse']);
        Route::post('excusetype',[ExcuseController::class , 'excusetype']);//-> Registrar tipo de excusa

        //Aprendices
        Route::get('/apprentices/{courseCode}', [ApprenticeController::class, 'showApprenticesByCourseCode']);

        // Consulta estado completo de faltas, puntos, permisos y fallas
        Route::get('apprentice/listfull/{apprenticeId}', [ApprenticeController::class, 'listfull']);
        
        //Actualizar datos de la persona
        Route::put('person/updateinformation/{personId}', [PersonController::class, 'updateinformationPerson']);

        //puntos
        Route::delete('/points/{pointId}', [PointController::class, 'eliminarpoint']);
    });
});
