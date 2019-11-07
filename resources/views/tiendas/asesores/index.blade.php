@extends ('layouts.admin_tienda')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Representantes Canal Directa (todas las zonas)
                    <a href="asesores_tienda/create"><button class="btn btn-success">Nuevo Asesor  <i class="fa fa-user-plus" aria-hidden="true"></i></button></a></h3>

        </div>
    </div>
    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center" style="background-color: #2ab27b">
                        <th>ID</th>
                        <th>CH</th>
                        <th>Nombre</th>
                        <th>Staff</th>
                        <th>CI</th>
                        <th>Jefe Zonal</th>
                        <th>Jefe Tienda</th>
                        <th>Team Leader</th>
                        <th>Zona</th>
                        <th>Tienda</th>
                        <th>Estado</th>
                        <th class="text-center">Opciones</th>

                    </thead>
                    @foreach ($asesores as $asesor)
                        <tr class="text-uppercase text-sm">
                            <td>{{$asesor->id}}</td>
                            <td>{{$asesor->ch}}</td>
                            <td>{{$asesor->nombre}}</td>
                            <td>{{$asesor->staff}}</td>
                            <td>{{$asesor->documento}}</td>
                            <td>{{$asesor->zona($asesor->id)->representante_zonal_nombre}}</td>
                            <td>{{$asesor->tienda->jefetienda ? $asesor->tienda->jefetienda->nombre : 'sin jefe'}}</td>
                            <td>{{$asesor->teamleader->nombre}}</td>
                            <td>{{$asesor->zona($asesor->id)->zona}}</td>
                            <td>{{$asesor->tienda->nombre}}</td>
                            <td>{{$asesor->estado}}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
