{!! Form::open(array('url'=>'/excel','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
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
        <th>Representante_doc</th>

    </tr>
    </thead>
    <tbody>
    @foreach($personas as $persona)
        <tr>
            <td>{{ $persona->mes }}</td>
            <td>{{$persona->zona->region->region}}</td>
            <td>{{$persona->zona->zona}}</td>
            <td>{{$persona->zona->representante_zonal_ch}}</td>
            <td>{{$persona->zona->representante_zonal_nombre}}</td>
            <td>{{$persona->representanteJefe->ch}}</td>
            <td>{{$persona->representanteJefe->nombre}}</td>
            <td>{{ $persona->ch}}</td>
            <td>{{ $persona->nombre }}</td>
            <td>{{$persona->documento_persona}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
{{Form::close()}}
