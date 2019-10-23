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

    @include('consideraciones_directa.search_aprobacion')

    {!!Form::model ($mes, ['method'=>'PATCH', 'route'=>['consideraciones_directa_aprobacion.aprobacion', $mes]])!!}
    {{Form::token()}}

    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_persona">
                    <thead class="text-center" style="background-color: #8eb4cb">
                    <th>id</th>
                    <th>CH</th>
                    <th>Representante</th>
                    <th>Zona</th>
                    <th>Rep Zonal / jefe</th>
                    <th>Consideración</th>
                    <th>Detalles</th>
                    <th>Regularización</th>
                    <th>Aprobar</th>
                    <th>Comentarios</th>
                    <th>Rechazo</th>
                    <th>Enviar</th>

                    </thead>
                    <tbody id="ajuste">
                    @foreach ($personas_consideracion as $persona)
                        <tr class="text-uppercase">
                            @if (auth()->user()->hasRoles(['tigo_people']))
                                @if(auth()->user()->zonas->contains($persona->personaDirecta->id_zona))
                                    <td>{{$persona->id_nomina}}</td>
                                    <td >{{$persona->personaDirecta->ch}}<input type="hidden" name="id_nomina[]" value="{{$persona->id_nomina}}"></td>
                                    <td>{{$persona->personaDirecta->nombre}}</td>
                                    <td>{{$persona->personaDirecta->zona->zona}}</td>
                                    <td>{{$persona->personaDirecta->zona->representante_zonal_nombre}} / {{$persona->personaDirecta->representanteJefe->nombre}}</td>
                                    <td>{{$persona->consideracion ? $persona->consideracion->nombre : ''}}</td>
                                    <td>{{$persona->detalles_consideracion}}</td>
                                    <td>{{$persona->regularizacion_consideracion}}</td>
                                    <td id="tdaprobacion">
                                        <select name="aprobacion[]" class="form-control aprobacion" id="aprobacion-{{$persona->id_nomina}}">
                                            <option value="aprobado" >aprobado</option>
                                            <option value="rechazado">rechazado</option>
                                            <option value="pendiente" selected>pendiente</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control text-uppercase" style="display:none;" name="comentario_consideracion[]" id="comentario_cosideracion-{{$persona->id_nomina}}"><input type="hidden" ></td>
                                    <td><input type="text" class="form-control text-uppercase" style="display:none;" name="motivo_rechazo[]" id="motivo_rechazo-{{$persona->id_nomina}}"><input type="hidden" ></td>
                                    <td class="text-center">
                                        <input name="_token" value="{{csrf_token()}}" type="hidden">
                                        <button class="btn btn-success btn-xs" type="submit" id="btn_enviar"><i class="fa fa-send-o"></i></button>
                                    </td>
                                @endif
                            @elseif(auth()->user()->hasRoles(['tigo_people_admin']))
                                <td>{{$persona->id_nomina}}</td>
                                <td >{{$persona->personaDirecta->ch}}<input type="hidden" name="id_nomina[]" value="{{$persona->id_nomina}}"></td>
                                <td>{{$persona->personaDirecta->nombre}}</td>
                                <td>{{$persona->personaDirecta->zona->zona}}</td>
                                <td>{{$persona->personaDirecta->zona->representante_zonal_nombre}} / {{$persona->personaDirecta->representanteJefe->nombre}}</td>

                                <td>{{$persona->consideracion ? $persona->consideracion->nombre : ''}}</td>
                                <td>{{$persona->detalles_consideracion}}</td>
                                <td>{{$persona->regularizacion_consideracion}}</td>
                                <td id="tdaprobacion">
                                    <select name="aprobacion[]" class="form-control aprobacion" id="aprobacion-{{$persona->id_nomina}}">
                                        <option value="aprobado" >aprobado</option>
                                        <option value="rechazado">rechazado</option>
                                        <option value="pendiente" selected>pendiente</option>
                                    </select>
                                </td>
                                <td><textarea rows="3" class="form-control text-uppercase" style="display:none;" name="comentario_consideracion[]" id="comentario_cosideracion-{{$persona->id_nomina}}"></textarea><input type="hidden" ></td>

                                <td><textarea rows="3"  class="form-control text-uppercase" style="display:none;" name="motivo_rechazo[]" id="motivo_rechazo-{{$persona->id_nomina}}"></textarea><input type="hidden" ></td>
                                <td class="text-center">
                                    <input name="_token" value="{{csrf_token()}}" type="hidden">


                                    @if($persona->archivos->where('tipo', '=', 'consideracion')->first())

                                     <a href="" data-target="#modal-delete-{{$persona->id_persona_directa}}" data-toggle="modal" data-placement="top" title="Archivo"><button class="btn btn-foursquare btn-xs"  id="btn_ver"><i class="fa fa-eye"></i></button></a>
                                    @endif
                                    <button class="btn btn-success btn-xs" type="submit" id="btn_enviar"><i class="fa fa-send-o"></i></button>
                                </td>

                            @endif
                        </tr>
                        @include('consideraciones_directa.archivo_modal')

                    @endforeach
                    </tbody>

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

                $('.aprobacion').change(function(){
                    var id = $(this).prop('id').split('-')[1];
                    if ($(this).val()=='rechazado')
                    {
                        $("#motivo_rechazo-"+id).show();
                        $("#comentario_cosideracion-"+id).hide();

                    }
                    else if ($(this).val()=='aprobado')
                    {
                        $("#motivo_rechazo-"+id).hide();
                        $("#comentario_cosideracion-"+id).show();
                    }
                    else
                    {
                        $("#motivo_rechazo-"+id).hide();
                        $("#comentario_cosideracion-"+id).hide();
                    }

                });

            })
        </script>
    @endpush

@endsection
