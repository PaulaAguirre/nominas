@extends ('layouts.admin_tienda')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Asesores Inactivados - mes {{$mes}}</h3>
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
    @include('tiendas.inactivaciones.search_index')
    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center" style="background-color: #2ab27b">
                        <th>mes</th>
                        <th>ID</th>
                        <th>CH</th>
                        <th>Nombre</th>
                        <th>Zona</th>
                        <th>Motivo</th>
                        <th>Detalles</th>
                        <th>Regularización</th>
                        <th>Estado</th>
                        <th>Comentarios</th>
                        <th>%OBJ</th>
                        <th class="text-center">OPC</th>

                    </thead>
                    @foreach ($asesores_inactivos as $asesor)
                        <tr class="text-uppercase text-sm">
                            <td>{{$asesor->mes}}</td>
                            <td>{{$asesor->id}}</td>
                            <td>{{$asesor->asesor->ch}}</td>
                            <td>{{$asesor->asesor->nombre}}</td>
                            <td>{{$asesor->asesor->tienda->zona->zona.' / '.$asesor->asesor->tienda->zona->representante_zonal_nombre}}</td>
                            <td>{{$asesor->motivo_inactivacion}}</td>
                            <td>{{$asesor->detalles_inactivacion}}</td>
                            <td>{{$asesor->regularizacion_inactivacion}}</td>
                            @if ($asesor->estado_inactivacion == 'pendiente')
                                <td class="alert-warning" >{{$asesor->estado_inactivacion}}</td>
                            @elseif ($asesor->estado_inactivacion == 'aprobado')
                                <td class="alert-success" >{{$asesor->estado_inactivacion}}</td>
                            @else
                                <td class="alert-danger">{{$asesor->estado_inactivacion}}</td>
                            @endif
                            <td>{{$asesor->comentarios_inactivacion}}</td>
                            <td>{{$asesor->porcentaje_objetivo}}</td>
                                <td class="text-center">
                                    @if($asesor->archivos->where('tipo', '=', 'inactivacion')->first())
                                        <a href="" data-target="#modal-delete-{{$asesor->id}}" data-toggle="modal" data-placement="top" title="Archivo"><button class="btn btn-foursquare btn-xs"  id="btn_ver"><i class="fa fa-eye"></i></button></a>
                                    @endif
                                    @if($asesor->estado_inactivacion == 'rechazado')
                                        <a href="{{URL::action('InactivacionTiendaRPLController@edit', $asesor)}}">
                                            <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar Inactivacion"><i class="fa fa-wrench"></i></button>
                                        </a>
                                    @endif
                                    @if($asesor->estado_inactivacion == 'pendiente')
                                        <a href="" data-target="#modal-inactivacion-update-{{$asesor->id}}" data-toggle="modal" data-placement="top" title="editar inactivacion"><button class="btn btn-warning btn-xs"  id="btn_ver"><i class="fa fa-pencil"></i></button></a>
                                    @endif
                                    @if(in_array($asesor->estado_inactivacion, ['aprobado', 'rechazado']))
                                        <a href="" data-target="#modal-inactivacion_estado-update-{{$asesor->id}}" data-toggle="modal" data-placement="top" ><button class="btn btn-xs btn-file" title="editar estado"><i class="fa fa-cogs" aria-hidden="true"></i></button></a>
                                    @endif
                                </td>
                            </tr>
                        @include('TiendaRPL.inactivaciones.archivo_modal_inactivacion')
                        @include('TiendaRPL.inactivaciones.modal_editar_inactivacion')
                        @include('TiendaRPL.inactivaciones.modal_editar_estado')
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
