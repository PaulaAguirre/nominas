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
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Datos del Representante</div>

                    <div class="panel-body">
                        {!!Form::model ($persona, ['method'=>'PATCH', 'route'=>['representantes_directa.update', $persona]])!!}
                        {{Form::token()}}

                        <input type="hidden" name="url" value="{{URL::previous ()}}">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">CH</label>
                                <input type="text" name="ch" required value="{{$persona->ch}}" class="form-control text-uppercase">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Documento</label>
                                <input type="text" name="ch" required value="{{$persona->ch}}" class="form-control text-uppercase">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Nombre</label>
                            <input type="text" name="nombre" required value="{{$persona->nombre}}" class="form-control text-uppercase">
                        </div>

                        <div class="form-group">
                            <label for="">Representante Zonal</label>
                            <select name="rep_zonal_id" class="selectpicker form-control text-uppercase " data-live-search="true">
                                @foreach($zonales as $zonal )
                                    @if($persona->representanteZonal->id_persona == $zonal->id_persona)
                                        <option value="{{$zonal->id_persona}}" selected>{{strtoupper ($zonal->nombre)}}</option>
                                    @else
                                        <option value="{{$zonal->id_persona}}">{{strtoupper ($zonal->nombre)}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Representante Jefe</label>
                            <select name="rep_jefe_id" class="selectpicker form-control text-uppercase " data-live-search="true">
                                @foreach($jefes as $jefe )
                                    @if($persona->representanteJefe->id_persona == $zonal->id_persona)
                                        <option value="{{$jefe->id_persona}}" selected>{{strtoupper ($jefe->nombre)}}</option>
                                    @else
                                        <option value="{{$jefe->id_persona}}">{{strtoupper ($jefe->nombre)}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group ">
                            <label for="">Cargo GO</label>
                            <select name="cargo_go" class="selectpicker form-control text-uppercase " data-live-search="true">
                                @foreach($cargos_go as $cargo )
                                    @if($persona->cargo_go == $cargo)
                                        <option value="{{$cargo}}" selected>{{strtoupper ($cargo)}}</option>
                                    @else
                                        <option value="{{$cargo}}">{{strtoupper ($cargo)}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Activo</label>
                            <select name="activo" class="selectpicker form-control text-uppercase ">
                                @if($persona->activo == 'activo')
                                    <option value="activo" selected>activo</option>
                                    <option value="inactivo" >Inactivo</option>
                                @else
                                    <option value="inactivo" selected>inactivo</option>
                                    <option value="activo" >Activo</option>
                                @endif
                            </select>
                        </div>


                        <div class="form-group text-center">
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
