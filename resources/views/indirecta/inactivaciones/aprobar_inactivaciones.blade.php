@extends ('layouts.admin_indirecta')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <h3>Aprobar Inactivaciones - <span class="text-info">Mes: {{$mes}}</span> </h3>
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
    {!!Form::model ($mes, ['method'=>'PATCH', 'route'=>['nomina_indirecta.inactivacion_store']])!!}
    {{Form::token()}}

    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_impulsador">
                    <thead class="text-center text-gray text-sm" style="background-color: #5d59a6">
                    <th>Mes</th>
                    <th>ID</th>
                    <th>CH</th>
                    <th>Representante</th>
                    <th>Zona</th>
                    <th>Motivo</th>
                    <th>Detalles</th>
                    <th>Regularización</th>
                    <th>Aprobar</th>
                    <th class="col-lg-1">PORC%</th>
                    <th>Comentarios</th>
                    <th>Rechazo</th>
                    <th>Opc</th>
                    </thead>
                    <tbody id="ajuste">
                    @foreach ($impulsadores as $impulsador)
                        <tr class="text-uppercase text-sm">
                            <td>{{$impulsador->mes}}</td>
                            <td>{{$impulsador->id}}</td>
                            <td>{{$impulsador->impulsador->ch}}<input type="hidden" name="id_nomina[]" value="{{$impulsador->id}}"></td>
                            <td>{{$impulsador->impulsador->nombre}}</td>
                            <td>{{$impulsador->impulsador->zona->nombre.' / '.$impulsador->impulsador->zona->representante_zonal_nombre}}</td>
                            <td>{{$impulsador->motivo_inactivacion}}</td>
                            <td>{{$impulsador->detalles_inactivacion}}</td>
                            <td>{{$impulsador->regularizacion_inactivacion}}</td>
                            <td id="tdaprobacion">
                                <select name="aprobacion[]" class="form-control aprobacion text-sm" id="aprobacion-{{$impulsador->id}}">
                                    <option value="aprobado" >aprobado</option>
                                    <option value="rechazado">rechazado</option>
                                    <option value="pendiente" selected>pendiente</option>
                                </select>
                            </td>
                            <td id="td_objetivo">
                                <select class="form-control aprobacion text-sm" style="display:none;" name="objetivo[]" id="objetivo-{{$impulsador->id}}">
                                    <option value="100%">100%</option>
                                    <option value="75% nuevo">75% nuevo</option>
                                    <option value="75%">75%</option>
                                    <option value="50%">50%</option>
                                    <option value="prorrateado">prorrateado%</option>
                                    <option value="25%">25%</option>
                                    <option value="sin objetivos">Sin objetivos</option>
                                </select>
                            </td>
                            <td><textarea rows="3" class="form-control text-uppercase text-sm" style="display: none;" name="comentario_inactivacion[]" id="comentario_inactivacion-{{$impulsador->id}}"></textarea></td>
                            <td><textarea rows="3" class="form-control text-uppercase text-sm" style="display:none;" name="motivo_rechazo[]" id="motivo_rechazo-{{$impulsador->id}}"></textarea><input type="hidden" ></td>
                            <td class="text-center">
                                <input name="_token" value="{{csrf_token()}}" type="hidden">
                                @if($impulsador->archivos->where('tipo', '=', 'inactivacion')->first())
                                    <a href="" data-target="#modal-delete-{{$impulsador->id}}" data-toggle="modal" data-placement="top" title="Archivo"><button class="btn btn-foursquare btn-xs"  id="btn_ver"><i class="fa fa-eye"></i></button></a>
                                @endif
                                    <button class="btn btn-success btn-xs" type="submit" id="btn_enviar"><i class="fa fa-send-o"></i></button>
                            </td>
                        </tr>
                        @include('indirecta.inactivaciones.archivo_modal_inactivacion')
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

                var nfilas = $("#tabla_impulsador tr").length -1;

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
                        $("#comentario_inactivacion-"+id).hide();
                        $("#objetivo-"+id).hide();
                    }else if ($(this).val()=='aprobado')
                    {
                        $("#comentario_inactivacion-"+id).show();
                        $("#motivo_rechazo-"+id).hide();
                        $("#objetivo-"+id).show();
                    }
                    else {
                        $("#comentario_inactivacion-"+id).hide();
                        $("#motivo_rechazo-"+id).hide();

                    }
                });

            })
        </script>
    @endpush

@endsection

