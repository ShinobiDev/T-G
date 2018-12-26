<?php

namespace App\Http\Controllers\Trabajos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Sede;
use App\Orden;
use App\Convencion;

class OrdenesController extends Controller
{
    public function crear()
    {
    	$user = auth()->user()->id;

		//dd($user);
		$sedes = Sede::select('nombre','telefono','direccion','contactoSede')
		->where('user_id','=',$user)
		->get();

		$convencion = Convencion::select('id','nombre')
		->get();	

		return view('trabajos.ordenes.crear', compact('sedes','convencion'));


    }
}
