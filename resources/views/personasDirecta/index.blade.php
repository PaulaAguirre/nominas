@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Representantes Canal Directa <a href="representantes_directa/create"><button class="btn btn-success">Nuevo Asesor  <i class="fa fa-user-plus" aria-hidden="true"></i></button></a></h3>
                @include('personasDirecta.search')

        </div>
    </div>
    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center" style="background-color: #8eb4cb">
                        <th>ID</th>
                        <th>CH</th>
                        <th>Nombre</th>
                        <th>Staff</th>
                        <th>CI</th>
                        <th>Representante Zonal</th>
                        <th>Representante Jefe</th>
                        <th>Agrupación</th>
                        <th>Region</th>
                        <th>Zona</th>
                        <th>Estructura</th>
                        <th class="text-center">Opciones</th>

                    </thead>
                    @foreach ($personasDirecta as $persona)
                        <tr class="text-uppercase text-sm">
                            @if (auth()->user()->hasRoles(['zonal', 'tigo_people']))
                                @if(in_array($persona->id_zona, $zonas))
                                    <td>{{$persona->id_persona}}</td>

                                    <td>{{$persona->ch}}</td>
                                    <td>{{$persona->nombre}}</td>
                                    <td>{{$persona->staff}}</td>
                                    <td>{{$persona->documento_persona}}</td>
                                    <td>{{$persona->zona->representante_zonal_nombre ? $persona->zona->representante_zonal_nombre : '' }}</td>
                                    <td>{{$persona->representanteJefe ? $persona->representanteJefe->nombre : ''}}</td>
                                    <td>{{$persona->agrupacion}}</td>
                                    <td>{{$persona->zona->region->region}}</td>
                                    <td>{{$persona->zona->zona}}</td>
                                    @if ($persona->estado_cambio == 'pendiente')
                                        <td class="alert-warning" >{{$persona->estado_cambio}}</td>
                                    @elseif ($persona->estado_cambio == 'aprobado')
                                        <td class="alert-success" >{{$persona->estado_cambio}}</td>
                                    @else
                                        <td class="alert-danger">{{$persona->estado_cambio}}</td>
                                    @endif
                                    <td>
                                        <a href="{{URL::action ('PersonaDirectaController@edit', $persona)}}"><button class="btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>
                                        <a href="" data-target="#modal-delete-{{$persona->id_persona}}" data-toggle="modal" data-placement="top" title="Inactivar"><button class="btn-xs btn-danger"><i class="fa fa-user-times" aria-hidden="true"></i></button></a>
                                        @if($persona->estado_cambio == 'rechazado')
                                            <a href="{{URL::action('PersonaDirectaController@regularizarEstructura', $persona->id_persona)}}">
                                                <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar Estructura"><i class="fa fa-wrench"></i></button>
                                            </a>
                                        @endif
                                    </td>

                                @endif
                            @elseif (auth()->user()->hasRoles(['tigo_people_admin']))
                                <td>{{$persona->id_persona}}</td>

                                <td>{{$persona->ch}}</td>
                                <td>{{$persona->nombre}}</td>
                                <td>{{$persona->staff}}</td>
                                <td>{{$persona->documento_persona}}</td>
                                <td>{{$persona->zona->representante_zonal_nombre ? $persona->zona->representante_zonal_nombre : '' }}</td>
                                <td>{{$persona->representanteJefe ? $persona->representanteJefe->nombre : ''}}</td>
                                <td>{{$persona->agrupacion}}</td>
                                <td>{{$persona->zona->region->region}}</td>
                                <td>{{$persona->zona->zona}}</td>
                                @if ($persona->estado_cambio == 'pendiente')
                                    <td class="alert-warning" >{{$persona->estado_cambio}}</td>
                                @elseif ($persona->estado_cambio == 'aprobado')
                                    <td class="alert-success" >{{$persona->estado_cambio}}</td>
                                @else
                                    <td class="alert-danger">{{$persona->estado_cambio}}</td>
                                @endif
                                <td>
                                    <a href="{{URL::action ('PersonaDirectaController@edit', $persona)}}"><button class="btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>
                                    <a href="" data-target="#modal-delete-{{$persona->id_persona}}" data-toggle="modal" data-placement="top" title="Inactivar"><button class="btn-xs btn-danger"><i class="fa fa-user-times" aria-hidden="true"></i></button></a>
                                    @if($persona->estado_cambio == 'rechazado')
                                        <a href="{{URL::action('PersonaDirectaController@regularizarEstructura', $persona->id_persona)}}">
                                            <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar Estructura"><i class="fa fa-wrench"></i></button>
                                        </a>
                                    @endif
                                </td>
                            @endif

                        </tr>
                    @endforeach
                </table>
            </div>
            @include('personasDirecta.modal')
        </div>
    </div>

@endsection
