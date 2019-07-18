@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h3>Nómina - Canal: Directa. <a href="nomina_directa/create"><button class="btn btn-success">Generar Nomina</button></a></h3>
            @include('nomina_directa.search_index')

        </div>
    </div>

    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center" style="background-color: #8eb4cb">
                    <th>Mes</th>
                    <th>CH</th>
                    <th>Representante</th>
                    <th>Agrupación</th>
                    <th>Rep Zonal - Rep Jefe</th>
                    <th>Region/Zona</th>
                    <th>Activo</th>
                    <th class="text-center">Opciones</th>
                    </thead>
                    @foreach ($personas as $persona)
                        <tr class="text-uppercase">
                            @if(auth()->user()->hasRoles(['zonal']))
                                @if($zonas->contains($persona->personaDirecta->id_zona))
                                    <td>{{$persona->mes}}</td>
                                    <td>{{$persona->personaDirecta->ch}}</td>
                                    <td>{{$persona->personaDirecta->nombre}}</td>
                                    <td>{{$persona->agrupacion}}</td>
                                    <td>{{$persona->personaDirecta->zona->representante_zonal_nombre}} / {{$persona->personaDirecta->representanteJefe->nombre}}</td>
                                    <td>{{$persona->personaDirecta->zona->region->region.' / '.$persona->personaDirecta->zona->zona}}</td>
                                    @if($persona->estado_nomina == 'pendiente')
                                        <td class="alert-warning">{{$persona->estado_nomina}}</td>
                                    @elseif ($persona->estado_nomina == 'rechazado')
                                        <td class="alert-danger">{{$persona->estado_nomina}}</td>
                                    @else
                                        <td class="alert-success">{{$persona->estado_nomina}}</td>
                                    @endif
                                    <td>
                                        <a href="{{URL::action('PersonaDirectaController@edit', $persona->personaDirecta)}}">
                                            <button class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Datos del Asesor"><i class="fa fa-pencil"></i></button>

                                        <a href="{{URL::action('NominaDirectaController@agregarConsideraciones',$persona)}}">
                                            <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="Agregar Consideración"><i class="fa fa-comment"></i></button>
                                        </a>
                                        </a>
                                        @if($persona->estado_nomina == 'rechazado')
                                            <a href="#">
                                                <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar asesor"><i class="fa fa-wrench"></i></button>
                                            </a>
                                        @endif
                                    </td>
                                @endif
                            @else
                                <td>{{$persona->mes}}</td>
                                <td>{{$persona->personaDirecta->ch}}</td>
                                <td>{{$persona->personaDirecta->nombre}}</td>
                                <td>{{$persona->agrupacion}}</td>
                                <td>{{$persona->personaDirecta->zona->representante_zonal_nombre}} / {{$persona->personaDirecta->representanteJefe->nombre}}</td>
                                <td>{{$persona->personaDirecta->zona->region->region.' / '.$persona->personaDirecta->zona->zona}}</td>
                                @if($persona->estado_nomina == 'pendiente')
                                    <td class="alert-warning">{{$persona->estado_nomina}}</td>
                                @elseif ($persona->estado_nomina == 'rechazado')
                                    <td class="alert-danger">{{$persona->estado_nomina}}</td>
                                @else
                                    <td class="alert-success">{{$persona->estado_nomina}}</td>
                                @endif
                                <td>
                                    <a href="{{URL::action('PersonaDirectaController@edit', $persona->personaDirecta)}}">
                                        <button class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Datos del Asesor"><i class="fa fa-pencil"></i></button>
                                    </a>

                                    <a href="{{URL::action('NominaDirectaController@agregarConsideraciones',$persona)}}">
                                        <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="Agregar Consideración"><i class="fa fa-comment"></i></button>
                                    </a>
                                    @if($persona->estado_nomina == 'rechazado')
                                        <a href="#">
                                            <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar asesor"><i class="fa fa-wrench"></i></button>
                                        </a>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
