<?php

namespace Modules\SICA\Http\Controllers\academy;

use Dotenv\Parser\Lines;
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

    //-------------------Seccion de Líneas------------------------
    public function lines(){
        $line = Line::orderBy('updated_at','DESC')->get();
        $data = ['title'=>trans('sica::menu.Lines'),'lines'=>$line];
        return view('sica::admin.academy.lines.home',$data);
    }

    public function createLine(){
        return view('sica::admin.academy.lines.create');
    }

    public function storeLine(Request $request){
        $line = new Line;
        $line->name = e($request->input('name'));
        if($line->save()){
            $icon = 'success';
            $message_line = 'Línea tecnólogica agregada exitosamente.';
        }else{
            $icon = 'error';
            $message_line = 'No se pudo agregar la línea tecnológica.';
        }
        return back()->with(['icon'=>$icon, 'message_line'=>$message_line]);
    }

    public function editLine($id){
        $line = Line::find($id);
        return view('sica::admin.academy.lines.edit',compact('line'));
    }

    public function updateLine(Request $request){
        $line = Line::findOrFail($request->input('id'));
        $line->name = e($request->input('name'));
        if($line->save()){
            $icon = 'success';
            $message_line = 'Línea tecnólogica actualizada exitosamente.';
        }else{
            $icon = 'error';
            $message_line = 'No se pudo actualizar la línea tecnólogica.';
        }
        return back()->with(['icon'=>$icon, 'message_line'=>$message_line]);
    }

    public function deleteLine($id){
        $line = Line::find($id);
        return view('sica::admin.academy.lines.delete',compact('line'));
    }

    public function destroyLine(Request $request){
        $line = Line::findOrFail($request->input('id'));
        if($line->delete()){
            $icon = 'success';
            $message_line = 'Línea tecnólogica eliminada exitosamente.';
        }else{
            $icon = 'error';
            $message_line = 'No se pudo eliminar la línea tecnólogica.';
        }
        return back()->with(['icon'=>$icon, 'message_line'=>$message_line]);
    }

    //-------------------Seccion de Redes de Conocimiento------------------------
    public function networks(){
        $networks = Network::with('line')->orderBy('updated_at','DESC')->get();
        $data = ['title'=>trans('sica::menu.Networks'),'networks'=>$networks];
        return view('sica::admin.academy.networks.home',$data);
    }

    public function createNetwork(){
        $lines = Line::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('sica::admin.academy.networks.create', compact('lines'));
    }

    public function storeNetwork(Request $request){
        $network = new Network();
        $network->name = e($request->input('name'));
        $network->line()->associate(Line::find($request->input('line_id')));
        if($network->save()){
            $icon = 'success';
            $message_network = 'Red de conocimiento agregada exitosamente.';
        }else{
            $icon = 'error';
            $message_network = 'No se pudo agregar la red de conocimiento.';
        }
        return back()->with(['icon'=>$icon, 'message_network'=>$message_network]);
    }

    public function editNetwork($id){
        $network = Network::find($id);
        $lines = Line::orderBy('name', 'ASC')->pluck('name', 'id');
        $data = [
            'title' => 'Editar Red de Conocimiento',
            'network' => $network,
            'lines' => $lines
        ];
        return view('sica::admin.academy.networks.edit', $data);
    }

    public function updateNetwork(Request $request){
        $network = Network::find($request->input('id'));
        $network->name = e($request->input('name'));
        $network->line_id = e($request->input('line_id'));
        if($network->save()){
            $icon = 'success';
            $message_network = 'Red de conocimiento actualizada exitosamente.';
        }else{
            $icon = 'error';
            $message_network = 'No se pudo actualizar la red de conocimiento.';
        }
        return redirect()->back()->with(['icon'=>$icon, 'message_network'=>$message_network]);
    }

    public function deleteNetwork($id){
        $network = Network::find($id);
        $data = [ 'title' => 'Eliminar Red de Conocimiento', 'network' => $network,];
        return view('sica::admin.academy.networks.delete', $data);
    }

    public function destroyNetwork(Request $request){
        $network = Network::findOrFail($request->input('id'));
        if($network->delete()){
            $icon = 'success';
            $message_network = 'Red de conocimiento eliminada exitosamente.';
        }else{
            $icon = 'error';
            $message_network = 'No se pudo eliminar la red de conocimiento.';
        }
        return redirect()->back()->with(['icon'=>$icon, 'message_network'=>$message_network]);
    }

    //-------------------Seccion de Programas de Formación------------------------
    public function programs(){
        $programs = Program::with('network')->orderBy('sofia_code','desc')->get();
        $data = ['title'=>trans('sica::menu.Programs'),'programs'=>$programs];
        return view('sica::admin.academy.programs.home',$data);
    }

    public function createProgram(){
        $network = Network::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('sica::admin.academy.programs.create', compact('network'));
    }

    public function storeProgram(Request $request){
        $program = new Program();
        $program->sofia_code = e($request->input('sofia_code'));
        $program->program_type = e($request->input('program_type'));
        $program->name = e($request->input('name'));
        $program->network()->associate(Network::find($request->input('network_id')));
        if($program->save()){
            $icon = 'success';
            $message_program = 'Programa agregado exitosamente.';
        }else{
            $icon = 'error';
            $message_program = 'No se pudo agregar el programa.';
        }
        return back()->with(['icon'=>$icon, 'message_program'=>$message_program]);
    }

    public function editProgram($id){
        $program = Program::find($id);
        $network = Network::orderBy('name', 'ASC')->pluck('name', 'id');
        $data = [
            'title' => 'Editar programa de formación',
            'program' => $program,
            'network' => $network
        ];
        return view('sica::admin.academy.programs.edit', $data);
    }

    public function updateProgram(Request $request){
        $program = Program::find($request->input('id'));
        $program->sofia_code = e($request->input('sofia_code'));
        $program->program_type = e($request->input('program_type'));
        $program->name = e($request->input('name'));
        $program->network_id = e($request->input('network_id'));
        if($program->save()){
            $icon = 'success';
            $message_program = 'Programa de formación actualizado exitosamente.';
        }else{
            $icon = 'error';
            $message_program = 'No se pudo actualizar el programa de formación.';
        }
        return redirect()->back()->with(['icon'=>$icon, 'message_program'=>$message_program]);
    }

    public function deleteProgram($id){
        $program = Program::find($id);
        $data = [ 'title' => 'Eliminar programa de formación', 'program' => $program];
        return view('sica::admin.academy.programs.delete', $data);
    }

    public function destroyProgram(Request $request){
        $program = Program::findOrFail($request->input('id'));
        if($program->delete()){
            $icon = 'success';
            $message_program = 'Programa de formación eliminado exitosamente.';
        }else{
            $icon = 'error';
            $message_program = 'No se pudo eliminar el programa de formación.';
        }
        return redirect()->back()->with(['icon'=>$icon, 'message_program'=>$message_program]);
    }

    //-------------------Seccion de Titulaciones------------------------
    public function courses(){
        $courses = Course::with('program')->orderBy('code','desc')->get();
        $data = ['title'=>trans('sica::menu.Courses'),'courses'=>$courses];
        return view('sica::admin.academy.courses.home',$data);
    }

    public function createCourse(){
        $program = Program::orderBy('name', 'ASC')->pluck('name','id');
        return view('sica::admin.academy.courses.create', compact('program'));
    }

    public function storeCourse(Request $request){
        $course = new Course();
        $course->code = e($request->input('code'));
        $course->star_date = e($request->input('star_date'));
        $course->end_date = e($request->input('end_date'));
        $course->status = e($request->input('status'));
        $course->program()->associate(Program::find($request->input('program_id')));
        $course->deschooling = e($request->input('deschooling'));
        if($course->save()){
            $icon = 'success';
            $message_course = 'Titulación agregada exitosamente.';
        }else{
            $icon = 'error';
            $message_course = 'No se pudo agregar la titulación.';
        }
        return back()->with(['icon'=>$icon, 'message_course'=>$message_course]);
    }

    public function editCourse($id){
        $course = Course::find($id);
        $program = Program::orderBy('name', 'ASC')->pluck('name','id');
        $data = [
            'title' => 'Editar titulada',
            'course' => $course,
            'program' => $program
        ];
        return view('sica::admin.academy.courses.edit', $data);
    }

    public function updateCourse(Request $request){
        $course = Course::find($request->input('id'));
        $course->code = e($request->input('code'));
        $course->program_id = e($request->input('program_id'));
        $course->star_date = e($request->input('star_date'));
        $course->end_date = e($request->input('end_date'));
        $course->status = e($request->input('status'));
        $course->deschooling = e($request->input('deschooling'));
        if($course->save()){
            $icon = 'success';
            $message_course = 'Titulada actualizada exitosamente.';
        }else{
            $icon = 'error';
            $message_course = 'No se pudo actualizar la titulada.';
        }
        return redirect()->back()->with(['icon'=>$icon, 'message_course'=>$message_course]);
    }

    public function deleteCourse($id){
        $course = Course::find($id);
        $data = ['title' => 'Eliminar Titulada', 'course' => $course];
        return view('sica::admin.academy.courses.delete', $data);
    }

    public function destroyCourse(Request $request){
        $course = Course::findOrFail($request->input('id'));
        if($course->delete()){
            $icon = 'success';
            $message_course = 'Titulada eliminada exitosamente.';
        }else{
            $icon = 'error';
            $message_course = 'No se pudo eliminar la titulada.';
        }
        return redirect()->back()->with(['icon'=>$icon, 'message_course'=>$message_course]);
    }
}
