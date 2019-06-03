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
                            <td>
                                <a href="{{URL::action ('PersonaDirectaController@edit', $persona)}}"><button class="btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>
                                <a href="" data-target="#modal-delete-{{$persona->id}}" data-toggle="modal" data-placement="top" title="Inactivar"><button class="btn-xs btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            @include('personasDirecta.modal')
        </div>
    </div>

@endsection
