@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h3>Nómina - Canal: Directa.  <span class="text-green">Mes: {{$mes_en_curso}}</span>
                @if(auth()->user()->hasRoles(['tigo_people_admin']))
                    <a href="ingresar_nuevo_asesor"><button class="btn btn-facebook">Ingresos Mes Actual</button></a>
                    <a href="/excel"><button class="btn btn-github">Exportar</button></a>
                @else
                    @if($habilitar->habilitar_directa == 'si')
                        <a href="ingresar_nuevo_asesor"><button class="btn btn-facebook" data-toggle="tooltip">Ingresos Mes Actual</button></a>
                    @endif
                    <a href="/nomina_x_zona"><button class="btn btn-github">Exportar Nómina</button></a>
                @endif

                @if(auth()->user()->hasRoles(['tigo_people_admin']))
                    <a href="nomina_directa/create"><button class="btn btn-success">Generar Nomina  {{\Carbon\Carbon::now()->addMonths(1)->format('Y-m')}}</button></a>
                @endif

            </h3>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @if (count($errors)>0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <p class="text-info" id="cantidad">Cantidad</p>
            @include('nomina_directa.search_index')
        </div>
    </div>

    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_persona">
                    <thead class="text-center" style="background-color: #8eb4cb">
                    <th>ID</th>
                    <th>Mes</th>
                    <th>CH</th>
                    <th>Representante</th>
                    <th>Perfil Actual/<br>Anterior</th>
                    <th>Rep Zonal/<br>Rep Jefe</th>
                    <th>Oficina</th>
                    <th>Region/Zona</th>
                    <th >Consideración</th>
                    <th >Inactivación</th>
                    <th>Estado</th>
                    <th>%OBJ</th>
                    <th>perfil</th>
                    @if(auth()->user()->hasRoles(['tigo_people_admin', 'zonal']))
                        <th class="text-center col-lg-1">Opciones</th>
                    @endif
                    </thead>
                    @foreach ($personas as $persona)
                        @if(auth()->user()->hasRoles(['zonal', 'tigo_people']))
                            @if(in_array($persona->personaDirecta->id_zona, $zonas))
                                <tr class="text-uppercase text-sm">
                                    <td>{{$persona->id_nomina}}</td>
                                    <td>{{$persona->mes}}</td>
                                    <td>{{$persona->personaDirecta->ch}}</td>
                                    <td>{{$persona->personaDirecta->nombre}}</td>
                                    <td>{{$persona->personaDirecta->agrupacion}}/<br>
                                        {{$persona->personaDirecta->agrupacion_anterior}}</td>
                                    <td>{{$persona->personaDirecta->zona->representante_zonal_nombre}}/<br>{{$persona->personaDirecta->representanteJefe->nombre}}</td>
                                    <td>{{$persona->personaDirecta->representanteJefe->oficina ? $persona->personaDirecta->representanteJefe->oficina->nombre : ''}}</td>
                                    <td>{{$persona->personaDirecta->zona->region->region.' / '.$persona->personaDirecta->zona->zona}}</td>
                                    <td><span class="text-info">Cons.:</span> {{$persona->porcentaje ? $persona->porcentaje->nombre : ''}}<br><span class="text-danger">Estado: </span>{{$persona->estado_consideracion}}</td>
                                    <td><span class="text-info">Motivo: </span>{{$persona->motivo_inactivacion}}<br><span class="text-danger">Estado: </span>{{$persona->estado_inactivacion}}</td>
                                    @if($persona->estado_inactivacion == 'pendiente')
                                        <td>pendiente</td>
                                    @elseif($persona->estado_inactivacion == 'aprobado')
                                        <td class="text-danger">Inactivo</td>
                                    @else
                                        <td class="text-success">Activo</td>
                                    @endif
                                    <td>{{$persona->porcentaje_objetivo ? $persona->porcentaje_objetivo : '100%'}}</td>
                                    <td><img src="{{asset('storage/'.$persona->personaDirecta->avatar)}}" width="30px"></td>
                                    @if($habilitar->habilitar_directa == 'si')
                                        <td>
                                            <a href="{{URL::action('PersonaDirectaController@edit', $persona->personaDirecta)}}">
                                                <button class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Datos del Asesor"><i class="fa fa-pencil"></i></button>
                                            </a>

                                            @if(!$persona->estado_consideracion)
                                                <a href="{{URL::action('NominaDirectaController@agregarConsideraciones',$persona)}}">
                                                    <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="Agregar Consideración"><i class="fa fa-comment"></i></button>
                                                </a>
                                            @endif
                                            @if($persona->estado_nomina == 'rechazado')
                                                <a href="{{URL::action('NominaDirectaController@edit', $persona)}}">
                                                    <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar asesor"><i class="fa fa-wrench"></i></button>
                                                </a>
                                            @endif
                                            @if(!$persona->motivo_inactivacion)
                                                <a href="" data-target="#modal-nomina-delete-{{$persona->id_nomina}}" data-toggle="modal" data-placement="top" title="inactivar" ><button class="btn btn-xs btn-danger"><i class="fa fa-user-times" aria-hidden="true"></i></button></a>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endif
                        @elseif (auth()->user()->hasRoles(['tigo_people_admin']))
                            <tr class="text-uppercase text-sm">
                                <td>{{$persona->id_nomina}}</td>
                                <td>{{$persona->mes}}</td>
                                <td>{{$persona->personaDirecta->ch}}</td>
                                <td>{{$persona->personaDirecta->nombre}}</td>
                                <td>{{$persona->personaDirecta->agrupacion}}/<br>
                                    {{$persona->personaDirecta->agrupacion_anterior}}</td>
                                <td>{{$persona->personaDirecta->zona->representante_zonal_nombre}}/<br>{{$persona->personaDirecta->representanteJefe->nombre}}</td>
                                <td>{{$persona->personaDirecta->representanteJefe->oficina ? $persona->personaDirecta->representanteJefe->oficina->nombre : ''}}</td>
                                <td>{{$persona->personaDirecta->zona->region->region.' / '.$persona->personaDirecta->zona->zona}}</td>
                                <td><span class="text-info">Cons.:</span> {{$persona->consideracion ? $persona->consideracion->nombre : ''}}<br>
                                    @if($persona->estado_consideracion == 'aprobado')
                                        <span class="text-fuchsia">OBS.:</span> {{$persona->porcentaje ? $persona->porcentaje->nombre : ''}}<br>
                                    @endif
                                    <span class="text-danger">Estado:</span>{{$persona->estado_consideracion}}<br>
                                    <span class="text-green">Fecha:</span>{{$persona->fecha_carga_consideracion}}
                                </td>
                                <td><span class="text-info">Motivo: </span>{{$persona->motivo_inactivacion}}<br>
                                    @if($persona->estado_inactivacion == 'aprobado')
                                        <span class="text-fuchsia">OBS.:</span> {{$persona->porcentaje ? $persona->porcentaje->nombre : ''}}<br>
                                    @endif
                                    <span class="text-danger">Estado: </span>{{$persona->estado_inactivacion}}<br>
                                    <span class="text-green">Fecha:</span>{{$persona->fecha_carga_inactivacion}}

                                </td>

                                @if($persona->estado_inactivacion == 'pendiente')
                                    <td>pendiente</td>
                                @elseif($persona->estado_inactivacion == 'aprobado')
                                    <td class="text-danger">Inactivo</td>
                                @else
                                    <td class="text-success">Activo</td>
                                @endif
                                <td>{{$persona->porcentaje ? $persona->porcentaje->porcentaje : '100%'}}</td>
                                <td><img src="{{asset('storage/'.$persona->personaDirecta->avatar)}}" width="30px"></td>
                                <td>
                                    <a href="{{URL::action('PersonaDirectaController@edit', $persona->personaDirecta)}}">
                                        <button class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Datos del Asesor"><i class="fa fa-pencil"></i></button>
                                    </a>

                                    <a href="{{URL::action('HorarioDirectaController@edit', $persona)}}">
                                        <button class="btn btn-github btn-xs" data-toggle="tooltip" data-placement="top" title="Agregar horarios"><i class="fa fa-calendar"></i></button>
                                    </a>

                                    @if(!$persona->estado_consideracion)
                                        <a href="{{URL::action('NominaDirectaController@agregarConsideraciones',$persona)}}">
                                            <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="Agregar Consideración"><i class="fa fa-comment"></i></button>
                                        </a>
                                    @endif
                                    @if($persona->estado_nomina == 'rechazado')
                                        <a href="{{URL::action('NominaDirectaController@edit', $persona)}}">
                                            <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar asesor"><i class="fa fa-wrench"></i></button>
                                        </a>
                                    @endif
                                    @if(!$persona->motivo_inactivacion)
                                        <a href="" data-target="#modal-nomina-delete-{{$persona->id_nomina}}" data-toggle="modal" data-placement="top" title="inactivar" ><button class="btn btn-xs btn-danger"><i class="fa fa-user-times" aria-hidden="true"></i></button></a>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @include('nomina_directa.modal_eliminacion')
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
                var nfilas = $("#tabla_persona tr").length -1;

                $("#cantidad").text(nfilas);


            })
        </script>
    @endpush
@endsection
