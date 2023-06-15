<?php

namespace Modules\SIGAC\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SIGAC\Entities\InstructorProgram;

class InstructorProgramController extends Controller
{
    public function list($instructor, $date, $time) {
        $list = InstructorProgram::with('course.apprentices.person')
            ->where('person_id', $instructor)
            ->where('date', $date)
            ->whereTime('start_time', '<=', $time)
            ->whereTime('end_time', '>=', $time)
            ->get();
    
        return response([
            'list' => $list
        ], 200);
    }
}
