@extends ('layouts.admin_tienda')
@section ('contenido')
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h3>Nómina - Canal: Directa.
                @if(auth()->user()->hasRoles(['tigo_people_admin']))
                    <a href="{{url('asesores_tienda/create')}}"><button class="btn btn-success">Nuevo Ingreso</button></a>
                    <a href="/excel"><button class="btn btn-github">Exportar excel</button></a>
                @else
                    @if(\Carbon\Carbon::today() < (new Carbon\Carbon('first day of this month'))->addDay(27))
                        <a href="{{url('asesores_tienda/create')}}"><button class="btn btn-facebook">Nuevo Ingreso</button></a>
                    @endif
                    <a href="/nomina_x_zona"><button class="btn btn-github">Exportar Nómina</button></a>
                @endif

                @if(auth()->user()->hasRoles(['tigo_people_admin']))
                    <a href="{{url('nomina_tienda/create')}}"><button class="btn btn-google">Generar Nomina  {{\Carbon\Carbon::now()->addMonths(1)->format('Y-m')}}</button></a>
                @endif


            </h3>
            <p class="text-success" id="cantidad">Cantidad</p>

        </div>
    </div>


    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_asesor">
                    <thead class="text-center" style="background-color: #2ab27b">
                    <th>ID</th>
                    <th>Mes</th>
                    <th>CH</th>
                    <th>Asesor</th>
                    <th>Cargo</th>
                    <th>Zona / Rep Zonal</th>
                    <th>Tienda / Jefe Tienda </th>
                    <th>Team Leader</th>
                    <th>Inactivación</th>
                    <th class="text-center col-lg-1">Opciones</th>
                    </thead>
                    @foreach ($asesores as $asesor)
                        <tr class="text-uppercase text-sm">
                            <td>{{$asesor->id}}</td>
                            <td>{{$asesor->mes}}</td>
                            <td>{{$asesor->asesor->ch}}</td>
                            <td>{{$asesor->asesor->nombre}}</td>
                            <td>{{$asesor->asesor->cargo_go}}</td>
                            <td>{{$asesor->asesor->tienda->zona->zona.' / '.$asesor->asesor->tienda->zona->representante_zonal_nombre}}</td>
                            <td>{{$asesor->asesor->tienda->tienda_nombre}} / {{$asesor->asesor->tienda->jefetienda ? $asesor->asesor->tienda->jefetienda->nombre : 'Sin Jefe'}}</td>
                            <td>{{$asesor->asesor->teamleader->nombre}}</td>
                            @if($asesor->estado_inactivacion == 'pendiente')
                                <td class="text-warning">pendiente</td>
                            @elseif($asesor->estado_inactivacion == 'aprobado')
                                <td class="text-danger">Inactivo</td>
                            @else
                                <td class="text-success">Activo</td>
                            @endif
                            <td>
                                @if(auth()->user()->hasRoles(['zonal']))
                                    @if((\Carbon\Carbon::today() < (new Carbon\Carbon('first day of this month'))->addDay(5)))
                                    <a href="{{URL::action('AsesorTiendaController@edit', $asesor->asesor->id)}}">
                                        <button class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Datos del Asesor"><i class="fa fa-pencil"></i></button>
                                    </a>
                                    @if(!$asesor->estado_consideracion)
                                        <a href="" data-target="#modal-consideracion-store-{{$asesor->id}}" data-toggle="modal" data-placement="top" title="Consideración" ><button class="btn btn-xs btn-facebook"><i class="fa fa-comment" aria-hidden="true"></i></button></a>
                                    @endif
                                    @if(!$asesor->estado_inactivacion)
                                        <a href="" data-target="#modal-nomina-delete-{{$asesor->id}}" data-toggle="modal" data-placement="top" title="inactivar" ><button class="btn btn-xs btn-danger"><i class="fa fa-user-times" aria-hidden="true"></i></button></a>
                                    @endif
                                    @endif
                                @else
                                    <a href="{{URL::action('AsesorTiendaController@edit', $asesor->asesor->id)}}">
                                        <button class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Datos del Asesor"><i class="fa fa-pencil"></i></button>
                                    </a>
                                    @if(!$asesor->estado_consideracion)
                                        <a href="" data-target="#modal-consideracion-store-{{$asesor->id}}" data-toggle="modal" data-placement="top" title="Consideración" ><button class="btn btn-xs btn-facebook"><i class="fa fa-comment" aria-hidden="true"></i></button></a>
                                    @endif
                                    @if(!$asesor->estado_inactivacion)
                                        <a href="" data-target="#modal-nomina-delete-{{$asesor->id}}" data-toggle="modal" data-placement="top" title="inactivar" ><button class="btn btn-xs btn-danger"><i class="fa fa-user-times" aria-hidden="true"></i></button></a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                            @include('tiendas.asesores.modal_eliminacion')
                            @include('tiendas.consideraciones.crear_consideracion_modal')
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
                var nfilas = $("#tabla_asesor tr").length -1;

                $("#cantidad").text(nfilas);


            })
        </script>
    @endpush

@endsection
