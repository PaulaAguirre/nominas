@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <h3>{{$persona_nomina->personaDirecta->nombre}}</h3>
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
    {!!Form::model ($persona_nomina, ['method'=>'PATCH', 'route'=>['nomina_directa.storeconsideraciones', $persona_nomina]])!!}
    {{Form::token()}}
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading text-bold"><span class="text-info">Agregar Consideración</span></div>

                    <div class="panel-body text-uppercase">
                        <input type="hidden" name="url" value="{{URL::previous ()}}">
                        <div class="form-group">
                            <label for="">Consideración</label>
                            <select name="id_consideracion" class="selectpicker form-control text-uppercase" title="Seleccione Consideración">
                                @foreach($consideraciones as $consideracion )
                                    <option value="{{$consideracion->id}}">{{strtoupper ($consideracion->nombre)}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Observaciones</label>
                            <textarea class="form-control" rows="3" id="detalles_consideracion" value="{{old('detalles_consideracion')}}" required name="detalles_consideracion" placeholder="Detalles de la consideración"></textarea>
                        </div>


                        <div class="form-group text-center">
                            <br>
                            <input name="_token" value="{{csrf_token()}}" type="hidden">
                            <button class="btn btn-primary" type="submit">Guardar</button>
                            <button class="btn btn-danger" type="reset">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!!Form::close()!!}

@endsection
