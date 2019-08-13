@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h3>Nómina - Canal: Directa.
                @if(auth()->user()->hasRoles(['tigo_people_admin']))
                    <a href="nomina_directa/create"><button class="btn btn-success">Generar Nomina</button></a>
                @endif
                @if(auth()->user()->hasRoles(['tigo_people', 'zonal']))
                    @if(\Carbon\Carbon::today() < (new Carbon\Carbon('first day of this month'))->addDay(15))
                        <a href="nomina_directa/create"><button class="btn btn-success">Generar Nomina</button></a>
                    @endif
                @endif
            </h3>
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
                    <th>Agrupación</th>
                    <th>Rep Zonal - Rep Jefe</th>
                    <th>Region/Zona</th>
                    <th>Estado</th>
                   @if(auth()->user()->hasRoles(['tigo_people_admin', 'zonal']))
                        <th class="text-center">Opciones</th>
                    @endif
                    </thead>
                    @foreach ($personas as $persona)
                        <tr class="text-uppercase text-sm">
                            @if(auth()->user()->hasRoles(['zonal', 'tigo_people']))
                                @if($zonas->contains($persona->personaDirecta->id_zona))
                                    <td>{{$persona->id_nomina}}</td>
                                    <td>{{$persona->mes}}</td>
                                    <td>{{$persona->personaDirecta->ch}}</td>
                                    <td>{{$persona->personaDirecta->nombre}}</td>
                                    <td>{{$persona->agrupacion}}</td>
                                    <td>{{$persona->personaDirecta->zona->representante_zonal_nombre}} / {{$persona->personaDirecta->representanteJefe->nombre}}</td>
                                    <td>{{$persona->personaDirecta->zona->region->region.' / '.$persona->personaDirecta->zona->zona}}</td>
                                    @if($persona->estado_nomina == 'pendiente')
                                        <td class="alert-warning">{{$persona->estado_nomina}}</td>
                                    @elseif ($persona->estado_nomina == 'rechazado')
                                        <td class="alert-danger">{{$persona->estado_nomina}}</td>
                                    @else
                                        <td class="alert-success">{{$persona->estado_nomina}}</td>
                                    @endif
                                    @if(auth()->user()->hasRoles(['zonal']))
                                        <td>
                                            <a href="{{URL::action('PersonaDirectaController@edit', $persona->personaDirecta)}}">
                                                <button class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Datos del Asesor"><i class="fa fa-pencil"></i></button>
                                            </a>
                                            <a href="{{URL::action('NominaDirectaController@agregarConsideraciones',$persona)}}">
                                                <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="Agregar Consideración"><i class="fa fa-comment"></i></button>
                                            </a>
                                            </a>
                                            @if($persona->estado_nomina == 'rechazado')
                                                <a href="{{URL::action('NominaDirectaController@edit', $persona)}}">
                                                    <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar asesor"><i class="fa fa-wrench"></i></button>
                                                </a>
                                            @endif
                                            <a href="" data-target="#modal-nomina-delete-{{$persona->id_persona_directa}}" data-toggle="modal" data-placement="top" title="inactivar" ><button class="btn-xs btn-danger"><i class="fa fa-user-times" aria-hidden="true"></i></button></a>                                        </td>
                                    @endif
                                @endif
                            @elseif (auth()->user()->hasRoles(['tigo_people_admin']))
                                <td>{{$persona->id_persona_directa}}</td>
                                <td>{{$persona->mes}}</td>
                                <td>{{$persona->personaDirecta->ch}}</td>
                                <td>{{$persona->personaDirecta->nombre}}</td>
                                <td>{{$persona->agrupacion}}</td>
                                <td>{{$persona->personaDirecta->zona->representante_zonal_nombre}} / {{$persona->personaDirecta->representanteJefe->nombre}}</td>
                                <td>{{$persona->personaDirecta->zona->region->region.' / '.$persona->personaDirecta->zona->zona}}</td>
                                @if($persona->estado_nomina == 'pendiente')
                                    <td class="alert-warning">{{$persona->estado_nomina}}</td>
                                @elseif ($persona->estado_nomina == 'rechazado')
                                    <td class="alert-danger">{{$persona->estado_nomina}}</td>
                                @else
                                    <td class="alert-success">{{$persona->estado_nomina}}</td>
                                @endif
                                <td>
                                    <a href="{{URL::action('PersonaDirectaController@edit', $persona->personaDirecta)}}">
                                        <button class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Datos del Asesor"><i class="fa fa-pencil"></i></button>
                                    </a>

                                    <a href="{{URL::action('NominaDirectaController@agregarConsideraciones',$persona)}}">
                                        <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="Agregar Consideración"><i class="fa fa-comment"></i></button>
                                    </a>
                                    @if($persona->estado_nomina == 'rechazado')
                                        <a href="{{URL::action('NominaDirectaController@edit', $persona)}}">
                                            <button class="btn btn-adn btn-xs" data-toggle="tooltip" data-placement="top" title="Regularizar asesor"><i class="fa fa-wrench"></i></button>
                                        </a>
                                    @endif
                                    <a href="" data-target="#modal-nomina-delete-{{$persona->id_persona_directa}}" data-toggle="modal" data-placement="top" title="inactivar" ><button class="btn-xs btn-danger"><i class="fa fa-user-times" aria-hidden="true"></i></button></a>
                                </td>
                            @endif
                        </tr>
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
