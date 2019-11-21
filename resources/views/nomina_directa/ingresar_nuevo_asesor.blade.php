@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Ingresar Asesor </h3>
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

    {!!Form::model ($personas_a_ingresar, ['method'=>'PATCH', 'route'=>['ingresar_nuevo_asesor_store']])!!}
    {{Form::token()}}
    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_persona">
                    <thead class="text-center" style="background-color: #8eb4cb">
                    <th>ID</th>
                    <th>Region/Zona</th>
                    <th>Rep Zonal - Rep Jefe</th>
                    <th>CH</th>
                    <th>Representante</th>
                    <th>Agregar</th>
                    </thead>
                    @foreach ($personas_a_ingresar as $persona)
                        <tr class="text-uppercase">
                            <td>{{$persona->id_persona}}</td>
                            <td>{{$persona->zona->region->region.' / '.$persona->zona->zona}}</td>
                            <td>{{$persona->zona->representante_zonal_nombre ? $persona->zona->representante_zonal_nombre : '' }} -
                                {{$persona->representanteJefe ? $persona->representanteJefe->nombre : ''}}
                            </td>
                            <td>{{$persona->ch}}</td>
                            <td><input type="hidden" name="idrepresentante[]" value="{{$persona->id_persona}}" >
                                <input type="hidden" name="persona_mes[]" id="persona_mes" value="{{$persona->id_persona.$mes_nomina}}">
                                {{$persona->nombre}}
                            </td>
                            <td class="text-center"><input type="checkbox" value="{{$persona->id_persona}}" name="agregar[]"></td>

                        </tr>
                    @endforeach
                </table>
                <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12 text-center" id="guardar">
                    <div class="form-group">
                        <input name="_token" value="{{csrf_token()}}" type="hidden">
                        <button class="btn btn-primary" type="submit">Guardar</button>
                        <button id="btn_cancelar" class="btn btn-danger" type="reset">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
