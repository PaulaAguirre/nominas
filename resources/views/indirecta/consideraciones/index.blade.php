@extends ('layouts.admin_indirecta')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Consideraciones</h3>
        </div>
    </div>
    @include('indirecta.consideraciones.search_index')
    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center text-gray" style="background-color: #5d59a6">
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
                    @foreach ($impulsadores as $impulsador)
                        <tr class="text-uppercase text-sm">
                            <td>{{$impulsador->id}}</td>
                            <td>{{$impulsador->mes}}</td>
                            <td>{{$impulsador->impulsador->ch}}</td>
                            <td>{{$impulsador->impulsador->nombre}}</td>
                            <td>{{$impulsador->impulsador->zona->nombre.' / '.$impulsador->impulsador->zona->representante_zonal_nombre}}</td>
                            <td>{{$impulsador->consideracion ? $impulsador->consideracion->nombre : '' }}</td>
                            <td>{{$impulsador->detalles_consideracion}}</td>
                            <td>{{$impulsador->regularizacion_consideracion}}</td>
                            @if ($impulsador->estado_consideracion == 'pendiente')
                                <td class="alert-warning" >{{$impulsador->estado_consideracion}}</td>
                            @elseif ($impulsador->estado_consideracion == 'aprobado')
                                <td class="alert-success" >{{$impulsador->estado_consideracion}}</td>
                            @else
                                <td class="alert-danger">{{$impulsador->estado_consideracion}}</td>
                            @endif
                            <td>{{$impulsador->comentarios_consideracion}}</td>
                            <td>{{$impulsador->porcentaje_objetivo}}</td>
                            <td>
                                @if($impulsador->archivos->where('tipo', '=', 'consideracion')->first())
                                    <a href="" data-target="#modal-delete-{{$impulsador->id}}" data-toggle="modal" data-placement="top" title="Archivo"><button class="btn btn-foursquare btn-xs"  id="btn_ver"><i class="fa fa-eye"></i></button></a>
                                @endif
                                @if(in_array($impulsador->estado_consideracion, ['pendiente']))
                                    <a href="" data-target="#modal-consideracion-update-{{$impulsador->id}}" data-toggle="modal" data-placement="top" title="editar consideración"><button class="btn btn-warning btn-xs"  id="btn_ver"><i class="fa fa-pencil"></i></button></a>
                                @endif
                                @if($impulsador->estado_consideracion == 'rechazado')
                                    <a href="{{URL::action('ConsideracionIndirectaController@edit', $impulsador)}}">
                                        <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar Consideracion"><i class="fa fa-wrench"></i></button>
                                    </a>
                                @endif
                                @if(auth()->user()->hasRoles(['tigo_people_admin']))
                                        @if(in_array($impulsador->estado_consideracion, ['aprobado', 'rechazado']))
                                            <a href="" data-target="#modal-nomina-update-{{$impulsador->id}}" data-toggle="modal" data-placement="top" ><button class="btn btn-xs btn-file" title="editar estado"><i class="fa fa-cogs" aria-hidden="true"></i></button></a>
                                        @endif
                                @endif
                            </td>
                        </tr>
                        @include('indirecta.consideraciones.edit_estado')
                        @include('indirecta.consideraciones.archivo_modal')
                        @include('indirecta.consideraciones.modal_edit_consideracion')
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
