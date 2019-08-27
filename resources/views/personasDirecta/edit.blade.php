@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            @if (count($errors)>0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 text-uppercase col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><span class="text-bold text-info">Editar Datos del Asesor - ID: {{$persona->id_persona}}</span></div>

                    <div class="panel-body">
                        {!!Form::model ($persona, ['method'=>'PATCH', 'route'=>['representantes_directa.update', $persona]])!!}
                        {{Form::token()}}

                        <input type="hidden" name="url" value="{{URL::previous ()}}">
                        <div class="form-group">
                            <div class="col-md-3">
                                <label for="name">CH</label>
                                <input type="number" name="ch" required value="{{$persona->ch}}" class="form-control text-uppercase" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3">
                                <label for="name">Fecha Ingreso</label>
                                <input type="text" name="fecha_ingreso" required value="{{$persona->fecha_ingreso}}" class="form-control text-uppercase" placeholder="DD/MM/YYYY">
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <div class="">
                                <label for="name">Documento</label>
                                <input type="text" name="documento_persona" required value="{{$persona->documento_persona}}" class="form-control text-uppercase" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <div class="">
                                <label for="name">Staff</label>
                                <input type="number" name="staff"  value="{{$persona->staff}}" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="">Nombre del Asesor</label>
                            <input type="text" name="nombre" required value="{{$persona->nombre}}" class="form-control text-uppercase" disabled="disabled">
                        </div>


                        <div class="form-group">
                            <label for="">Representante Jefe</label>
                            <select name="rep_jefe_id" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione Representante Jefe">
                                @foreach($jefes as $jefe )
                                    @if($persona->id_representante_jefe == $jefe->id_persona)
                                        <option value="{{$jefe->id_persona}}" selected>{{strtoupper ($jefe->nombre)}}-->{{$jefe->zona->zona}}</option>
                                    @else
                                        <option value="{{$jefe->id_persona}}">{{strtoupper ($jefe->nombre)}}-->{{$jefe->zona->zona}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-offset-0 col-md-4">
                            <label for="">Cargo GO</label>
                            <select name="cargo_go" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione Cargo" required>
                                @foreach($cargos_go as $cargo )
                                    @if($persona->cargo_go == $cargo)
                                        <option value="{{$cargo}}" selected>{{strtoupper ($cargo)}}</option>
                                    @else
                                        <option value="{{$cargo}}" >{{strtoupper ($cargo)}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-offset-0 col-md-4">
                            <label for="">Agrupación</label>
                            <select name="agrupacion" class="selectpicker form-control text-uppercase " data-live-search="true" title="Agrupación" required>
                                @foreach($agrupaciones as $agrupacion )
                                    @if($persona->agrupacion == $agrupacion)
                                        <option value="{{$agrupacion}}" selected>{{strtoupper ($agrupacion)}}</option>
                                    @else
                                        <option value="{{$agrupacion}}" >{{strtoupper ($agrupacion)}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4 ">
                            <label for="" class="col-md-3">Activo</label>
                            <select name="activo" class="selectpicker form-control text-uppercase" title="Estado" disabled>
                                @if($persona->activo == 'activo')
                                    <option value="activo" selected>ACTIVO</option>
                                    <option value="inactivo" >INACTIVO</option>
                                @else
                                    <option value="activo" >ACTIVO</option>
                                    <option value="inactivo" selected>INACTIVO</option>
                                @endif
                            </select>
                        </div>


                        <div class="form-group text-center col-md-offset-2 col-md-6">
                            <br>
                            <input name="_token" value="{{csrf_token()}}" type="hidden">
                            <button class="btn btn-primary" type="submit">Guardar</button>
                            <button class="btn btn-danger" type="reset">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
@endsection
