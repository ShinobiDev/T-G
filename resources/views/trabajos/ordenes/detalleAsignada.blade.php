@extends('admin.layout')

@section('contenido')
	<div class="box box-warning">
	    <div class="box-header col-md-12">
	      <h3 class="box-title">Detalles de la Orden # </h3>
	    </div>
	    <!-- /.box-header -->

	    <form class="form" method="POST" action="{{-- route('admin.ordenes.update') --}}">
		{{ csrf_field() }}
	    <div class="box-body table-responsive col-md-12 bg-warning">
	    	<input type="hidden" name="ordenId" value="{{$orden_id}}">
		      <table class="table table-bordered table-striped">
		        <thead style="overflow-y: hidden;">
		        	<tr class="bg-warning">
		        		<th>Sede</th>
		        		<th>Marca</th>
		        		<th>Referencia</th>
		        		<th>Descripción</th>
		        		<th>Cantidad</th>
		        		<th>Comentarios</th>
		        		<th>Peso Lbs</th>
		        		<th>Total Peso Libra</th>
		        		<th>Costo Flete Unidad</th>
		        		<th>Costo Total Flete</th>
		        		<th></th>
		        		<th>Costo Unitario</th>
		        		<th>Margen USA</th>
		        		
		        		<!--<th>Venta Unitario</th>
		        		<th>Total USD</th>
		        		<th>Entrega Proveedor</th>
		        		<th>Bodega</th>
		        		<th>Recepción Bodega</th>
		        		<th>Diás Reales Entrega</th>-->
		        	</tr>
		        </thead>
		        
		        <tbody id="detalle">
		        	
			        	@foreach($detalleOrden as $detalle)	
			        		<tr>
			        			<td>{{ $detalle->nombre }}</td>
			        			<td>{{ $detalle->marca }}</td>
			        			<td>{{ $detalle->referencia }}</td>
			        			<td>{{ $detalle->descripcion }}</td>
			        			<td>{{ $detalle->cantidad }}</td>
			        			<td>{{ $detalle->comentarios }}</td>
			        			<td>
			        				<input name="pesoLibra[]" id="pesoLibra{{$detalle->id}}" value="{{$detalle->pesoLibra}}" onchange="calculalPesoLibras({{$detalle->id}},this,{{$detalle->cantidad}})">

			        				<input type="hidden" id="valorPesoLibra{{$detalle->id}}" value="{{$variables[1]->valor}}">
			        			</td>
			        			@php
			        				$costoFleteUnidad = $variables[1]->valor * $detalle->pesoLibra;
			        				$totalPeso = $detalle->cantidad * $detalle->pesoLibra;
			        				$costoTotalFlete = $costoFleteUnidad * $totalPeso;
			        				
			        			@endphp	
			        			<td class="bg-success">
			        				<label id="totalPesoLibra{{$detalle->id}}">{{$totalPeso}}</label>
			        			</td>			        			        			
			        			<td class="bg-danger">
			        				<label id="costoFlete{{$detalle->id}}">{{$costoFleteUnidad}}</label>
			        			</td>
			        			<td class="bg-danger">
			        				<label id="costoTotalFlete{{$detalle->id}}">{{$costoTotalFlete}}</label>
			        			</td>
			        			
			        				<td><input name="costoUnitario[]" placeholder="Costo Unitario"></td>
			        			
			        			<td><input name="margenUsa[]" placeholder="{{$detalle->margenUsa}}"></td>        			
			        			
			        			<td><input type="hidden" name="detalle_id[]" value="{{$detalle->id}}"></td>
			        			
			        		</tr>
			        	@endforeach
		        	
		        </tbody>
		      	</table>
	      <!--Seccion solo para el Administrador-->
	      <!--Asignar Usuario para gestionar la orden-->
	      	<hr>
      	</div>
		<div class="form-group col-md-offset-4">
    		<button type="submit" class="btn btn-primary col-md-5">Actualizar la Orden</button>
    	</div>
    	</form>
    </div>
    <script type="text/javascript">
    	function calculalPesoLibras(id,e,cant)
    	{
    		var costoFlete = e.value*document.getElementById('valorPesoLibra'+id).value;
    		document.getElementById('costoFlete'+id).innerHTML = number_format(costoFlete, 2, ',','.');

    		var totalPesoLibra = cant*document.getElementById('pesoLibra'+id).value;
    		document.getElementById('totalPesoLibra'+id).innerHTML = number_format(totalPesoLibra, 2, ',','.');

    		var costoTotalFlete = costoFlete * totalPesoLibra;
    		document.getElementById('costoTotalFlete'+id).innerHTML = number_format(costoTotalFlete, 2, ',','.');
    	}
    </script>
    
@stop