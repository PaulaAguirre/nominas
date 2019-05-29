@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Representantes Canal Directa <a href="representantes/create"><button class="btn btn-success">Nuevo</button></a></h3>
                @include('personasDirecta.search')

        </div>
    </div>
    <br>
    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center" style="background-color: #8eb4cb">
                        <th>CH</th>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Representante Zonal</th>
                        <th>Representante Jefe</th>
                        <th>Cargo Go</th>
                        <th>Region</th>
                        <th>Zona</th>
                        <th class="text-center">Opciones</th>

                    </thead>
                    @foreach ($personasDirecta as $persona)
                        <tr class="text-uppercase">
                            <td>{{$persona->ch}}</td>
                            <td>{{$persona->nombre}}</td>
                            <td>{{$persona->documento_persona}}</td>
                            <td>{{$persona->representanteZonal ? $persona->representanteZonal->nombre : '' }}</td>
                            <td>{{$persona->representanteJefe ? $persona->representanteJefe->nombre : ''}}</td>
                            <td>{{$persona->cargo_go}}</td>
                            <td>{{$persona->region->region}}</td>
                            <td>{{$persona->zona->zona}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection