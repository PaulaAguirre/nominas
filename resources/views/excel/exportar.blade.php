<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Mes</th>
        <th>EH_JEFE</th>
        <th>NOMBRE_JEFE</th>
        <th>CEDULA</th>
        <th>CH</th>
        <th>NOMBRE</th>
        <th>NEW PERFIL</th>
        <th>ZONA</th>
        <th>ID ZONA</th>
        <th>EH_ZONAL</th>
        <th>ENCARGADO</th>
        <th>TERRITORIO</th>
        <th>F INGRESO</th>
        <th>OBS</th>
        <th>Comentarios</th>
    </tr>
    </thead>
    <tbody>
    @foreach($personas as $persona)
        @if($persona->estado_inactivacion  != 'aprobado' and $persona->personaDirecta )
            <tr>
                <td>{{$persona->id_nomina}}</td>
                <td>{{$persona->mes}}</td>
                <td>{{$persona->personaDirecta->representanteJefe->ch }}</td>
                <td>{{$persona->personaDirecta->representanteJefe->nombre }}</td>
                <td>{{$persona->personaDirecta->representanteJefe->documento_persona }}</td>
                <td>{{$persona->personaDirecta->ch }}</td>
                <td>{{$persona->personaDirecta->nombre }}</td>
                <td>{{$persona->personaDirecta->agrupacion }}</td>
                <td>{{$persona->personaDirecta->zona->familiazona ? $persona->personaDirecta->zona->familiazona->nombre : '' }}</td>
                <td>{{$persona->personaDirecta->zona->id_familiazona }}</td>
                <td>{{$persona->personaDirecta->zona->representante_zonal_ch }}</td>
                <td>{{$persona->personaDirecta->zona->representante_zonal_nombre }}</td>
                <td>{{$persona->personaDirecta->zona->region->region }}</td>
                <td>{{$persona->id_consideracion == 6 ? $persona->personaDirecta->fecha_ingreso : ''}}</td>
                <td>{{$persona->estado_consideracion == 'aprobado' ? $persona->consideracion->nombre : 'OK'}}</td>
                <td>{{$persona->estado_consideracion == 'aprobado' ? $persona->comentario_consideracion : ''}}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
