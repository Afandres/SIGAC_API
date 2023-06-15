<?php

namespace Modules\SIGAC\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SICA\Entities\Person;
use Modules\SIGAC\Entities\Point;
use Carbon\Carbon;

class PointController extends Controller
{
    public function points(Request $request)
    {
    $userId = $request->input('person_id');
    $state = $request->input('state');

    $user = Person::find($userId);
    if (!$user) {
        return response()->json(['error' => 'Usuario no encontrado'], 404);
    }
    // Validar los datos de entrada
    $request->validate([
        'person_id' => 'required|integer',
        'state' => 'required|boolean',
        'ammount' => 'required|integer',
        'issue' => 'required|string'
    ]);

    // Obtener la fecha actual
    $date = now();

    // Crear permiso
    $excuse = new Point();
    $excuse->person_id = $userId;
    $excuse->date = $date;
    $excuse->issue = $request->issue;
    $excuse->ammount = $request->ammount;
    $excuse->state = $state;
    $excuse->save();

    return response()->json(['message' => 'Punto creado exitosamente'], 201);

    }
    public function eliminarpoint(Request $request, $pointId)
    {
    $punto = Point::find($pointId);

    // Verificar si la asistencia existe
    if (!$punto) {
        return response()->json(['error' => 'Punto no encontrada'], 404);
    }

    // Modificar el estado de la asistencia
    $punto->delete();

    return response()->json(['message' => 'Punto eliminado'], 200);
    }
}
