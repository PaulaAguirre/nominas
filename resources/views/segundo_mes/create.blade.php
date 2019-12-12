@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <h3>Asesores Segundo Mes <span class="text-info">Mes: {{$mes_nomina}}</span> </h3>
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

    {!!Form::open(array('url'=>'segundo_mes','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}

    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_persona">
                    <thead class="text-center" style="background-color: #8eb4cb">
                    <th>Region/Zona</th>
                    <th>Rep Zonal - Rep Jefe</th>
                    <th>CH</th>
                    <th>Representante</th>
                    </thead>
                    @foreach ($nomina_segundo_mes as $persona)
                        <tr class="text-uppercase">
                            <td>{{$persona->personaDirecta->zona->region->region.' / '.$persona->personaDirecta->zona->zona}}</td>
                            <td>{{$persona->personaDirecta->representanteJefe->zona->representante_zonal_nombre ? $persona->personaDirecta->representanteJefe->zona->representante_zonal_nombre : '' }} -
                                {{$persona->personaDirecta->representanteJefe ? $persona->personaDirecta->representanteJefe->nombre : ''}}
                            </td>
                            <td>{{$persona->personaDirecta->ch}}</td>
                            <td><input type="hidden" name="id_persona[]" value="{{$persona->id_persona_directa}}" >
                                {{$persona->personaDirecta->nombre}}</td>

                        </tr>
                    @endforeach
                </table>
                <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12 text-center" id="guardar">
                    <div class="form-group">
                        <div class="form-group text-center col-md-offset-2 col-md-6">
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



