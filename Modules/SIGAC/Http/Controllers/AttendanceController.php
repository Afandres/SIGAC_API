<?php

namespace Modules\SIGAC\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\SICA\Entities\Person;
use Modules\SIGAC\Entities\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function asistencia(Request $request)
    {
        $userId = $request->input('person_id');
        $state = $request->input('state');

        // Verificar si el usuario existe
        $user = Person::find($userId);
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Tomar la fecha actual
        $fechaActual = Carbon::now()->format('Y-m-d');

        // Tomar la asistencia
        $attendance = new Attendance();
        $attendance->person_id = $userId;
        $attendance->state = $state; // Estado tomado de la solicitud
        $attendance->date = $fechaActual;
        $attendance->instructor_program_id = $request->instructor_program_id;
        $attendance->save();

        return response()->json(['message' => 'Asistencia tomada con éxito'], 200);
    }

    public function listattendance(){

        $attendance = Attendance::get();

        return response ()->json($attendance);
    }

    public function modificarAsistencia(Request $request, $attendanceId)
    {
    $attendance = Attendance::where('id', $attendanceId)->first();
    $state = $request->input('state');

    // Verificar si la asistencia existe
    if (!$attendance) {
        return response()->json(['error' => 'Asistencia no encontrada'], 404);
    }

    // Modificar el estado de la asistencia
    $attendance->state = $state; // Estado tomado de la solicitud
    $attendance->save();

    return response()->json(['message' => 'Asistencia modificada con éxito'], 200);
    }


    
}
