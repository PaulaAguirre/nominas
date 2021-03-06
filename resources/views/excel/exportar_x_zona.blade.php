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
        <th>OBS (Consideración)</th>
        <th>% Objetivos</th>
        <th>Comentarios Zonal</th>
        <th>Comentarios Canales</th>
        <th>Activo</th>
        <th>Obs inactivacion canales</th>
        <th>Dias</th>
        <th>Hora entrada</th>
        <th>Hora salida</th>

    </tr>
    </thead>
    <tbody>
    @foreach($personas as $persona)
        @if($persona->estado_inactivacion  != 'aprobado' and $persona->personaDirecta )
            @if(in_array($persona->personaDirecta->id_zona, $zonas))
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
                    <td>{{$persona->porcentaje_objetivo ? $persona->porcentaje_objetivo : '100%' }}</td>
                    <td>{{$persona->detalles_consideracion}}</td>
                    <td>{{$persona->estado_consideracion == 'aprobado' ? $persona->comentario_consideracion : ''}}</td>
                    <td>{{$persona->estado_inactivacion == 'aprobado' ? 'inactivo': 'activo'}}</td>
                    <td>{{$persona->comentario_inactivacion}}</td>
                    <td>{{$persona->dias}}</td>
                    <td>{{$persona->hora_entrada}}</td>
                    <td>{{$persona->hora_salida}}</td>
                </tr>
            @endif
        @endif
    @endforeach
    </tbody>
</table>
