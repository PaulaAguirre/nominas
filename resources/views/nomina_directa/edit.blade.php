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
                    <div class="panel-heading"><span class="text-bold text-info">Regularizar Asesor</span></div>

                    <div class="panel-body">
                        {!!Form::model ($nomina_directa, ['method'=>'PATCH', 'route'=>['nomina_directa.update', $nomina_directa]])!!}
                        {{Form::token()}}


                        <input type="hidden" name="url" value="{{URL::previous ()}}">

                        <div class="form-group">
                                <label for="name" class="text-info">Nombre Asesor - CH </label>
                                <p>{{$nomina_directa->personaDirecta->nombre}} - {{$nomina_directa->personaDirecta->ch}}</p>
                        </div>

                        <div class="form-group">
                            <label class="text-info">Representante Zonal</label>
                            <p>{{$nomina_directa->personaDirecta->zona->representante_zonal_nombre}}</p>
                        </div>

                        <div class="form-group">
                            <label class="text-info">Representante Jefe</label>
                            <p>{{$nomina_directa->personaDirecta->representanteJefe->nombre}}</p>
                        </div>

                        <div class="form-group">
                            <label class="text-info">Motivo Rechazo</label>
                            <p>{{$nomina_directa->motivo_rechazo}}</p>
                        </div>

                        <div class="form-group">
                            <label class="text-info">Regularización</label>
                            <textarea class="form-control" rows="2" name="regularizacion" id="regularizacion" placeholder="Detalles de la regularización"></textarea>
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
