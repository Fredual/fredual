<?php

namespace App\Http\Controllers\Admin;

use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecialtyController extends Controller
{
        public function index(){
        $specialties = Specialty::all();

        return view('specialty.index', compact('specialties'));
    }

    public function create(){
        return view('specialty.create');
    }

    public function sendData(Request $request){

        $rules = [
            'nombre' => 'required|min:3'
        ];

        $message = [
            'nombre.required' => ' El nombre de la especialidad es obligatorio.',
            'nombre.min' => ' El nombre de la especialidad debe contener al menos 3 caracteres'
        ];

        $this->validate($request, $rules, $message);

        $specialty = new Specialty();
        $specialty->nombre = $request->input('nombre');
        $specialty->descripcion = $request->input('descripcion');
        $specialty->save();

        $notification = ' La especialidad se ha creado correctamente.';

        return redirect('/especialidades')->with(compact('notification'));
    }

    public function edit(Specialty $specialty){

        return view('specialty.edit', compact('specialty'));

    }

    public function update(Request $request, Specialty $specialty){

        $rules = [
            'nombre' => 'required|min:3'
        ];

        $message = [
            'nombre.required' => ' El nombre de la especialidad es obligatorio.',
            'nombre.min' => ' El nombre de la especialidad debe contener al menos 3 caracteres'
        ];

        $this->validate($request, $rules, $message);

        $specialty->nombre = $request->input('nombre');
        $specialty->descripcion = $request->input('descripcion');
        $specialty->save();

        $notification = ' La especialidad se ha modificado correctamente.';

        return redirect('/especialidades')->with(compact('notification'));
    }

    public function destroy(Specialty $specialty){

        $deleteName = $specialty->nombre;
        $specialty->delete();

        $notification = ' La especialidad '.$deleteName.' se ha eliminado correctamente.';
        return redirect('/especialidades')->with(compact('notification'));
    }
    
}
