<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    
    public function index()
    {
        $doctors = User::doctors()->paginate(10);
        return view('doctors.index', compact('doctors'));
    }


    public function create()
    {
        return view('doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'cedula' => 'required|min:5',
            'address' => 'nullable|min:6',
            'phone' => 'required',
        ];

        $message = [
            'name.required' => ' El nombre del médico es obligatorio',
            'name.min' => ' El nombre del médico debe tener más de 3 caracteres',
            'email.required' => ' El correo electronico del médico es obligatorio',
            'email.email' => ' Ingresa una dirección de correo válido',
            'cedula.required' => ' La cédula del médico es obligatorio',
            'cedula.min' => ' La cédula debe debe tener al menos 5 digitos',
            'address.min' => ' La dirección debe tener al menos 6 caracteres',
            'phone.required' => ' El número de teléfono es obligatorio'
        ];

        $this->validate($request,$rules,$message);

        User::create(
            $request->only('name','email','cedula','address','phone')
            + [
                'role' => 'doctor',
                'password' => bcrypt($request->input('password'))
            ]
        );

        $notification = ' El médico se ha registrado correctamente';

        return redirect('/medicos')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {  
        $doctor = User::doctors()->findOrFail($id);
        return view('doctors.edit',compact('doctor'));
    }

    public function update(Request $request, string $id)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'cedula' => 'required|min:5',
            'address' => 'nullable|min:6',
            'phone' => 'required',
        ];

        $message = [
            'name.required' => ' El nombre del médico es obligatorio',
            'name.min' => ' El nombre del médico debe tener más de 3 caracteres',
            'email.required' => ' El correo electronico del médico es obligatorio',
            'email.email' => ' Ingresa una dirección de correo válido',
            'cedula.required' => ' La cédula del médico es obligatorio',
            'cedula.min' => ' La cédula debe debe tener al menos 5 digitos',
            'address.min' => ' La dirección debe tener al menos 6 caracteres',
            'phone.required' => ' El número de teléfono es obligatorio'
        ];

        $this->validate($request,$rules,$message);
        $user = User::doctors()->findOrFail($id);

        $data = $request->only('name','email','cedula','address','phone');
        $password = $request->input('password');

        if($password){
            $data['password'] = bcrypt($password);
        }

        $user->fill($data);
        $user->save();

        $notification = ' La informacion del médico se actualizo correctamente';

        return redirect('/medicos')->with(compact('notification'));
    }


    public function destroy(string $id)
    {
        $user = User::doctors()->findOrFail($id);
        $doctorName = $user->name;
        $user->delete();

        $notification = " El médico $doctorName se elimino correctamente";

        return redirect('/medicos')->with(compact('notification'));
    }

}
