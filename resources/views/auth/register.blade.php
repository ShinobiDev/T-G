@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box">
                <div class="box-body">
                    <form method="POST" action="{{ route('almacenarUsuario') }}">
                        {{ csrf_field() }}

                        <div class="form-group col-md-6">
                            <label for="name" class="col-form-label text-md-right">Nombre Completo</label>
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif                            
                        </div>

                        <div class="form-group col-md-6">
                            <label for="email" class="col-form-label text-md-right">E-mail</label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="password" class="col-form-label text-md-right">Contraseña</label>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password-confirm" class="col-form-label text-md-right">Confirme la contraseña</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <div class="panel panel-info col-md-12">
                            <div class="panel-heading">
                                <h3 class="panel-title">Agregar las sedes</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group col-md-6">
                                    <label for="nombreSede" class="col-form-label text-md-right text-primary">Nombre de la sede</label>
                                    <input id="nombreSede" type="text" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="nombreSede" required>
                                    @if ($errors->has('nombreSede'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nombreSede') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="direccionSede" class="col-form-label text-md-right text-primary">Dirección de la sede</label>
                                    <input id="direccionSede" type="text" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="direccionSede" required>
                                    @if ($errors->has('direccionSede'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('direccionSede') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="telefonoSede" class="col-form-label text-md-right text-primary">Telefono de la sede</label>
                                    <input id="telefonoSede" type="number" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="telefonoSede" required>
                                    @if ($errors->has('telefonoSede'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('telefonoSede') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="contactoSede" class="col-form-label text-md-right text-primary">Nombre de contacto</label>
                                    <input id="contactoSede" type="text" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="contactoSede" required>
                                    @if ($errors->has('contactoSede'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('contactoSede') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2 col-md-offset-4">
                                        <input class="btn btn-success" value="Agregar Sede" onclick="agregar_a_list()">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4 col-md-offset-4">
                                        <h4 class="text-primary"><strong>Datos de las sedes</strong></h4>
                                    </div>
                                </div>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-danger">
                                            <th>Nombre</th>
                                            <th>Dirección</th>
                                            <th>Telefono</th>
                                            <th>Contacto</th>
                                        </tr>
                                    </thead>

                                    <tbody id="body_table">
                                        
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary" value="Registrar">
                            </div>
                        </div>
                    </form>
                    <script type="text/javascript">

                        var arreglo=[];

                        function agregar_a_list(){
                            
                            var ob={
                                nombreSede:document.getElementById('nombreSede').value,
                                direccionSede:document.getElementById('direccionSede').value,
                                telefonoSede:document.getElementById('telefonoSede').value,
                                contactoSede:document.getElementById('contactoSede').value
                            };

                            arreglo.push(ob);
                            
                            document.getElementById('nombreSede').value="";
                            document.getElementById('direccionSede').value="";   
                            document.getElementById('telefonoSede').value="";
                            document.getElementById('contactoSede').value="";
                            
                            draw_table();
                        }

                        function draw_table(){
                            console.log(arreglo);
                            var t = document.getElementById('body_table');
                            //limpio lo que tenia en la tabla
                            t.innerHTML="";
                            for(var f in arreglo){

                                //creo un tr
                                var tr = document.createElement('tr');  
                                //creo un td
                                
                                var td = document.createElement('td');  
                                //creo un label
                                var label = document.createElement('label');
                                var hd = document.createElement('input');
                                hd.setAttribute('type','hidden');
                                hd.setAttribute('name','nombreSede[]');
                                hd.value=arreglo[f].nombreSede;    
                                label.innerHTML=arreglo[f].nombreSede;
                                td.appendChild(hd);
                                td.appendChild(label);
                                //agrego el campo a la fila de la tabla
                                tr.appendChild(td);
                                
                                var td = document.createElement('td');  
                                //creo un label
                                var label = document.createElement('label');
                                var hd = document.createElement('input');
                                hd.setAttribute('type','hidden');
                                hd.setAttribute('name','direccionSede[]');
                                hd.value=arreglo[f].direccionSede;    
                                label.innerHTML=arreglo[f].direccionSede;
                                td.appendChild(hd);
                                td.appendChild(label);
                                //agrego el campo a la fila de la tabla
                                tr.appendChild(td);
                                
                                var td = document.createElement('td');  
                                //creo un label
                                var label = document.createElement('label');
                                var hd = document.createElement('input');
                                hd.setAttribute('type','hidden');
                                hd.setAttribute('name','telefonoSede[]');
                                hd.value=arreglo[f].telefonoSede;    
                                label.innerHTML=arreglo[f].telefonoSede;
                                td.appendChild(hd);
                                td.appendChild(label);
                                //agrego el campo a la fila de la tabla
                                tr.appendChild(td);
                                
                                var td = document.createElement('td');  
                                //creo un label
                                var label = document.createElement('label');
                                var hd = document.createElement('input');
                                hd.setAttribute('type','hidden');
                                hd.setAttribute('name','contactoSede[]');
                                hd.value=arreglo[f].contactoSede;    
                                label.innerHTML=arreglo[f].contactoSede;
                                td.appendChild(hd);
                                td.appendChild(label);
                                //agrego el campo a la fila de la tabla
                                tr.appendChild(td);
                                
                                //agrego la fila a el cuerpo de la tabla
                                t.appendChild(tr);
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
