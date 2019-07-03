@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Nómina de personaes - Canal: Directa. <a href="nomina_directa/create/create"><button class="btn btn-success">Generar Nomina</button></a></h3>
            <br>
        </div>
    </div>

    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center" style="background-color: #8eb4cb">
                    <th>Mes</th>
                    <th>Region/Zona</th>
                    <th>Rep Zonal - Rep Jefe</th>
                    <th>CH</th>
                    <th>Representante</th>
                    <th>Activo</th>
                    <th class="text-center">Opciones</th>
                    </thead>
                    @foreach ($personas as $persona)
                        <tr class="text-uppercase">
                            <td>{{$persona->mes}}</td>
                            <td>{{$persona->personaDirecta->region->region.' '.$persona->personaDirecta->zona->zona}}</td>
                            <td>{{$persona->personaDirecta->representanteZonal->nombre}} / {{$persona->personaDirecta->representanteJefe->nombre}}</td>
                            <td>{{$persona->personaDirecta->ch}}</td>
                            <td>{{$persona->personaDirecta->nombre}}</td>
                            <td>{{$persona->activo}}</td>
                            <td>
                                <a href="{{URL::action('PersonaDirectaController@edit', $persona->personaDirecta)}}">
                                    <button class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Editar persona"><i class="fa fa-pencil"></i></button>
                                </a>
                                <a href="{{URL::action('PersonaDirectaController@edit', $persona->personaDirecta)}}">
                                    <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Inactivar persona"><i class="fa fa-user-times"></i></button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
