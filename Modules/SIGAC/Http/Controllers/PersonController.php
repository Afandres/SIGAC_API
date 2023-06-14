<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;

class PersonController extends Controller
{
    public function updateinformationPerson(Request $request, $personId )
    {
        $person = Person::where('id', $personId)->first();

        if (!$person) {
            return response()->json(['Error:' =>'Persona no encontrada'], 200);
        }

        $fields = [
            'telephone' => 'telephone',
            'personal_email' => 'personal_email',
            // Agrega más campos aquí si es necesario
        ];
        
        foreach ($fields as $personField => $requestField) {
            if (isset($request->$requestField)) {
                $person->$personField = $request->$requestField;
            }
        }

        $person->save();

        return response()->json(['message:' =>'Datos actualizado'], 200);

    }
}
