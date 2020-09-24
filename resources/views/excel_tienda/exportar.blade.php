<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Mes</th>
        <th>CH</th>
        <th>NOMBRE</th>
        <th>Cedula</th>
        <th>Tienda</th>
        <th>JEFE_tienda_CH</th>
        <th>NOMBRE_JEFE_tienda</th>
        <th>CEDULA Jefe_tienda</th>
        <th>fecha cambio TL</th>
        <th>Teamleader CH</th>
        <th>NOMBRE_teamleader</th>
        <th>CEDULA teamleader</th>
        <th>Sup guia CH</th>
        <th>DOC Sup guia</th>
        <th>Sup guia Nombre</th>
        <th>CARGO_GO</th>
        <th>CARGO_ANTERIOR</th>
        <th>AGRUPACIÓN</th>
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
    @foreach($asesores as $asesor)
            <tr>
                <td>{{$asesor->id}}</td>
                <td>{{$asesor->mes}}</td>
                <td>{{$asesor->asesor->ch }}</td>
                <td>{{$asesor->asesor->nombre }}</td>
                <td>{{$asesor->asesor->documento}}</td>
                <td>{{$asesor->asesor->tienda->tienda_nombre}}</td>
                <td>{{$asesor->asesor->tienda->jefetienda ? $asesor->asesor->tienda->jefetienda->ch : ''}}</td>
                <td>{{$asesor->asesor->tienda->jefetienda ? $asesor->asesor->tienda->jefetienda->nombre : ''}}</td>
                <td>{{$asesor->asesor->tienda->jefetienda ? $asesor->asesor->tienda->jefetienda->cedula : '' }}</td>
                <td>{{$asesor->fecha_cambio_jefe}}</td>
                <td>{{$asesor->asesor->teamleader->ch }}</td>
                <td>{{$asesor->asesor->teamleader->nombre}}</td>
                <td>{{$asesor->asesor->teamleader->documento}}</td>
                <td>{{$asesor->asesor->supervisor ? $asesor->asesor->supervisor->ch : ''}}</td>
                <td>{{$asesor->asesor->supervisor ? $asesor->asesor->supervisor->documento : ''}}</td>
                <td>{{$asesor->asesor->supervisor ? $asesor->asesor->supervisor->nombre : ''}}</td>
                <td>{{$asesor->asesor->cargo_go }}</td>
                <td>{{$asesor->asesor->cargo_anterior}}</td>
                <Td>{{$asesor->asesor->agrupacion}}</Td>
                <td>{{$asesor->asesor->tienda->zona->familiazona ? $asesor->asesor->tienda->zona->familiazona->nombre : '' }}</td>
                <td>{{$asesor->asesor->tienda->zona->familiazona ? $asesor->asesor->tienda->zona->familiazona->id : ''}}</td>
                <td>{{$asesor->asesor->tienda->zona->representante_zonal_ch }}</td>
                <td>{{$asesor->asesor->tienda->zona->representante_zonal_nombre  }}</td>
                <td>{{$asesor->asesor->tienda->zona->region->region }}</td>
                <td>{{$asesor->id_consideracion == 6 ? $asesor->asesor->fecha_ingreso : ''}}</td>
                <td>{{$asesor->consideracion ? $asesor->consideracion->nombre : 'OK'}}</td>
                <td>{{$asesor->porcentaje_objetivo ? $asesor->porcentaje_objetivo : '100%' }}</td>
                <td>{{$asesor->detalles_consideracion}}</td>
                <td>{{$asesor->estado_consideracion}}</td>
                <td>{{$asesor->comentarios_consideracion}}</td>
                <td>{{$asesor->estado_inactivacion == 'aprobado' ? 'inactivo': 'activo'}}</td>
                <td>{{$asesor->comentarios_inactivacion}}</td>
                <td>{{$asesor->estado_inactivacion}}</td>
                <td>{{$asesor->fecha_aprobacion_consideracion}}</td>
                <td>{{$asesor->fecha_aprobacion_inactivacion}}</td>
            </tr>
    @endforeach
    </tbody>
</table>
