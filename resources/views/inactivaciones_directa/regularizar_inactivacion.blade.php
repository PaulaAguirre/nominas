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
            <div class="col-md-5 text-uppercase col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading"><span class="text-bold text-info">Regularizar Inactivación</span></div>

                    <div class="panel-body">
                        {!!Form::model ($persona, ['method'=>'PATCH', 'route'=>['inactivaciones_directa.update', $persona->id_nomina]])!!}
                        {{Form::token()}}


                        <input type="hidden" name="url" value="{{URL::previous ()}}">

                        <div class="form-group">
                            <label for="name" class="text-info">Nombre Asesor - CH </label>
                            <p>{{$persona->personaDirecta->nombre}} - {{$persona->personaDirecta->ch}}</p>
                        </div>

                        <div class="form-group">
                            <label class="text-danger">Motivo</label>
                            <select name="rep_jefe_id" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione Representante Jefe">
                                @foreach($motivos as $motivo )
                                    @if($persona->motivo_inactivacion == $motivo)
                                        <option value="{{$motivo}}" selected>{{$motivo}}</option>
                                    @else
                                        <option value="{{$motivo}}">{{$motivo}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="text-info">Detalles</label>
                            <p>{{$persona->detalles_inactivacion}}</p>
                        </div>

                        <div class="form-group">
                            <label class="text-danger">Motivo Rechazo</label>
                            <p>{{$persona->motivo_rechazo_inactivacion}}</p>
                        </div>

                        <div class="form-group">
                            <label class="text-info">Regularización</label>
                            <textarea class="form-control" rows="2" name="regularizacion_inactivacion" id="regularizacion_inactivacion" placeholder="Detalles de la regularización" required></textarea>
                        </div>

                        <div class="form-group text-center">
                            <input name="_token" value="{{csrf_token()}}" type="hidden">
                            <button class="btn btn-primary " type="submit">Guardar</button>
                            <button class="btn btn-danger " type="reset">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
@endsection
