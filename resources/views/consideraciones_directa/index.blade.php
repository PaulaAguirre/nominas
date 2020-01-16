@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Consideraciones Asesores Directa</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
    @include('consideraciones_directa.search_aprobacion_index')
    <br>

    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center" style="background-color: #8eb4cb">
                    <th>ID</th>
                    <th>Mes</th>
                    <th>CH</th>
                    <th>Nombre</th>
                    <th>Representante Zonal / Jefe</th>
                    <th>Consideración</th>
                    <th>Detalles</th>
                    <th>Estado</th>
                    <th>Comentarios</th>
                    <th>Motivo Rechazo</th>
                    <th class="text-center">OPC</th>

                    </thead>
                    @foreach ($personas_consideracion as $persona)
                        @if(auth()->user()->hasRoles(['zonal', 'tigo_people']))
                            @if($zonas->contains($persona->personaDirecta->id_zona))
                                <tr class="text-uppercase text-sm">
                                    <td>{{$persona->id_nomina}}</td>
                                    <td>{{$persona->mes}}</td>
                                    <td>{{$persona->personaDirecta->ch}}</td>
                                    <td>{{$persona->personaDirecta->nombre}}</td>
                                    <td>{{$persona->personaDirecta->zona->representante_zonal_nombre ? $persona->personaDirecta->zona->representante_zonal_nombre : '' }} /
                                        {{$persona->personaDirecta->representanteJefe ? $persona->personaDirecta->representanteJefe->nombre : ''}}</td>
                                    <td>{{$persona->consideracion ? $persona->consideracion->nombre : '' }}</td>
                                    <td>{{$persona->detalles_consideracion}}</td>
                                    @if ($persona->estado_consideracion == 'pendiente')
                                        <td class="alert-warning" >{{$persona->estado_consideracion}}</td>
                                    @elseif ($persona->estado_consideracion == 'aprobado')
                                        <td class="alert-success" >{{$persona->estado_consideracion}}</td>
                                    @else
                                        <td class="alert-danger">{{$persona->estado_consideracion}}</td>
                                    @endif
                                    <td>{{$persona->comentario_consideracion ? $persona->comentario_consideracion.' -OBJ:'.$persona->porcentaje_objetivo : ''}}</td>
                                    <td>{{$persona->motivo_rechazo_consideracion}}</td>
                                    <td class="text-center">
                                        @if($persona->estado_consideracion == 'rechazado')

                                                <a href="{{URL::action('ConsideracionesDirectaController@edit', $persona)}}">
                                                    <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar Consideracion"><i class="fa fa-wrench"></i></button>
                                                </a>

                                        @endif
                                        @if($persona->archivos->where('tipo', '=', 'consideracion')->first())

                                            <a href="" data-target="#modal-delete-{{$persona->id_persona_directa}}" data-toggle="modal" data-placement="top" title="Archivo"><button class="btn btn-foursquare btn-xs"  id="btn_ver"><i class="fa fa-eye"></i></button></a>
                                        @endif
                                        @if(in_array($persona->estado_consideracion, ['pendiente']))
                                            <a href="" data-target="#modal-consideracion-update-{{$persona->id_nomina}}" data-toggle="modal" data-placement="top" title="editar consideración"><button class="btn btn-warning btn-xs"  id="btn_ver"><i class="fa fa-pencil"></i></button></a>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @elseif(auth()->user()->hasRoles([ 'tigo_people_admin']))
                            <tr class="text-uppercase text-sm">
                                <td>{{$persona->id_nomina}}</td>
                                <td>{{$persona->mes}}</td>
                                <td>{{$persona->personaDirecta->ch}}</td>
                                <td>{{$persona->personaDirecta->nombre}}</td>
                                <td>{{$persona->personaDirecta->zona->representante_zonal_nombre ? $persona->personaDirecta->zona->representante_zonal_nombre : '' }} /
                                    {{$persona->personaDirecta->representanteJefe ? $persona->personaDirecta->representanteJefe->nombre : ''}}</td>
                                <td>{{$persona->consideracion ? $persona->consideracion->nombre : ''}}</td>
                                <td>{{$persona->detalles_consideracion}}</td>
                                @if ($persona->estado_consideracion == 'pendiente')
                                    <td class="alert-warning" >{{$persona->estado_consideracion}}</td>
                                @elseif ($persona->estado_consideracion == 'aprobado')
                                    <td class="alert-success" >{{$persona->estado_consideracion}}</td>
                                @else
                                    <td class="alert-danger">{{$persona->estado_consideracion}}</td>
                                @endif
                                <td>{{$persona->comentario_consideracion ? $persona->comentario_consideracion.' -OBJ:'.$persona->porcentaje_objetivo : ''}}</td>
                                <td>{{$persona->motivo_rechazo_consideracion}}</td>
                                <td class="text-center">
                                    @if($persona->archivos->where('tipo', '=', 'consideracion')->first())

                                        <a href="" data-target="#modal-delete-{{$persona->id_persona_directa}}" data-toggle="modal" data-placement="top" title="Archivo"><button class="btn btn-foursquare btn-xs"  id="btn_ver"><i class="fa fa-eye"></i></button></a>
                                    @endif
                                    @if($persona->estado_consideracion == 'rechazado')
                                        <a href="{{URL::action('ConsideracionesDirectaController@edit', $persona)}}">
                                            <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar Consideracion"><i class="fa fa-wrench"></i></button>
                                        </a>
                                    @endif
                                    @if(in_array($persona->estado_consideracion, ['aprobado', 'rechazado']))
                                        <a href="" data-target="#modal-nomina-update-{{$persona->id_nomina}}" data-toggle="modal" data-placement="top" ><button class="btn btn-xs btn-file" title="editar estado"><i class="fa fa-cogs" aria-hidden="true"></i></button></a>
                                    @endif
                                    @if(in_array($persona->estado_consideracion, ['pendiente']))
                                        <a href="" data-target="#modal-consideracion-update-{{$persona->id_nomina}}" data-toggle="modal" data-placement="top" title="editar consideración"><button class="btn btn-warning btn-xs"  id="btn_ver"><i class="fa fa-pencil"></i></button></a>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @include('consideraciones_directa.edit_estado')
                        @include('consideraciones_directa.archivo_modal')
                        @include('consideraciones_directa.modal_edit_consideracion')
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
