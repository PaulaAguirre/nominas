<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Mes</th>
        <th>CH</th>
        <th>NOMBRE</th>
        <th>Cedula</th>
        <th>JEFE_CH</th>
        <th>NOMBRE_JEFE</th>
        <th>CEDULA Jefe</th>
        <th>fecha cambio Jefe</th>
        <th>clasificación</th>
        <th>ZONA</th>
        <th>ID ZONA</th>
        <th>EH_ZONAL</th>
        <th>JEFE ZONAL</th>
        <th>REGION</th>
        <th>F INGRESO</th>
        <th>OBS (Consideración)</th>
        <th>% Objetivos</th>
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
    @foreach($impulsadores as $impulsador)
            <tr>
                <td>{{$impulsador->id}}</td>
                <td>{{$impulsador->mes}}</td>
                <td>{{$impulsador->impulsador->ch }}</td>
                <td>{{$impulsador->impulsador->nombre }}</td>
                <td>{{$impulsador->impulsador->documento}}</td>
                <td>{{$impulsador->impulsador->coordinador->ch}}</td>
                <td>{{$impulsador->impulsador->coordinador->nombre}}</td>
                <td>{{$impulsador->impulsador->coordinador->documento}}</td>
                <td>{{$impulsador->impulsador->fecha_cambio_coordinador}}</td>
                <td>{{$impulsador->impulsador->clasificacion ? $impulsador->impulsador->clasificacion->nombre : ''}}</td>
                <td>{{$impulsador->impulsador->zona->nombre.' / '.$impulsador->impulsador->zona->representante_zonal_nombre}}</td>
                <td>{{$impulsador->impulsador->zona_id}}</td>
                <td>{{$impulsador->impulsador->zona->representante_zonal_ch }}</td>
                <td>{{$impulsador->impulsador->zona->representante_zonal_nombre }}</td>
                <td>{{$impulsador->impulsador->zona->region->region }}</td>
                <td>{{$impulsador->consideracion_id == 6 ? $impulsador->impulsador->fecha_ingreso : ''}}</td>
                <td>{{$impulsador->consideracion ? $impulsador->consideracion->nombre : 'OK'}}</td>
                <td>{{$impulsador->porcentaje_objetivo ? $impulsador->porcentaje_objetivo : '100%' }}</td>
                <td>{{$impulsador->detalles_consideracion}}</td>
                <td>{{$impulsador->estado_consideracion}}</td>
                <td>{{$impulsador->comentarios_consideracion}}</td>
                <td>{{$impulsador->estado_inactivacion == 'aprobado' ? 'inactivo': 'activo'}}</td>
                <td>{{$impulsador->comentarios_inactivacion}}</td>
                <td>{{$impulsador->estado_inactivacion}}</td>
                <td>{{$impulsador->fecha_aprobacion_consideracion}}</td>
                <td>{{$impulsador->fecha_aprobacion_inactivacion}}</td>
            </tr>
    @endforeach
    </tbody>
</table>
