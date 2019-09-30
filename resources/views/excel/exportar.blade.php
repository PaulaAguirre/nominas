<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Mes</th>
        <th>EH_JEFE</th>
        <th>NOMBRE_JEFE</th>
        <th>CEDULA Jefe</th>
        <th>CH</th>
        <th>NOMBRE</th>
        <th>Cedula</th>
        <th>NEW PERFIL</th>
        <th>ZONA</th>
        <th>ID ZONA</th>
        <th>EH_ZONAL</th>
        <th>ENCARGADO</th>
        <th>TERRITORIO</th>
        <th>F INGRESO</th>
        <th>OBS</th>
        <th>Comentarios Zonal</th>
        <th>Estado Consideración</th>
        <th>Comentarios canales</th>
        <th>Estado</th>
        <th>Obs inactivacion canales</th>
        <th>Estado Inactivación</th>
        <th>Fecha aprobación Consideración</th>
        <th>Fecha aprobación inactivación</th>
    </tr>
    </thead>
    <tbody>
    @foreach($personas as $persona)
        @if($persona->estado_nomina == 'aprobado' or $persona->estado_nomina == 'pendiente')
            <tr>
                <td>{{$persona->id_nomina}}</td>
                <td>{{$persona->mes}}</td>
                <td>{{$persona->personaDirecta->representanteJefe->ch }}</td>
                <td>{{$persona->personaDirecta->representanteJefe->nombre }}</td>
                <td>{{$persona->personaDirecta->representanteJefe->documento_persona }}</td>
                <td>{{$persona->personaDirecta->ch }}</td>
                <td>{{$persona->personaDirecta->nombre }}</td>
                <td>{{$persona->personaDirecta->documento_persona}}</td>
                <td>{{$persona->personaDirecta->agrupacion }}</td>
                <td>{{$persona->personaDirecta->zona->familiazona ? $persona->personaDirecta->zona->familiazona->nombre : '' }}</td>
                <td>{{$persona->personaDirecta->zona->id_familiazona }}</td>
                <td>{{$persona->personaDirecta->zona->representante_zonal_ch }}</td>
                <td>{{$persona->personaDirecta->zona->representante_zonal_nombre }}</td>
                <td>{{$persona->personaDirecta->zona->region->region }}</td>
                <td>{{$persona->id_consideracion == 6 ? $persona->personaDirecta->fecha_ingreso : ''}}</td>
                <td>{{$persona->estado_consideracion == 'aprobado' ? $persona->consideracion->nombre : 'OK'}}</td>
                <td>{{$persona->detalles_consideracion}}</td>
                <td>{{$persona->estado_consideracion}}</td>
                @if($persona->estado_consideracion == 'aprobado')
                    <td> {{$persona->comentario_consideracion}}</td>
                @elseif($persona->estado_consideracion == 'rechazado')
                    <td> {{$persona->motivo_rechazo_consideracion}}</td>
                @else
                    <td></td>
                @endif
                <td>{{$persona->estado_inactivacion == 'aprobado' ? 'inactivo': 'activo'}}</td>
                <td>{{$persona->comentario_inactivacion}}</td>
                <td>{{$persona->estado_inactivacion}}</td>
                <td>{{$persona->fecha_aprobacion_consideracion}}</td>
                <td>{{$persona->fecha_aprobacion_inactivacion}}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
