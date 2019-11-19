@extends ('layouts.admin_tienda')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Consideraciones Asesores Tienda</h3>
        </div>
    </div>
    <br>
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
                    <th>Estado</th>
                    <th>Comentario Canales</th>
                    <th>%</th>
                    <th class="text-center">OPC</th>

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
                            @if ($asesor->estado_consideracion == 'pendiente')
                                <td class="alert-warning" >{{$asesor->estado_consideracion}}</td>
                            @elseif ($asesor->estado_consideracion == 'aprobado')
                                <td class="alert-success" >{{$asesor->estado_consideracion}}</td>
                            @else
                                <td class="alert-danger">{{$asesor->estado_consideracion}}</td>
                            @endif
                            <td>{{$asesor->comentarios_consideracion}}</td>
                            <td>{{$asesor->porcentaje_objetivo}}</td>
                            <td class="text-center">
                                @if($asesor->archivos->where('tipo', '=', 'consideracion')->first())
                                    <a href="" data-target="#modal-delete-{{$asesor->id}}" data-toggle="modal" data-placement="top" title="Archivo"><button class="btn btn-foursquare btn-xs"  id="btn_ver"><i class="fa fa-eye"></i></button></a>
                                @endif
                            </td>
                        </tr>
                        @include('tiendas.consideraciones.archivo_modal')
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
