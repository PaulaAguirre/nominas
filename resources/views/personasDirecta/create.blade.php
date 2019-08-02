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
            <div class="col-md-7 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading text-bold"><span class="text-info">NUEVO ASESOR</span></div>

                    <div class="panel-body text-uppercase">
                        {!!Form::open(array('url'=>'representantes_directa','method'=>'POST','autocomplete'=>'off'))!!}
                        {{Form::token()}}

                        <input type="hidden" name="url" value="{{URL::previous ()}}">
                        <div class="form-group">
                            <div class="col-md-3">
                                <label for="name">CH</label>
                                <input type="number" name="ch" required value="{{old('ch')}}" class="form-control text-uppercase">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3">
                                <label for="name">Fecha Ingreso</label>
                                <input type="text" name="fecha_ingreso" required value="{{old('ch')}}" class="form-control text-uppercase" placeholder="DD/MM/YYYY">
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <div class="">
                                <label for="name">Documento</label>
                                <input type="text" name="documento_persona" required value="{{old('documento_persona')}}" class="form-control text-uppercase">
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <div class="">
                                <label for="name">Staff</label>
                                <input type="number" name="staff"  value="{{old('staff')}}" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                                <label class="">Nombre del Asesor</label>
                                <input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control text-uppercase">
                        </div>


                        <div class="form-group">
                            <label for="">Representante Jefe</label>
                            <select name="rep_jefe_id" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione Representante Jefe">
                                @foreach($jefes as $jefe )
                                        <option value="{{$jefe->id_persona}}">{{strtoupper ($jefe->nombre)}}-->{{$jefe->zona->zona}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-offset-0 col-md-4">
                            <label for="">Cargo GO</label>
                            <select name="cargo_go" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione Cargo" required>
                                @foreach($cargos_go as $cargo )
                                        <option value="{{$cargo}}">{{strtoupper ($cargo)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-offset-0 col-md-4">
                            <label for="">Agrupación</label>
                            <select name="agrupacion" class="selectpicker form-control text-uppercase " data-live-search="true" title="Agrupacion" required>
                                @foreach($agrupaciones as $agrupacion )
                                    <option value="{{$agrupacion}}">{{strtoupper ($agrupacion)}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4 ">
                            <label for="" class="col-md-3">Activo</label>
                            <select name="activo" class="selectpicker form-control text-uppercase" title="Estado">
                                    <option value="inactivo" >inactivo</option>
                                    <option value="activo" selected >activo</option>
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
