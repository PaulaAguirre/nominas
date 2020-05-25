@extends ('layouts.admin_tienda')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Consideraciones Asesores Tienda - mes {{$mes_nomina}}</h3>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        @if (count($errors)>0)
            <div class="alert alert-warning alert-dismissible ">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></li>

                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    @include('TiendaRPL.consideraciones.search_index')
    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center" style="background-color: #2ab27b">
                    <th>ID</th>
                    <th>Mes</th>
                    <th>CH</th>
                    <th>Nombre</th>
                    <th>Representante Zonal</th>
                    <th>Consideración</th>
                    <th>Detalles</th>
                    <th>Regularización</th>
                    <th>Estado</th>
                    <th>Comentario Canales</th>
                    <th>%</th>
                    <th>OPC</th>

                    </thead>
                    @foreach ($asesores as $asesor)
                        <tr class="text-uppercase text-sm">
                            <td>{{$asesor->id}}</td>
                            <td>{{$asesor->mes}}</td>
                            <td>{{$asesor->asesor->ch}}</td>
                            <td>{{$asesor->asesor->nombre}}</td>
                            <td>{{$asesor->asesor->tienda->zona->zona.' / '.$asesor->asesor->tienda->zona->representante_zonal_nombre }}</td>
                            <td>{{$asesor->consideracion ? $asesor->consideracion->nombre : '' }}</td>
                            <td>{{$asesor->detalles_consideracion}}</td>
                            <td>{{$asesor->regularizacion_consideracion}}</td>
                            @if ($asesor->estado_consideracion == 'pendiente')
                                <td class="alert-warning" >{{$asesor->estado_consideracion}}</td>
                            @elseif ($asesor->estado_consideracion == 'aprobado')
                                <td class="alert-success" >{{$asesor->estado_consideracion}}</td>
                            @else
                                <td class="alert-danger">{{$asesor->estado_consideracion}}</td>
                            @endif
                            <td>{{$asesor->comentarios_consideracion}}</td>
                            <td>{{$asesor->porcentaje_objetivo}}</td>
                            <td>
                                @if($asesor->archivos->where('tipo', '=', 'consideracion')->first())
                                    <a href="" data-target="#modal-delete-{{$asesor->id}}" data-toggle="modal" data-placement="top" title="Archivo"><button class="btn btn-foursquare btn-xs"  id="btn_ver"><i class="fa fa-eye"></i></button></a>
                                @endif
                                @if(in_array($asesor->estado_consideracion, ['pendiente']))
                                    <a href="" data-target="#modal-consideracion-update-{{$asesor->id}}" data-toggle="modal" data-placement="top" title="editar consideración"><button class="btn btn-warning btn-xs"  id="btn_ver"><i class="fa fa-pencil"></i></button></a>
                                @endif
                                @if($asesor->estado_consideracion == 'rechazado')
                                    <a href="{{URL::action('ConsideracionTiendaRPLController@edit', $asesor)}}">
                                        <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar Consideracion"><i class="fa fa-wrench"></i></button>
                                    </a>
                                @endif
                                @if(auth()->user()->hasRoles(['tigo_people_admin']))
                                        @if(in_array($asesor->estado_consideracion, ['aprobado', 'rechazado']))
                                            <a href="" data-target="#modal-nomina-update-{{$asesor->id}}" data-toggle="modal" data-placement="top" ><button class="btn btn-xs btn-file" title="editar estado"><i class="fa fa-cogs" aria-hidden="true"></i></button></a>
                                        @endif
                                @endif
                            </td>
                        </tr>
                        @include('TiendaRPL.consideraciones.modal_edit_consideracion')
                        @include('TiendaRPL.consideraciones.archivo_modal')
                        @include('TiendaRPL.consideraciones.edit_estado')
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
