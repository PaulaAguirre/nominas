@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Consideraciones Asesores Directa</h3>
        </div>
    </div>
    @include('consideraciones_directa.search')
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
                        <th>CI</th>
                        <th>Representante Zonal / Jefe</th>
                        <th>Consideración</th>
                        <th>Detalles</th>
                        <th>Estado</th>
                        <th>Motivo Rechazo</th>
                        <th class="text-center">OPC</th>

                    </thead>
                    @foreach ($personas_consideracion as $persona)
                        <tr class="text-uppercase text-sm">
                            <td>{{$persona->id_nomina}}</td>
                            <td>{{$persona->mes}}</td>
                            <td>{{$persona->personaDirecta->ch}}</td>
                            <td>{{$persona->personaDirecta->nombre}}</td>
                            <td>{{$persona->personaDirecta->documento_persona}}</td>
                            <td>{{$persona->personaDirecta->zona->representante_zonal_nombre ? $persona->personaDirecta->zona->representante_zonal_nombre : '' }} /
                                {{$persona->personaDirecta->representanteJefe ? $persona->personaDirecta->representanteJefe->nombre : ''}}</td>
                            <td>{{$persona->consideracion->nombre}}</td>
                            <td>{{$persona->detalles_consideracion}}</td>
                            @if ($persona->estado_consideracion == 'pendiente')
                                <td class="alert-warning" >{{$persona->estado_consideracion}}</td>
                            @elseif ($persona->estado_consideracion == 'aprobado')
                                <td class="alert-success" >{{$persona->estado_consideracion}}</td>
                            @else
                                <td class="alert-danger">{{$persona->estado_consideracion}}</td>
                            @endif
                            <td>{{$persona->motivo_rechazo_consideracion}}</td>
                            <td class="text-center">
                                @if($persona->estado_consideracion == 'rechazado')
                                    <a href="{{URL::action('ConsideracionesDirectaController@edit', $persona)}}">
                                        <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar Consideracion"><i class="fa fa-wrench"></i></button>
                                    </a>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
