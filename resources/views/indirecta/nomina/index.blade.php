@extends ('layouts.admin_indirecta')
@section ('contenido')
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h3>Nómina - Canal: INDIRECTA.
                @if(auth()->user()->hasRoles(['tigo_people_admin']))
                    <a href="{{url('asesores_indirecta/create')}}"><button class="btn btn-success">Nuevo Ingreso</button></a>
                    <a href="{{url('/excel_tienda')}}"><button class="btn btn-github">Exportar excel</button></a>
                @else
                    @if(\Carbon\Carbon::today() < (new Carbon\Carbon('first day of this month'))->addDay(27))
                        <a href="{{url('impulsadores/create')}}"><button class="btn btn-facebook">Nuevo Ingreso</button></a>
                    @endif
                    <a href="{{url('/excel_tienda_x_zona')}}"><button class="btn btn-github">Exportar Nómina</button></a>
                @endif

                @if(auth()->user()->hasRoles(['tigo_people_admin']))
                    <a href="{{url('nomina_indirecta/create')}}"><button class="btn btn-primary">Generar Nomina  {{\Carbon\Carbon::now()->addMonths(1)->format('Y-m')}}</button></a>
                @endif


            </h3>
            <p class="text-success" id="cantidad">Cantidad</p>

        </div>
    </div>

    @include('indirecta.nomina.search_index')
    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_impulsador">
                    <thead class="text-center text-gray" style="background-color: #5d59a6">
                    <th>ID</th>
                    <th>Mes</th>
                    <th>CH</th>
                    <th>impulsador</th>
                    <th>Clasificación</th>
                    <th>Zona / Rep Zonal</th>
                    <th>Coordinador</th>
                    <th>Consideración</th>
                    <th>Inactivación</th>
                    <th>%OBJ</th>
                    <th class="text-center col-lg-1">Opciones</th>
                    </thead>
                    @foreach ($impulsadores as $impulsador)
                        @if($impulsador->impulsador)
                            <tr class="text-uppercase text-sm">
                                <td>{{$impulsador->id}}</td>
                                <td>{{$impulsador->mes}}</td>
                                <td>{{$impulsador->impulsador ?  $impulsador->impulsador->ch : ''}}</td>
                                <td>{{$impulsador->impulsador ? $impulsador->impulsador->nombre : ''}}</td>
                                <td>{{$impulsador->impulsador ? $impulsador->impulsador->clasificacion : ''}}</td>
                                <td>{{$impulsador->impulsador->zona->nombre.' / '.$impulsador->impulsador->zona->representante_zonal_nombre}}</td>
                                <td> {{$impulsador->impulsador ? $impulsador->impulsador->coordinador->nombre : 'Sin Jefe'}}</td>
                                <td><span class="text-info">Cons.:</span> {{$impulsador->consideracion ? $impulsador->consideracion->nombre : ''}}<br><span class="text-danger">Estado: </span>{{$impulsador->estado_consideracion}}</td>
                                @if($impulsador->estado_inactivacion == 'pendiente')
                                    <td class="text-warning">pendiente</td>
                                @elseif($impulsador->estado_inactivacion == 'aprobado')
                                    <td class="text-danger">Inactivo</td>
                                @else
                                    <td class="text-success">Activo</td>
                                @endif
                                <td>{{$impulsador->porcentaje_objetivo}}</td>
                                <td>

                                </td>
                            </tr>
                        @endif

                    @endforeach

                </table>
            </div>
        </div>
    </div>



    @push('scripts')
        <script>
            $(document).ready(function () {
                $("#btn_enviar").hide();
                $("#btn_cancelar").hide();

                var cont  = 0;
                var nfilas = $("#tabla_impulsador tr").length -1;

                $("#cantidad").text(nfilas);


            })
        </script>
    @endpush

@endsection
