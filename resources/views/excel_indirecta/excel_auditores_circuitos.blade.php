<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>CIRCUITO</th>
        <th>ZONA</th>
        <th>CH Auditor</th>
        <th>Cedula</th>
        <th>NOMBRE</th>
    </tr>
    </thead>
    <tbody>
    @foreach($auditores as $auditor)
        @if($auditor->circuitos)
            @foreach($auditor->circuitos as $circuito)
                <tr>
                    <td>{{$circuito->id}}</td>
                    <td>{{$circuito->codigo}}</td>
                    <td>{{$circuito->zona->nombre}}</td>
                    <td>{{$auditor->ch}}</td>
                    <td>{{$auditor->documento}}</td>
                    <td>{{$auditor->nombre}}</td>

                </tr>
            @endforeach
        @endif
    @endforeach
    </tbody>
</table>
