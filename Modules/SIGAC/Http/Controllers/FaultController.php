<?php

namespace Modules\SIGAC\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\SICA\Entities\Person;
use Modules\SIGAC\Entities\Fault;
use Modules\SIGAC\Entities\FaultType;

class FaultController extends Controller
{
    //Lista de faltas
    public function listfault(){

        $fault = Fault::get();

        return response ()->json($fault);
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
            'person_id' => 'required|integer',
            'fault_type_id' => 'required|integer',
        ]);

        // Obtener la fecha y hora actual
        $dateTime = now()->format('Y-m-d H:i:s');

        // Crear la nueva excusa
        $fault = new Fault();
        $fault->description = $request->description;
        $fault->person_id = $userId;
        $fault->datetime = $dateTime;
        $fault->fault_type_id = $request->fault_type_id;
        $fault->state = true; // Estado activo
        $fault->save();

        return response()->json(['message' => 'Falta creada exitosamente'], 201);
    }

    //funcion para modificar el estado la falta
    public function modificarFault(Request $request, $faultId)
    {
        $fault = Fault::where('id', $faultId)->first();
       
        

        // Verificar si la falta existe
        if (!$fault) {
            return response()->json(['error' => 'Falta no encontrada'], 404);
        }

        // Modificar el estado de la falta
        $fault->state = $request->state; // Estado tomado de la solicitud
        $fault->save();

        return response()->json(['message' => 'Falta modificada con éxito'], 200);
    }

    public function faulttype(Request $request)
    {
        // Crear tipo de falta
        $faultype = new FaultType();
        $faultype->name = $request->name;
        $faultype->save();

        return response()->json(['message'=>'Tipo de falta registrada'], 200);
    }
}
