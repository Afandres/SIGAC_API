<?php

namespace Modules\SIGAC\Http\Controllers;

use Illuminate\Http\Request;
use Modules\SICA\Entities\Person;
use App\Http\Controllers\Controller;
use Modules\SIGAC\Entities\ApprenticePermission;
use Modules\SIGAC\Entities\PermissionType;
use Carbon\Carbon;

class ApprenticePermissionController extends Controller
{
    public function store(Request $request)
    {
        $userId = $request->input('person_id');

        $user = Person::find($userId);
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        // Validar los datos de entrada
        $request->validate([
            'person_id' => 'required|integer',
            'permission_type_id' => 'required|integer',
        ]);

        // Obtener la fecha y hora actual
        $dateTime = now()->format('Y-m-d H:i:s');

        // Crear permiso
        $permisison = new ApprenticePermission();
        $permisison->person_id = $userId;
        $permisison->datetime = $dateTime;
        $permisison->permission_type_id = $request->permission_type_id;
        $permisison->state = true; // Estado activo
        $permisison->save();

        return response()->json(['message' => 'Permiso creado exitosamente'], 201);
    }
    //funcion para modificar el estado del permiso
    public function modificarPermission(Request $request, $permissionId)
    {
    $permisison = ApprenticePermission::where('id', $permissionId)->first();
    $state = $request->input('state');

    // Verificar si el permiso existe
    if (!$permisison) {
        return response()->json(['error' => 'Permiso no encontrada'], 404);
    }

    // Modificar el estado de la permiso
    $permisison->state = $state; // Estado tomado de la solicitud
    $permisison->save();

    return response()->json(['message' => 'Permiso modificada con éxito'], 200);
    }

    // Registrar tipo de permiso
    public function permissiontype(Request $request)
    {
        // Crear tipo de excusa
        $faultype = new PermissionType();
        $faultype->name = $request->name;
        $faultype->save();

        return response()->json(['message'=>'Tipo de permiso registrado'], 200);
    }
}
