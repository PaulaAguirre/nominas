@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <h3>Aprobar Cambio de Estructura - <span class="text-info">Mes: {{$mes}} </span> </h3>
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

    {!!Form::model ($mes, ['method'=>'PATCH', 'route'=>['representantes_directa.aprobarCambioEstructuraStore', $mes]])!!}
    {{Form::token()}}
    <br>
    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_persona">
                    <thead class="text-center text-sm" style="background-color: #8eb4cb">
                    <th>ID</th>
                    <th>CH</th>
                    <th>Representante</th>
                    <th>Zona Actual</th>
                    <th>Zona Nueva</th>
                    <th>Jefe Actual</th>
                    <th>Jefe Nuevo</th>
                    <th>Regularización</th>
                    <th class="">Aprobar</th>
                    <th class="">Motivo Rechazo</th>
                    <th>Enviar</th>


                    </thead>
                    @foreach ($personas as $persona)
                        <tr class="text-uppercase text-sm" id="td_personas">
                            @if (auth()->user()->hasRoles(['tigo_people']))
                                @if(auth()->user()->zonas->contains($persona->id_zona))
                                    <td>{{$persona->id_persona}}</td>
                                    <td >{{$persona->ch}}<input type="hidden" name="id_persona[]" value="{{$persona->id_persona}}"></td>
                                    <td>{{$persona->nombre}}</td>
                                    <td>{{$persona->zona->zona}}</td>
                                    <td>{{$persona->zona_nuevo->zona}}</td>
                                    <td>{{$persona->representanteJefe->nombre}}</td>
                                    <td>{{$persona->representanteJefeNuevo->nombre}}</td>
                                    @if($persona->regularizacion_cambio)
                                        <td class="text-danger">{{$persona->regularizacion_cambio}}</td>
                                    @else
                                        <td class="">{{$persona->regularizacion_cambio}}</td>
                                    @endif
                                    <td>
                                        <select name="aprobacion[]" class="form-control text-sm " id="aprobacion">
                                            <option value="aprobado" class="text-sm" >aprobado</option>
                                            <option value="rechazado" class="text-sm">rechazado</option>
                                            <option value="pendiente" class="text-sm" selected>pendiente</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control text-uppercase" name="motivo_rechazo[]"><input type="hidden" ></td>
                                    <td class="text-center">
                                        <input name="_token" value="{{csrf_token()}}" type="hidden">
                                        <button class="btn btn-success btn-xs" type="submit" id="btn_enviar"><i class="fa fa-send-o"></i></button>
                                    </td>

                                @endif
                            @elseif(auth()->user()->hasRoles(['tigo_people_admin']))
                            <td>{{$persona->id_persona}}</td>
                            <td >{{$persona->ch}}<input type="hidden" name="id_persona[]" value="{{$persona->id_persona}}"></td>
                            <td>{{$persona->nombre}}</td>
                            <td>{{$persona->zona->zona}}</td>
                            <td>{{$persona->zona_nuevo->zona}}</td>
                            <td>{{$persona->representanteJefe->nombre}}</td>
                            <td>{{$persona->representanteJefeNuevo->nombre}}</td>
                            @if($persona->regularizacion_cambio)
                                <td class="text-danger">{{$persona->regularizacion_cambio}}</td>
                            @else
                                <td class="">{{$persona->regularizacion_cambio}}</td>
                            @endif
                            <td>
                                <select name="aprobacion[]" class="form-control text-sm " id="aprobacion">
                                    <option value="aprobado" class="text-sm" >aprobado</option>
                                    <option value="rechazado" class="text-sm">rechazado</option>
                                    <option value="pendiente" class="text-sm" selected>pendiente</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control text-uppercase" name="motivo_rechazo[]"><input type="hidden" ></td>
                            <td class="text-center">
                                <input name="_token" value="{{csrf_token()}}" type="hidden">
                                <button class="btn btn-success btn-xs" type="submit" id="btn_enviar"><i class="fa fa-send-o"></i></button>

                            </td>
                            @endif
                        </tr>
                    @endforeach
                </table>
                <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12 text-center" id="guardar">
                    <div class="form-group">
                        <input name="_token" value="{{csrf_token()}}" type="hidden">
                        <button class="btn btn-success " type="submit" id="btn_enviar">Enviar <i class="fa fa-send-o"></i></button>
                        <span class=""><button class="btn btn-danger " id="btn_cancelar" type="reset" >Cancelar</button></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!!Form::close()!!}

    @push('scripts')
        <script>
            $(document).ready(function () {
                $("#btn_enviar").hide();
                $("#btn_cancelar").hide();

                var cont  = 0;
                var nfilas = $("#tabla_persona tr").length -1;

                if ( nfilas > 0)
                {
                    $("#btn_enviar").show();
                    $("#btn_cancelar").show();
                }

                if ($("#aprobacion").val() != '')
                {
                    //
                }


            })
        </script>
    @endpush

@endsection



