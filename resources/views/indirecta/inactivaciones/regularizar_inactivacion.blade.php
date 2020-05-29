@extends ('layouts.admin_tienda')
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
                        {!!Form::model ($impulsador, ['method'=>'PATCH', 'route'=>['inactivaciones_indirecta.update', $impulsador->id]])!!}
                        {{Form::token()}}


                        <input type="hidden" name="url" value="{{URL::previous ()}}">

                        <div class="form-group">
                            <label for="name" class="text-info">Nombre impulsador - CH </label>
                            <p>{{$impulsador->impulsador->nombre}} - {{$impulsador->impulsador->ch}}</p>
                        </div>

                        <div class="form-group">
                            <label class="text-danger">Motivo</label>

                        </div>

                        <div class="form-group">
                            <label class="text-info">Detalles</label>
                            <p>{{$impulsador->detalles_inactivacion}}</p>
                        </div>

                        <div class="form-group">
                            <label class="text-danger">Motivo Rechazo</label>
                            <p>{{$impulsador->comentarios_inactivacion}}</p>
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
