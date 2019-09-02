<table>
    <thead>
    <tr>
        <th>mes</th>
        <th>ch</th>
        <th>nombre</th>
        <th>zona</th>
    </tr>
    </thead>
    <tbody>
    @foreach($personas as $persona)
        <tr>
            <td>{{ $persona->mes }}</td>
            <td>{{ $persona->personaDirecta->ch}}</td>
            <td>{{ $persona->personaDirecta->nombre }}</td>
            <td>{{ $persona->personaDirecta->zona->zona }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
