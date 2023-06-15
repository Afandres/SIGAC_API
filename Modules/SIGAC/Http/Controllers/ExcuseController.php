<?php

namespace Modules\SIGAC\Http\Controllers;

use App\Notifications\ExcuseEvidenceNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SIGAC\Entities\Excuse;
use Modules\SICA\Entities\Person;
use Modules\SIGAC\Entities\ExcuseType;


class ExcuseController extends Controller
{
    //Lista de excusas
    public function listexcuse(){

        $excuse = Excuse::get();

        return response ()->json($excuse);
    }
    public function store(Request $request)
    {

        $userId = $request->input('person_id');

        $user = Person::find($userId);
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        // Validar los datos de entrada
        $request->validate([
            'description' => 'required|string',
            'evidence' => 'required|file',
            'person_id' => 'required|integer',
            'excuse_type_id' => 'required|integer',
        ]);

        // Obtener la fecha actual
        $startDate = now();

        // Crear la nueva excusa
        $excuse = new Excuse();
        $excuse->description = $request->description;
        $excuse->excuse_type_id = $request->excuse_type_id;
        $excuse->evidence = $request->file('evidence')->store('excuse_evidence', 'custom');
        $excuse->person_id = $userId;
        $excuse->start_date = $startDate;
        $excuse->state = false; // Estado inactivo
        $excuse->save();

        /*$instructor = User::where('role', 'instructor')->first();
        if ($instructor) {
            $instructor->notify(new ExcuseEvidenceNotification($excuse));
            return response()->json(['message' => 'Notificacion exitosa'], 201);
        }*/

        return response()->json(['message' => 'Excuse creada exitosamente'], 201);
    }
    public function modificarExcuse(Request $request, $excuseId)
    {
    $excuse = Excuse::where('id', $excuseId)->first();
    $state = $request->input('state');

    // Verificar si la asistencia existe
    if (!$excuse) {
        return response()->json(['error' => 'Excusa no encontrada'], 404);
    }

    // Modificar el estado de la asistencia
    $excuse->state = $state; // Estado tomado de la solicitud
    $excuse->description = $request->description;
    $excuse->save();

    return response()->json(['message' => 'Excusa modificada con éxito'], 200);
    }

    // Registrar tipo de excusa
    public function excusetype(Request $request)
    {
        // Crear tipo de excusa
        $faultype = new ExcuseType();
        $faultype->name = $request->name;
        $faultype->save();

        return response()->json(['message'=>'Tipo de excusa registrada'], 200);
    }
}
