@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <h3>Aprobar Consideraciones - <span class="text-info">Mes: {{$mes}}</span> </h3>
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
    <br>
    {!!Form::model ($mes, ['method'=>'PATCH', 'route'=>['consideraciones_directa_aprobacion.aprobacion', $mes]])!!}
    {{Form::token()}}

    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_persona">
                    <thead class="text-center" style="background-color: #8eb4cb">
                    <th>CH</th>
                    <th>Representante</th>
                    <th>Zona</th>
                    <th>Motivo</th>
                    <th>Detalles</th>
                    <th>Regularización</th>
                    <th>Aprobar</th>
                    <th>Motivo</th>
                    <th>Enviar</th>
                    </thead>
                    @foreach ($personas_consideracion as $persona)
                        <tr class="text-uppercase">
                            @if (auth()->user()->hasRoles(['tigo_people']))
                                @if(auth()->user()->zonas->contains($persona->personaDirecta->id_zona))
                                    <td >{{$persona->personaDirecta->ch}}<input type="hidden" name="id_nomina[]" value="{{$persona->id_nomina}}"></td>
                                    <td>{{$persona->personaDirecta->nombre}}</td>
                                    <td>{{$persona->personaDirecta->zona->zona}}</td>
                                    <td>{{$persona->consideracion->nombre}}</td>
                                    <td>{{$persona->detalles_consideracion}}</td>
                                    <td>{{$persona->regularizacion_consideracion}}</td>
                                    <td>
                                        <select name="aprobacion[]" class="form-control" id="">
                                            <option value="aprobado" >aprobado</option>
                                            <option value="rechazado">rechazado</option>
                                            <option value="pendiente" selected>pendiente</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control text-uppercase" name="motivo_rechazo[]" id="motivo_rechazo"><input type="hidden" ></td>
                                    <td class="text-center">
                                        <input name="_token" value="{{csrf_token()}}" type="hidden">
                                        <button class="btn btn-success btn-xs" type="submit" id="btn_enviar"><i class="fa fa-send-o"></i></button>
                                    </td>
                                @endif
                             @elseif(auth()->user()->hasRoles(['tigo_people_admin']))
                                <td >{{$persona->personaDirecta->ch}}<input type="hidden" name="id_nomina[]" value="{{$persona->id_nomina}}"></td>
                                <td>{{$persona->personaDirecta->nombre}}</td>
                                <td>{{$persona->personaDirecta->zona->zona}}</td>
                                <td>{{$persona->consideracion->nombre}}</td>
                                <td>{{$persona->detalles_consideracion}}</td>
                                <td>{{$persona->regularizacion_consideracion}}</td>
                                <td>
                                    <select name="aprobacion[]" class="form-control" id="">
                                        <option value="aprobado" >aprobado</option>
                                        <option value="rechazado">rechazado</option>
                                        <option value="pendiente" selected>pendiente</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control text-uppercase" name="motivo_rechazo[]" id="motivo_rechazo"><input type="hidden" ></td>
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

                var nfilas = $("#tabla_persona tr").length -1;

                if ( nfilas > 0)
                {
                    $("#btn_enviar").show();
                    $("#btn_cancelar").show();
                }

            })
        </script>
    @endpush

@endsection
