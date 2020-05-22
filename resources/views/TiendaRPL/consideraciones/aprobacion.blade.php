@extends ('layouts.admin_tienda')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <h3>Aprobar Consideraciones - <span class="text-success">Mes: {{$mes_nomina}}</span> </h3>
            @if (count($errors)>0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @include('TiendaRPL.consideraciones.search_aprobacion')
        </div>
    </div>

    {!!Form::model ($mes_nomina, ['method'=>'PATCH', 'route'=>['consideraciones_tienda_aprobacion.aprobacion_rpl']])!!}
    {{Form::token()}}

    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_asesor">
                    <thead class="text-center text-sm" style="background-color: #2ab27b" >
                    <th>id</th>
                    <th>CH</th>
                    <th>Nombre</th>
                    <th>Rep Zonal</th>
                    <th>Consideración</th>
                    <th>Detalles</th>
                    <th>Regularizar</th>
                    <th>Aprobar</th>
                    <th class="col-lg-1" >Porc%</th>
                    <th>Comentarios</th>
                    <th>Rechazado</th>
                    <th>Opc</th>

                    </thead>
                    <tbody id="ajuste">
                    @foreach ($asesores as $asesor)
                        <tr class="text-uppercase text-sm">

                                <td>{{$asesor->id}}</td>
                                <td >{{$asesor->asesor->ch}}<input type="hidden" name="id_nomina[]" value="{{$asesor->id}}"></td>
                                <td>{{$asesor->asesor->nombre}}</td>
                                <td>{{$asesor->asesor->tienda->zona->zona.' / '.$asesor->asesor->tienda->zona->representante_zonal_nombre}}</td>
                                <td>{{$asesor->consideracion ? $asesor->consideracion->nombre : ''}}</td>
                                <td>{{$asesor->detalles_consideracion}}</td>
                                <td>{{$asesor->regularizacion_consideracion}}</td>
                                <td id="tdaprobacion">
                                    <select name="aprobacion[]" class="form-control aprobacion selectpicker text-sm" id="aprobacion-{{$asesor->id}}">
                                        <option value="aprobado" >aprobado</option>
                                        <option value="rechazado">rechazado</option>
                                        <option value="pendiente" selected>pendiente</option>
                                    </select>
                                </td>
                                <td id="td_objetivo">
                                    <select name="objetivo[]" class="form-control text-uppercase text-sm" style="display:none;"  id="objetivo-{{$asesor->id}}">
                                        <option value="100%">100%</option>
                                        <option value="75% nuevo">75% nuevo</option>
                                        <option value="75%">75%</option>
                                        <option value="50%">50%</option>
                                        <option value="prorrateado">prorrateado%</option>
                                        <option value="25%">25%</option>
                                        <option value="sin objetivos">Sin objetivos</option>
                                        </select>
                                </td>
                                <td><textarea rows="3" class="form-control text-uppercase text-sm" style="display:none;" name="comentario_consideracion[]" id="comentario_cosideracion-{{$asesor->id}}"></textarea><input type="hidden" ></td>

                                <td><textarea rows="3"  class="form-control text-uppercase text-sm" style="display:none;" name="motivo_rechazo[]" id="motivo_rechazo-{{$asesor->id}}"></textarea><input type="hidden" ></td>
                                <td class="text-center">
                                    <input name="_token" value="{{csrf_token()}}" type="hidden">
                                    @if($asesor->archivos->where('tipo', '=', 'consideracion')->first())
                                     <a href="" data-target="#modal-delete-{{$asesor->id}}" data-toggle="modal" data-placement="top" title="Archivo"><button class="btn btn-foursquare btn-xs"  id="btn_ver"><i class="fa fa-eye"></i></button></a>
                                    @endif
                                    <button class="btn btn-success btn-xs" type="submit" id="btn_enviar"><i class="fa fa-send-o"></i></button>
                                </td>
                        </tr>
                        @include('TiendaRPL.consideraciones.archivo_modal')
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

                var nfilas = $("#tabla_asesor tr").length -1;

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
                        $("#objetivo-"+id).hide();

                    }
                    else if ($(this).val()=='aprobado')
                    {
                        $("#motivo_rechazo-"+id).hide();
                        $("#comentario_cosideracion-"+id).show();
                        $("#objetivo-"+id).show();
                    }
                    else
                    {
                        $("#motivo_rechazo-"+id).hide();
                        $("#comentario_cosideracion-"+id).hide();
                        $("#objetivo-"+id).hide();
                    }

                });

            })
        </script>
    @endpush

@endsection
