@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Asesores Inactivados</h3>

        </div>
    </div>
    <br>
    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center" style="background-color: #8eb4cb">
                        <th>ID</th>
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
                    @foreach ($inactivaciones as $persona)
                        <tr class="text-uppercase text-sm">
                            <td>{{$persona->id_nomina}}</td>
                            <td>{{$persona->personaDirecta->ch}}</td>
                            <td>{{$persona->personaDirecta->nombre}}</td>
                            <td>{{$persona->personaDirecta->documento_persona}}</td>
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
                            <td class="text-center">
                                @if($persona->estado_inactivacion == 'rechazado')
                                    <a href="{{URL::action('InactivacionesDirectaController@edit', $persona)}}">
                                        <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar Inactivacion"><i class="fa fa-wrench"></i></button>
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
