<?php

namespace Modules\SICA\Http\Controllers\people;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SICA\Entities\Event;

class ConfigController extends Controller
{

    public function config(){
        $events = Event::orderBy('id','DESC')->get();
        $data = ['title'=>trans('sica::menu.Config'), 'events'=>$events];
        return view('sica::admin.people.config.home',$data);
    }

    public function addEventGet(){
        return view('sica::admin.people.config.events.add');
    }

    public function addEventPost(Request $request){
        $ev = new Event;
        $ev->name = e($request->input('name'));
        $ev->description = e($request->input('description'));
        $ev->start_date = e(Carbon::parse($request->input('start_date'))); /* Format the date to send to the database */
        $ev->end_date = e(Carbon::parse($request->input('end_date'))); /* Format the date to send to the database */
        $ev->state = e($request->input('state'));
        $card = 'card-events';
        if($ev->save()){
            $icon = 'success';
            $message_config = 'Evento registrado exitosamente.';
        }else{
            $icon = 'error';
            $message_config = 'No se pudo registrar evento.';
        }
        return back()->with(['card'=>$card, 'icon'=>$icon, 'message_config'=>$message_config]);
    }

    public function editEventGet($id){
        $event = Event::find($id);
        return view('sica::admin.people.config.events.edit',compact('event'));
    }

    public function editEventPost(Request $request){
        $ev = Event::findOrFail($request->input('id'));
        $ev->name = e($request->input('name'));
        $ev->description = e($request->input('description'));
        $ev->start_date = e(Carbon::parse($request->input('start_date'))); /* Format the date to send to the database */
        $ev->end_date = e(Carbon::parse($request->input('end_date'))); /* Format the date to send to the database */
        $ev->state = e($request->input('state'));
        $card = 'card-events';
        if($ev->save()){
            $icon = 'success';
            $message_config = 'Evento actualizado exitosamente.';
        }else{
            $icon = 'error';
            $message_config = 'No se pudo actualizar el evento.';
        }
        return back()->with(['card'=>$card, 'icon'=>$icon, 'message_config'=>$message_config]);
    }

    public function deleteEventGet($id){
        $event = Event::find($id);
        return view('sica::admin.people.config.events.delete',compact('event'));
    }

    public function deleteEventPost(Request $request){
        $ev = Event::findOrFail($request->input('id'));
        $card = 'card-events';
        if($ev->delete()){
            $icon = 'success';
            $message_config = 'Evento eliminado exitosamente.';
        }else{
            $icon = 'error';
            $message_config = 'No se pudo eliminar el evento.';
        }
        return back()->with(['card'=>$card, 'icon'=>$icon, 'message_config'=>$message_config]);
    }

}
