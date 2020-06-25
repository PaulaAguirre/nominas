<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>CH</th>
        <th>NOMBRE</th>
        <th>Cedula</th>
        <th>JEFE_CH</th>
        <th>NOMBRE_JEFE</th>
        <th>CEDULA Jefe</th>
        <th>ZONA</th>
        <th>EH_ZONAL</th>
        <th>JEFE ZONAL</th>
        <th>REGION</th>
        <th>ID PDV</th>
        <th>CIRCUITO</th>
        <th>RAZON SOCIAL</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pdvs as $pdv)
        <tr>
            <td>{{$pdv->id}}</td>
            <td>{{$pdv->impulsador ? $pdv->impulsador->ch : ''}}</td>
            <td>{{$pdv->impulsador ? $pdv->impulsador->nombre : ''}}</td>
            <td>{{$pdv->impulsador ? $pdv->impulsador->documento : ''}}</td>
            <td>{{$pdv->impulsador ? $pdv->impulsador->coordinador->ch : ''}}</td>
            <td>{{$pdv->impulsador ? $pdv->impulsador->coordinador->nombre : ''}}</td>
            <td>{{$pdv->impulsador ? $pdv->impulsador->coordinador->documento : ''}}</td>
            <td>{{$pdv->impulsador ? $pdv->impulsador->zona->nombre : ''}}</td>
            <td>{{$pdv->impulsador ? $pdv->impulsador->zona->representante_zonal_ch : ''}}</td>
            <td>{{$pdv->impulsador ? $pdv->impulsador->zona->representante_zonal_nombre : ''}}</td>
            <td>{{$pdv->circuito->zona ? $pdv->circuito->zona->region->region : ''}}</td>
            <td>{{$pdv->codigo}}</td>
            <td>{{$pdv->circuito->codigo}}</td>
            <td>{{$pdv->nombre}}</td>

        </tr>
    @endforeach
    </tbody>
</table>
