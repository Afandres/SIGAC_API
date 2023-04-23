<?php

namespace Modules\SICA\Http\Controllers\inventory;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SICA\Entities\Category;
use Modules\SICA\Entities\MeasurementUnit;

class ParameterController extends Controller
{

    public function index(){ // Carga de vista de parametros con la tabla de categorías
        $categories = Category::orderBy('updated_at', 'DESC')->get(); // Consultar categorías de manera descende por el dato updated_at
        $measurementUnit = MeasurementUnit::orderBy('updated_at', 'DESC')->get(); // Consultar measurementUnit de manera descende por el dato updated_at
        $data = ['title'=>trans('sica::menu.Parameters'),'categories'=>$categories, 'measurementUnit'=>$measurementUnit];
        return view('sica::admin.inventory.parameters.index',$data);
    }

    public function addCategoryGet(){
        return view('sica::admin.inventory.parameters.category.add');
    }

    public function addmeasurementUnitGet(){
        return view('sica::admin.inventory.parameters.measurementUnit.add');
    }

    public function addCategoryPost(Request $request){
        $c = new Category;
        $c->name = e($request->input('name'));
        $c->kind_of_property = e($request->input('kind_of_property'));
        $card = 'card-category';
        if($c->save()){
            $icon = 'success';
            $message_config = 'Categoria agregada exitosamente.';
        }else{
            $icon = 'error';
            $message_config = 'No se pudo agregar la categoria.';
        }
        return back()->with(['card'=>$card, 'icon'=>$icon, 'message_config'=>$message_config]);
    }

    public function addmeasurementUnitPost(Request $request){
        $m = new MeasurementUnit();
        $m->name = e($request->input('name'));
        $m->minimum_unit_measure = e($request->input('minimum_unit_measure'));
        $m->conversion_factor = e($request->input('conversion_factor'));
        $card = 'card-measurementUnit';
        if($m->save()){
            $icon = 'success';
            $message_config = 'Unidad de medida agregada exitosamente.';
        }else{
            $icon = 'error';
            $message_config = 'No se pudo agregar la Unidad de medida.';
        }
        return back()->with(['card'=>$card, 'icon'=>$icon, 'message_config'=>$message_config]);
    }

    public function editCategoryGet($id){
        $category = Category::find($id);
        return view('sica::admin.inventory.parameters.category.edit',compact('category'));
    }

    public function editmeasurementUnitGet($id){
        $measurementUnit = MeasurementUnit::find($id);
        return view('sica::admin.inventory.parameters.measurementUnit.edit',compact('measurementUnit'));
    }

    public function editCategoryPost(Request $request){
        $category = Category::findOrFail($request->input('id'));
        $category->name = e($request->input('name'));
        $category->kind_of_property = e($request->input('kind_of_property'));
        $card = 'card-category';
        if($category->save()){
            $icon = 'success';
            $message_config = 'Categoria actualizada exitosamente.';
        }else{
            $icon = 'error';
            $message_config = 'No se pudo actualizar la categoria.';
        }
        return back()->with(['card'=>$card, 'icon'=>$icon, 'message_config'=>$message_config]);
    }

    public function editmeasurementUnitPost(Request $request){
        $measurementUnit = MeasurementUnit::findOrFail($request->input('id'));
        $measurementUnit->name = e($request->input('name'));
        $measurementUnit->minimum_unit_measure = e($request->input('minimum_unit_measure'));
        $measurementUnit->conversion_factor = e($request->input('conversion_factor'));
        $card = 'card-measurementUnit';
        if($measurementUnit->save()){
            $icon = 'success';
            $message_config = 'Unidad de medida actualizada exitosamente.';
        }else{
            $icon = 'error';
            $message_config = 'No se pudo actualizar la Unidad de medida.';
        }
        return back()->with(['card'=>$card, 'icon'=>$icon, 'message_config'=>$message_config]);
    }

    public function deleteCategoryGet($id){
        $category = Category::find($id);
        return view('sica::admin.inventory.parameters.category.delete',compact('category'));
    }

    public function deletemeasurementUnitGet($id){
        $measurementUnit = MeasurementUnit  ::find($id);
        return view('sica::admin.inventory.parameters.measurementUnit.delete',compact('measurementUnit'));
    }

    public function deleteCategoryPost(Request $request){
        $category = Category::findOrFail($request->input('id'));
        $card = 'card-category';
        if($category->delete()){
            $icon = 'success';
            $message_config = 'Categoría eliminada exitosamente.';
        }else{
            $icon = 'error';
            $message_config = 'No se pudo eliminar la categoría.';
        }
        return back()->with(['card'=>$card, 'icon'=>$icon, 'message_config'=>$message_config]);
    }

    public function deletemeasurementUnitPost(Request $request){
        $measurementUnit = MeasurementUnit::findOrFail($request->input('id'));
        $card = 'card-measurementUnit';
        if($measurementUnit->delete()){
            $icon = 'success';
            $message_config = 'Unidad de medida eliminada exitosamente.';
        }else{
            $icon = 'error';
            $message_config = 'No se pudo eliminar la Unidad de medida.';
        }
        return back()->with(['card'=>$card, 'icon'=>$icon, 'message_config'=>$message_config]);
    }
}
