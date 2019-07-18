@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Consideraciones Asesores Directa</h3>

        </div>
    </div>
    <br>
    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center" style="background-color: #8eb4cb">
                        <th>CH</th>
                        <th>Nombre</th>
                        <th>CI</th>
                        <th>Representante Zonal / Jefe</th>
                        <th>Consideración</th>
                        <th>Detalles</th>
                        <th>Estado</th>
                        <th>Rechazo</th>
                        <th class="text-center">Opciones</th>

                    </thead>
                    @foreach ($personas_consideracion as $persona)
                        <tr class="text-uppercase">
                            <td>{{$persona->personaDirecta->ch}}</td>
                            <td>{{$persona->personaDirecta->nombre}}</td>
                            <td>{{$persona->personaDirecta->documento_persona}}</td>
                            <td>{{$persona->personaDirecta->zona->representante_zonal_nombre ? $persona->personaDirecta->zona->representante_zonal_nombre : '' }} /
                                {{$persona->personaDirecta->representanteJefe ? $persona->personaDirecta->representanteJefe->nombre : ''}}</td>
                            <td>{{$persona->consideracion->nombre}}</td>
                            <td>{{$persona->detalles_consideracion}}</td>
                            @if ($persona->estado_consideracion == 'pendiente')
                                <td class="text-info">{{$persona->estado_consideracion}}</td>
                            @elseif ($persona->estado_consideracion == 'aprobado')
                                <td class="text-green">{{$persona->estado_consideracion}}</td>
                            @else
                                <td class="text-danger">{{$persona->estado_consideracion}}</td>
                            @endif
                            <td>{{$persona->motivo_rechazo}}</td>
                            <td>
                                <a href="{{URL::action ('PersonaDirectaController@edit', $persona)}}"><button class="btn-xs btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>
                                <a href="" data-target="#modal-delete-{{$persona->id}}" data-toggle="modal" data-placement="top" title="Inactivar"><button class="btn-xs btn-danger"><i class="fa fa-user-times" aria-hidden="true"></i></button></a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
