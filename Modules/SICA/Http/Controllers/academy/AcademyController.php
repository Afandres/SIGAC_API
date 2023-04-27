<?php

namespace Modules\SICA\Http\Controllers\academy;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SICA\Entities\Course;
use Modules\SICA\Entities\Program;
use Modules\SICA\Entities\Network;
use Modules\SICA\Entities\Line;

class AcademyController extends Controller
{
 
    public function quarters(){
        $data = ['title'=>trans('sica::menu.Quarters')];
        return view('sica::admin.academy.quarters.home',$data);
    }

    public function curriculums(){
        $programs = Program::with('network')->orderBy('sofia_code','desc')->get();
        $data = ['title'=>trans('sica::menu.Curriculums'),'programs'=>$programs];
        return view('sica::admin.academy.curriculums.home',$data);
    }

    public function courses(){
        $courses = Course::with('program')->orderBy('code','desc')->get();
        $data = ['title'=>trans('sica::menu.Courses'),'courses'=>$courses];
        return view('sica::admin.academy.courses.home',$data);
    }

    public function networks(){
        $networks = Network::with('line')->orderBy('id','asc')->get();
        $data = ['title'=>trans('sica::menu.Networks'),'networks'=>$networks];
        return view('sica::admin.academy.networks.home',$data);
    }

    //-------------------Seccion de Líneas------------------------
    public function lines(){
        $line = Line::orderBy('updated_at','DESC')->get();
        $data = ['title'=>trans('sica::menu.Lines'),'lines'=>$line];
        return view('sica::admin.academy.lines.home',$data);
    }

    public function createLines(){
        return view('sica::admin.academy.lines.create');
    }

    public function storeLines(Request $request){
        $line = new Line;
        $line->name = e($request->input('name'));
        $card = 'card-lines';
        if($line->save()){
            $icon = 'success';
            $message_parameter = 'Líneas agregada exitosamente.';
        }else{
            $icon = 'error';
            $message_parameter = 'No se pudo agregar la línea.';
        }
        return back()->with(['card'=>$card, 'icon'=>$icon, 'message_parameter'=>$message_parameter]);
    }

}
