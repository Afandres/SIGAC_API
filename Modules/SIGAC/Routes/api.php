<?php
use Illuminate\Http\Request;
use Modules\SIGAC\Http\Controllers\InstructorProgramController;
use Modules\SIGAC\Http\Controllers\AuthController;
use Modules\SIGAC\Http\Controllers\AttendanceController;
use Modules\SICA\Http\Controllers\people\ApprenticeController;
use Modules\SIGAC\Http\Controllers\PersonController;
use Modules\SIGAC\Http\Controllers\PointController;
use Modules\SIGAC\Http\Controllers\ExcuseController;
use Modules\SIGAC\Http\Controllers\FaultController;
use Modules\SIGAC\Http\Controllers\ApprenticePermissionController;
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

Route::post('/sigac/attendances', [AttendanceController::class, 'attendance']);
Route::post('/sigac/register', [AuthController::class, 'register']);
Route::post('/sigac/login', [AuthController::class, 'login']);
Route::get('/sigac/instructor_program/list/{instructor}/{date}/{time}', [InstructorProgramController::class, 'list']);

Route::middleware('auth:api')->get('/sigac', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('sigac')->group(function (){
        // Logout
        Route::get('user', [AuthController::class, 'user']);
        Route::put('user', [AuthController::class, 'update']);
        Route::get('logout', [AuthController::class, 'logout']);

        // Programacion instructor
        

        // Asistencias
       
        Route::get('attendances/list', [AttendanceController::class, 'listattendance']);
        Route::put('attendances/{attendanceId}', [AttendanceController::class, 'updateattendnce']);

        //excusas
        Route::get('excuses/list', [ExcuseController::class, 'listexcuse']);
        Route::post('excuses', [ExcuseController::class, 'store']);
        Route::put('excuses/{excuseId}', [ExcuseController::class, 'updateexcuse']);
        Route::post('excusetype',[ExcuseController::class , 'excusetype']);//-> Registrar tipo de excusa

        //Permisos
        Route::post('permissions', [ApprenticePermissionController::class, 'store']);
        Route::put('permissions/{permissionId}', [ApprenticePermissionController::class, 'updatepermisison']);
        Route::post('permissiontype',[ApprenticePermissionController::class , 'permissiontype']);//-> Registrar tipo de permiso

        //Faltas
        Route::get('faults/list', [FaultController::class, 'listfault']);
        Route::post('faults', [FaultController::class, 'store']);
        Route::put('faults/{faultId}', [FaultController::class, 'updatefault']);
        Route::post('faulttype',[FaultController::class , 'faulttype']);//-> Registrar tipo de falta

        //Aprendices
        Route::get('apprentices/{courseCode}', [ApprenticeController::class, 'showApprenticesByCourseCode']);

        // Consulta estado completo de faltas, puntos, permisos y fallas
        Route::get('apprentice/listfull/{apprenticeId}', [ApprenticeController::class, 'listful l']);
        
        //Actualizar datos de la persona
        Route::put('person/updateinformation/{personId}', [PersonController::class, 'updateinformationPerson']);

        //puntos
        Route::put('points/{pointId}', [PointController::class, 'updatepoint']);
        Route::post('points', [PointController::class, 'point']);
    });
});
