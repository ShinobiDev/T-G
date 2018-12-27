<?php

namespace App\Http\Controllers\Trabajos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Sede;
use App\Orden;
use App\User;
use App\ItemOrden;
use App\HistorialOrden;
use App\VariableEditable;
use App\Convencion;

class OrdenesController extends Controller
{
    public function crear()
    {
    	$user = auth()->user()->id;

		//dd($user);
		$sedes = Sede::select('id','nombre','telefono','direccion','contactoSede')
		->where('user_id','=',$user)
		->get();
		$convenciones = Convencion::select('id','nombre')
		->get();	

		return view('trabajos.ordenes.crear', compact('sedes','convenciones'));
    }

    //metodo para almacenar las nuevas ordenes ..................................................
    public function almacenar(Request $request)
    {
    	//dd($request);
    	//Almacenamos los datos de la orden
    	$orden = new Orden;
    	$orden->estado_id = 1;
    	$orden->user_id = auth()->user()->id;
    	$orden->convencion_id = $request->get('convencion');
    	$orden->trm = 2000;
    	$orden->save();    

        //Recorremos cada detalle que trae los productos relacionados a la Orden y los almacenamos
    	foreach ($request['sede'] as $key => $value) 
    	{
    		$item = new ItemOrden;
    		$item->estadoItem_id = 1;	
	    	$item->sede_id = $value;
            $item->orden_id = $orden->id;	    	
	    	$item->marca = $request['marca'][$key];
	    	$item->referencia = $request['referencia'][$key];
	    	$item->descripcion = $request['descripcion'][$key];
	    	$item->cantidad = $request['cantidad'][$key] ;
	    	$item->comentarios = $request['comentarios'][$key];
	    	$item->save();
    	}

    	//retornamos a la vista
    	return back()->with('flash','La orden ha sido creada');
    }

    //consulta de Ordenes sin Asignar .........................................................
    public function cotizadas()
    {   
        //$sinUsuario = Orden::where('ordens.estado_id','=',1)->get();

        $sinUsuario = Orden::select('ordens.id','ordens.created_at','estado_ordens.nombre','users.name')
        ->join('estado_ordens','ordens.estado_id','=','estado_ordens.id')
        ->join('users','ordens.user_id','=','users.id')
        ->where('ordens.estado_id','=','1')
        ->get();

        return view('trabajos.ordenes.cotizadas', compact('sinUsuario'));
    }

    //Detalle de las ordenes sin Asignar .......................................................
    public function detalleCotizadas($orden_id)
    {   
        $detalleOrden = itemOrden::select('sedes.nombre','item_ordens.marca','item_ordens.referencia','item_ordens.descripcion','item_ordens.cantidad','item_ordens.comentarios','item_ordens.orden_id')
        ->join('ordens','item_ordens.orden_id','=','ordens.id')
        ->join('sedes','item_ordens.sede_id','=','sedes.id')
        ->where('ordens.id','=',$orden_id)
        ->get();
        
        //dd($detalleOrden[0]->orden_id);
        $user = User::all();
        return view('trabajos.ordenes.detalleCotizadas', compact('detalleOrden','user'));
    }

    //Asignar usuario a la orden ..................................................................
    public function asignarUsuarioOrden(Request $request)
    {
        $UserGestiona = auth()->user()->id;

        $historialOrden = new historialOrden;
        $historialOrden->orden_id = $request->get('ordenId');
        $historialOrden->estadoAnterior_id = 1;
        $historialOrden->estadoActual_id = 2;
        $historialOrden->userGestiona_id = $UserGestiona;
        $historialOrden->userAsignado_id = $request->get('usuarioAsignado');
        $historialOrden->save();

        $Orden = Orden::where('id', $request->get('ordenId'))->first();
        $Orden->estado_id = 2;
        $Orden->update();

        return redirect('trabajos/ordenes/cotizadas')->with('flash','El Usuario fue asignado');
    }

    //Consulta de ordenes asignada...............................................................
    public function asignadas()
    {

        $ordenAsignadas = Orden::select('ordens.id','ordens.created_at','estado_ordens.nombre','users.name','historial_Ordens.userAsignado_id')
            ->join('estado_ordens','ordens.estado_id','=','estado_ordens.id')
            ->join('users','ordens.user_id','=','users.id')
            ->join('historial_Ordens','historial_Ordens.orden_id','ordens.id')
            ->where('ordens.estado_id','=',2)
            ->get();
        //dd($ordenAsignadas);                    
        return view('trabajos.ordenes.asignadas', compact('ordenAsignadas'));
    }

    //Detalle ordenes asignadas ..........................................................
    public function detalleAsignada($orden_id)
    {   
        //Seleccionamos los items correspondientes al id que traemos como parametro
        $detalleOrden = itemOrden::select('ordens.id','sedes.nombre','item_ordens.id','marca','referencia','descripcion','cantidad','comentarios')
        ->join('ordens','item_ordens.orden_id','=','ordens.id')
        ->join('sedes','item_ordens.sede_id','=','sedes.id')
        ->where('ordens.id','=',$orden_id)
        ->get();
        //dd($detalleOrden);
        $variables = VariableEditable::all();
        //dd($detalleOrden);
        return view('trabajos.ordenes.detalleAsignada', compact('detalleOrden','variables'))->with('orden_id',$orden_id);
    }    
        
}
