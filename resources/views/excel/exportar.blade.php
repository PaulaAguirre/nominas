<table>
    <thead>
    <tr>
        <th>mes</th>
        <th>Region</th>
        <th>Zona</th>
        <th>Representante_zonal_ch</th>
        <th>Representante_zonal_nombre</th>
        <th>Representante_jefe_ch</th>
        <th>Representante_jefe_nombre</th>
        <th>Representante_ch</th>
        <th>Representante_nombre</th>
        <th>Consideraciones</th>
        <th>detalles</th>
        <th>Comentarios</th>
    </tr>
    </thead>
    <tbody>
    @foreach($personas as $persona)
        <tr>
            <td>{{ $persona->mes }}</td>
            <td>{{$persona->personaDirecta->zona->region->region}}</td>
            <td>{{$persona->personaDirecta->zona->zona}}</td>
            <td>{{$persona->personaDirecta->zona->representante_zonal_ch}}</td>
            <td>{{$persona->personaDirecta->zona->representante_zonal_nombre}}</td>
            <td>{{$persona->personaDirecta->representanteJefe->ch}}</td>
            <td>{{$persona->personaDirecta->representanteJefe->nombre}}</td>
            <td>{{ $persona->personaDirecta->ch}}</td>
            <td>{{ $persona->personaDirecta->nombre }}</td>
            <td>{{ $persona->consideracion->nombre }}</td>
            <td>{{$persona->detalles_consideracion}}</td>
            <td>{{$persona->comentario_consideracion}}</td>

        </tr>
    @endforeach
    </tbody>
</table>
