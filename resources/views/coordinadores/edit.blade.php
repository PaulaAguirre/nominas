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
            <div class="col-md-6 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading text-bold"><span class="text-info">NUEVO COORDINADOR</span></div>

                    <div class="panel-body text-uppercase">
                        {!!Form::model ($coordinador, ['method'=>'PATCH', 'route'=>['coordinadores.update', $coordinador]])!!}
                        {{Form::token()}}
                        <input type="hidden" name="url" value="{{URL::previous ()}}">
                        <div class="form-group">
                            <div class="col-md-6">
                                <label for="name">CH</label>
                                <input type="number" name="ch" required value="{{$coordinador->ch}}" class="form-control text-uppercase">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="">
                                <label for="name">Documento</label>
                                <input type="text" name="documento_persona" required value="{{$coordinador->documento_persona}}" class="form-control text-uppercase">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="">Nombre del coordinador</label>
                            <input type="text" name="nombre" required value="{{$coordinador->nombre}}" class="form-control text-uppercase" placeholder="NOMBRES, APELLIDOS">
                        </div>


                        <div class="form-group">
                            <label for="">Zona</label>
                            <select name="id_zona" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione zona">
                                @foreach($zonas as $zona )
                                    @if($coordinador->id_zona == $zona->id)
                                        <option selected value="{{$zona->id}}">{{strtoupper ($zona->zona)}}-->{{$zona->representante_zonal_nombre}}</option>
                                    @else
                                        <option value="{{$zona->id}}">{{strtoupper ($zona->zona)}}-->{{$zona->representante_zonal_nombre}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Oficina</label>
                            <select name="oficina_id" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione zona">
                                @foreach($oficinas as $oficina )
                                    @if($coordinador->oficina_id == $oficina->id)
                                        <option selected value="{{$oficina->id}}">{{strtoupper ($oficina->nombre)}}</option>
                                    @else
                                        <option value="{{$oficina->id}}">{{strtoupper ($oficina->nombre)}}</option>
                                    @endif
                                @endforeach
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
