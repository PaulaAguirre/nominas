@extends ('layouts.admin_indirecta')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>impulsadores Inactivados</h3>
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
    @include('indirecta.inactivaciones.search_index')
    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center text-gray" style="background-color: #5d59a6">
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
                    @foreach ($impulsadores_inactivos as $impulsador)
                        <tr class="text-uppercase text-sm">
                            <td>{{$impulsador->mes}}</td>
                            <td>{{$impulsador->id}}</td>
                            <td>{{$impulsador->impulsador->ch}}</td>
                            <td>{{$impulsador->impulsador->nombre}}</td>
                            <td>{{$impulsador->impulsador->zona->nombre.' / '.$impulsador->impulsador->zona->representante_zonal_nombre}}</td>
                            <td>{{$impulsador->motivo_inactivacion}}</td>
                            <td>{{$impulsador->detalles_inactivacion}}</td>
                            <td>{{$impulsador->regularizacion_inactivacion}}</td>
                            @if ($impulsador->estado_inactivacion == 'pendiente')
                                <td class="alert-warning" >{{$impulsador->estado_inactivacion}}</td>
                            @elseif ($impulsador->estado_inactivacion == 'aprobado')
                                <td class="alert-success" >{{$impulsador->estado_inactivacion}}</td>
                            @else
                                <td class="alert-danger">{{$impulsador->estado_inactivacion}}</td>
                            @endif
                            <td>{{$impulsador->comentarios_inactivacion}}</td>
                            <td>{{$impulsador->porcentaje_objetivo}}</td>
                                <td class="text-center">
                                    @if($impulsador->archivos->where('tipo', '=', 'inactivacion')->first())
                                        <a href="" data-target="#modal-delete-{{$impulsador->id}}" data-toggle="modal" data-placement="top" title="Archivo"><button class="btn btn-foursquare btn-xs"  id="btn_ver"><i class="fa fa-eye"></i></button></a>
                                    @endif
                                    @if($impulsador->estado_inactivacion == 'rechazado')
                                        <a href="{{URL::action('InactivacionIndirectaController@edit', $impulsador->id)}}">
                                            <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar Inactivacion"><i class="fa fa-wrench"></i></button>
                                        </a>
                                    @endif
                                    @if($impulsador->estado_inactivacion == 'pendiente')
                                        <a href="" data-target="#modal-inactivacion-update-{{$impulsador->id}}" data-toggle="modal" data-placement="top" title="editar inactivacion"><button class="btn btn-warning btn-xs"  id="btn_ver"><i class="fa fa-pencil"></i></button></a>
                                    @endif
                                    @if(in_array($impulsador->estado_inactivacion, ['aprobado', 'rechazado']))
                                        <a href="" data-target="#modal-inactivacion_estado-update-{{$impulsador->id}}" data-toggle="modal" data-placement="top" ><button class="btn btn-xs btn-file" title="editar estado"><i class="fa fa-cogs" aria-hidden="true"></i></button></a>
                                    @endif
                                </td>
                            </tr>
                        @include('indirecta.inactivaciones.archivo_modal_inactivacion')
                        @include('indirecta.inactivaciones.modal_editar_estado')
                        @include('indirecta.inactivaciones.modal_editar_inactivacion')


                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
