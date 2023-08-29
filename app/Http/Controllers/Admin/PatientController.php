<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    public function index()
    {
        $patients = User::patients()->paginate(10);
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
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
            'name.required' => ' El nombre del paciente es obligatorio',
            'name.min' => ' El nombre del paciente debe tener más de 3 caracteres',
            'email.required' => ' El correo electronico del paciente es obligatorio',
            'email.email' => ' Ingresa una dirección de correo válido',
            'cedula.required' => ' La cédula del paciente es obligatorio',
            'cedula.min' => ' La cédula debe debe tener al menos 5 digitos',
            'address.min' => ' La dirección debe tener al menos 6 caracteres',
            'phone.required' => ' El número de teléfono es obligatorio'
        ];

        $this->validate($request,$rules,$message);

        User::create(
            $request->only('name','email','cedula','address','phone')
            + [
                'role' => 'paciente',
                'password' => bcrypt($request->input('password'))
            ]
        );

        $notification = ' El paciente se ha registrado correctamente';

        return redirect('/pacientes')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $patient = User::Patients()->findOrFail($id);
        return view('patients.edit',compact('patient'));
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
            'name.required' => ' El nombre del paciente es obligatorio',
            'name.min' => ' El nombre del paciente debe tener más de 3 caracteres',
            'email.required' => ' El correo electronico del paciente es obligatorio',
            'email.email' => ' Ingresa una dirección de correo válido',
            'cedula.required' => ' La cédula del paciente es obligatorio',
            'cedula.min' => ' La cédula debe debe tener al menos 5 digitos',
            'address.min' => ' La dirección debe tener al menos 6 caracteres',
            'phone.required' => ' El número de teléfono es obligatorio'
        ];

        $this->validate($request,$rules,$message);
        $user = User::Patients()->findOrFail($id);

        $data = $request->only('name','email','cedula','address','phone');
        $password = $request->input('password');

        if($password){
            $data['password'] = bcrypt($password);
        }

        $user->fill($data);
        $user->save();

        $notification = ' La informacion del paciente se actualizo correctamente';

        return redirect('/pacientes')->with(compact('notification'));
    }

    public function destroy(string $id)
    {
        $user = User::Patients()->findOrFail($id);
        $patientName = $user->name;
        $user->delete();

        $notification = " El paciente $patientName se elimino correctamente";

        return redirect('/pacientes')->with(compact('notification'));
    }
}
