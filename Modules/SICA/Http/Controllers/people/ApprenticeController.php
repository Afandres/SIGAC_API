<?php

namespace Modules\SICA\Http\Controllers\people;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SICA\Entities\Course;
use Modules\SIGAC\Entities\ApprenticePermission;
use Modules\SICA\Entities\Person;
use Modules\SICA\Entities\Apprentice;
use Modules\SICA\Imports\ApprenticeImport;

use Validator, Str, Excel;

class ApprenticeController extends Controller
{

    public function search_apprentices(){
        //$courses = Course::orderBy('code','Desc')->get();
        $courses = Course::orderBy('code','Desc')->get()->pluck('code_name','id');
        //$elections = Election::orderBy('id','Desc')->get();
        //Election::pluck('name', 'id');
        $data = ['title'=>trans('sica::menu.Search apprentice'),'courses'=>$courses];
        return view('sica::admin.people.apprentices.home',$data);
    }

	public function search(){
		$datas = json_decode($_POST['data']);
		if($datas->course_id):
			$course = Course::with('program')->findOrFail($datas->course_id);
			$apprentices = Apprentice::with('person')->where('course_id',$datas->course_id)->get();
			$data = ['course'=>$course,'apprentices'=>$apprentices];

            return view('sica::admin.people.apprentices.list',$data);
        else:
            return '<div class="row d-flex justify-content-center"><span class="h5 text-danger">No se encontró registros</span><div>';
        endif;
	}
    public function listfull($apprenticeId) {
        $apprentice = Apprentice::with(['person.faults', 'person.apprenticepermissions', 'person.points', 'person.attendances'])
            ->findOrFail($apprenticeId);
        
        $estados = [1, 0]; // Valores para Activo e Inactivo (en Fault, Permission, Point)
        $filteredFaults = $apprentice->person->faults->whereIn('state', $estados);
        $filteredPermissions = $apprentice->person->apprenticepermissions->whereIn('state', $estados);
        $filteredPoints = $apprentice->person->points->whereIn('state', $estados);

        $estados = ['FJ', 'FI', 'M']; // Valores normales (en Attendance)
        $filteredAttendances = $apprentice->person->attendances->whereIn('state', $estados);

        return response([
            'faults' => $filteredFaults,
            'permissions' => $filteredPermissions,
            'points' => $filteredPoints,
            'attendances' => $filteredAttendances
        ], 200);
    }
    public function showApprenticesByCourseCode($courseCode)
    {
        $course = Course::where('code', $courseCode)->first();

        if (!$course) {
            // Manejar el caso en que no se encuentre el curso
            return response()->json(['error' => 'Curso no encontrado'], 404);
        }

        $apprentices = $course->apprentices()->with('person.points', 'person.apprenticepermissions')->get();


        $apprenticesData = [];
    
        foreach ($apprentices as $apprentice) {
            $points = $apprentice->person->points;
            $permissions = $apprentice->person->apprentice_permissions;
    
            $apprenticesData[] = [
                'name' => $apprentice->person->first_name,
                'points' => $points,
                'permissions' => $permissions,
            ];
        }
    
        return response()->json($apprenticesData);
    }
    

}
