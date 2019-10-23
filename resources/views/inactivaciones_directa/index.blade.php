@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Asesores Inactivados</h3>
        </div>
    </div>
    @include('inactivaciones_directa.search_index')
    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center" style="background-color: #8eb4cb">
                        <th>mes</th>
                        <th>ID</th>
                        <th>CH</th>
                        <th>Nombre</th>
                        <th>CI</th>
                        <th>Zona/Region</th>
                        <th>Representante Zonal / Jefe</th>
                        <th>Consideración</th>
                        <th>Detalles</th>
                        <th>Estado</th>
                        <th>Motivo Rechazo</th>
                        <th>Comentarios</th>
                        <th class="text-center">OPC</th>

                    </thead>
                    @foreach ($inactivaciones as $persona)
                        @if(auth()->user()->hasRoles(['zonal', 'tigo_people']))
                            @if($zonas->contains($persona->personaDirecta->id_zona))
                                <tr class="text-uppercase text-sm">
                                    <td>{{$persona->mes}}</td>
                                    <td>{{$persona->id_nomina}}</td>
                                    <td>{{$persona->personaDirecta->ch}}</td>
                                    <td>{{$persona->personaDirecta->nombre}}</td>
                                    <td>{{$persona->personaDirecta->documento_persona}}</td>
                                    <td>{{$persona->personaDirecta->zona->region->region}} / {{$persona->personaDirecta->zona->zona}}</td>
                                    <td>{{$persona->personaDirecta->zona->representante_zonal_nombre ? $persona->personaDirecta->zona->representante_zonal_nombre : '' }} /
                                        {{$persona->personaDirecta->representanteJefe ? $persona->personaDirecta->representanteJefe->nombre : ''}}</td>
                                    <td>{{$persona->motivo_inactivacion}}</td>
                                    <td>{{$persona->detalles_inactivacion}}</td>
                                    @if ($persona->estado_inactivacion == 'pendiente')
                                        <td class="alert-warning" >{{$persona->estado_inactivacion}}</td>
                                    @elseif ($persona->estado_inactivacion == 'aprobado')
                                        <td class="alert-success" >{{$persona->estado_inactivacion}}</td>
                                    @else
                                        <td class="alert-danger">{{$persona->estado_inactivacion}}</td>
                                    @endif
                                    <td>{{$persona->motivo_rechazo_inactivacion}}</td>
                                    <td>{{$persona->comentario_inactivacion.' -OBJ:'.$persona->porcentaje_objetivo}}</td>
                                    @if(auth()->user()->hasRoles(['zonal', 'tigo_people']))
                                        <td class="text-center">
                                            @if($persona->archivos->where('tipo', '=', 'inactivacion')->first())
                                                <a href="" data-target="#modal-delete-{{$persona->id_persona_directa}}" data-toggle="modal" data-placement="top" title="Archivo"><button class="btn btn-foursquare btn-xs"  id="btn_ver"><i class="fa fa-eye"></i></button></a>
                                            @endif
                                            @if($persona->estado_inactivacion == 'rechazado')
                                                <a href="{{URL::action('InactivacionesDirectaController@edit', $persona)}}">
                                                    <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar Inactivacion"><i class="fa fa-wrench"></i></button>
                                                </a>
                                            @endif
                                                @if($persona->estado_inactivacion == 'pendiente')
                                                    <a href="" data-target="#modal-inactivacion-update-{{$persona->id_nomina}}" data-toggle="modal" data-placement="top" title="editar inactivacion"><button class="btn btn-warning btn-xs"  id="btn_ver"><i class="fa fa-pencil"></i></button></a>
                                                @endif
                                        </td>
                                    @endif
                                </tr>
                            @endif
                        @elseif(auth()->user()->hasRoles([ 'tigo_people_admin']))
                            <tr class="text-uppercase text-sm">
                                <td>{{$persona->mes}}</td>
                                <td>{{$persona->id_nomina}}</td>
                                <td>{{$persona->personaDirecta->ch}}</td>
                                <td>{{$persona->personaDirecta->nombre}}</td>
                                <td>{{$persona->personaDirecta->documento_persona}}</td>
                                <td>{{$persona->personaDirecta->zona->region->region}} / {{$persona->personaDirecta->zona->zona}}</td>
                                <td>{{$persona->personaDirecta->zona->representante_zonal_nombre ? $persona->personaDirecta->zona->representante_zonal_nombre : '' }} /
                                    {{$persona->personaDirecta->representanteJefe ? $persona->personaDirecta->representanteJefe->nombre : ''}}</td>
                                <td>{{$persona->motivo_inactivacion}}</td>
                                <td>{{$persona->detalles_inactivacion}}</td>
                                @if ($persona->estado_inactivacion == 'pendiente')
                                    <td class="alert-warning" >{{$persona->estado_inactivacion}}</td>
                                @elseif ($persona->estado_inactivacion == 'aprobado')
                                    <td class="alert-success" >{{$persona->estado_inactivacion}}</td>
                                @else
                                    <td class="alert-danger">{{$persona->estado_inactivacion}}</td>
                                @endif
                                <td>{{$persona->motivo_rechazo_inactivacion}}</td>
                                <td>{{$persona->comentario_inactivacion.' -OBJ:'.$persona->porcentaje_objetivo}}</td>
                                @if(auth()->user()->hasRoles(['zonal', 'tigo_people_admin']))
                                    <td class="text-center">

                                        @if($persona->archivos->where('tipo', '=', 'inactivacion')->first())
                                            <a href="" data-target="#modal-delete-{{$persona->id_persona_directa}}" data-toggle="modal" data-placement="top" title="Archivo"><button class="btn btn-foursquare btn-xs"  id="btn_ver"><i class="fa fa-eye"></i></button></a>
                                        @endif
                                        @if($persona->estado_inactivacion == 'rechazado')
                                            <a href="{{URL::action('InactivacionesDirectaController@edit', $persona)}}">
                                                <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar Inactivacion"><i class="fa fa-wrench"></i></button>
                                            </a>
                                        @endif
                                        @if($persona->estado_inactivacion == 'pendiente')
                                            <a href="" data-target="#modal-inactivacion-update-{{$persona->id_nomina}}" data-toggle="modal" data-placement="top" title="editar inactivacion"><button class="btn btn-warning btn-xs"  id="btn_ver"><i class="fa fa-pencil"></i></button></a>
                                        @endif
                                            @if(in_array($persona->estado_inactivacion, ['aprobado', 'rechazado']))
                                                <a href="" data-target="#modal-inactivacion_estado-update-{{$persona->id_nomina}}" data-toggle="modal" data-placement="top" ><button class="btn-xs btn-file" title="editar estado"><i class="fa fa-cogs" aria-hidden="true"></i></button></a>
                                            @endif

                                    </td>
                                @endif
                            </tr>
                        @endif
                        @include('inactivaciones_directa.modal_editar_estado')
                        @include('inactivaciones_directa.modal_editar_inactivacion')
                        @include('inactivaciones_directa.archivo_modal_inactivacion')
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
