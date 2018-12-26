<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Sede;
use App\Events\UsuarioCreado;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function almacenarUsuario(Request $request)
    {   
        //dd($request);

        //Instanciamos un objeto del modelo User, para guardar los datos en la BD
        $user = new User;

        $pass = str_random(8);    
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt($pass);
        $user->rol_id = 3;
        $user->save();    

        //Recorremos cada sede y la almacenamos
        foreach ($request['nombreSede'] as $key => $value) {

            $sede = new Sede;   
            
            $sede->user_id = $user->id;
            $sede->nombre = $value;            
            $sede->direccion = $request['direccionSede'][$key];
            $sede->telefono = $request['telefonoSede'][$key];
            $sede->contactoSede = $request['contactoSede'][$key];
            $sede->save();
        }

        $user = $user->email;
        //Enviamos el email con las credenciales de acceso
        UsuarioCreado::dispatch($user, $pass);
        return redirect('/login')->with('flash','El usuario fue creado exitosamente');
    }
}
