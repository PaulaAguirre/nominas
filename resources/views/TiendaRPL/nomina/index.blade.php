@extends ('layouts.admin_tienda')
@section ('contenido')
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h3>Nómina - Canal: Tiendas - Mes: {{$mes_nomina}}.
                @if(auth()->user()->hasRoles(['tigo_people_admin']))
                    <a href="{{url('/excel_tienda_rpl')}}"><button class="btn btn-github">Exportar excel</button></a>
                @else
                    <a href="{{url('/excel_tienda_rpl')}}"><button class="btn btn-github">Exportar Nómina</button></a>
                @endif
            </h3>
            <p class="text-success" id="cantidad">Cantidad</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @if (count($errors)>0)
                <div class="alert alert-warning alert-dismissible ">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></li>

                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    @include('TiendaRPL.nomina.search_index')
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
                    <th>Ret</th>
                    <th>Zona / <br>Rep Zonal</th>
                    <th>Tienda / Jefe Tienda </th>
                    <th>Team Leader</th>
                    <th>Supervisor Guia</th>
                    <th>Consideración</th>
                    <th>Inactivación</th>
                    <th>%OBJ</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($asesores as $asesor)
                        @if($asesor->asesor)
                            <tr class="text-uppercase text-sm">
                                <td>{{$asesor->id}}</td>
                                <td>{{$asesor->mes}}</td>
                                <td>{{$asesor->asesor ?  $asesor->asesor->ch : ''}}</td>
                                <td>{{$asesor->asesor ? $asesor->asesor->nombre : ''}}</td>
                                <td>{{$asesor->asesor ? $asesor->asesor->cargo_go : ''}}</td>
                                <td>{{$asesor->asesor->especialista == 'si' ? 'si': 'no'}}</td>
                                <td class="col-lg-1">{{$asesor->asesor->tienda->zona->zona}} / <br>{{$asesor->asesor->tienda->zona->representante_zonal_nombre}}</td>
                                <td>{{$asesor->asesor->tienda->tienda_nombre}} / <br>{{$asesor->asesor->tienda->jefetienda ? $asesor->asesor->tienda->jefetienda->nombre : 'Sin Jefe'}}</td>
                                <td>{{$asesor->asesor->teamleader ? $asesor->asesor->teamleader->nombre : ''}}</td>
                                <td>{{$asesor->asesor->supervisor ? $asesor->asesor->supervisor->nombre : ''}}</td>
                                <td><span class="text-info">Cons.:</span> {{$asesor->consideracion ? $asesor->consideracion->nombre : ''}}<br><span class="text-danger">Estado: </span>{{$asesor->estado_consideracion}}</td>
                                <td><span class="text-info">Motivo: </span>{{$asesor->motivo_inactivacion}}<br>
                                    <span class="text-danger">Estado: </span>{{$asesor->estado_inactivacion ? $asesor->estado_inactivacion : 'activo'}}<br>
                                    <span class="text-green">Fecha:</span>{{$asesor->fecha_aprobacion_inactivacion}}
                                </td>
                                <td>{{$asesor->porcentaje_objetivo}}</td>
                                <td>
                                    @if(auth()->user()->hasRoles(['zonal']))
                                        @if((\Carbon\Carbon::today() < (new Carbon\Carbon('first day of this month'))->addDay(27)))
                                        <a href="{{URL::action('AsesorTiendaRPLController@edit', $asesor->asesor->id)}}">
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
                                        <a href="{{URL::action('AsesorTiendaRPLController@edit', $asesor->asesor->id)}}">
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
                        @endif
                            @include('TiendaRPL.asesores.modal_eliminacion')
                            @include('TiendaRPL.consideraciones.crear_consideracion_modal')
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
