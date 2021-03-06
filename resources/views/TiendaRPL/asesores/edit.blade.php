@extends ('layouts.admin_tienda')
@section ('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading text-bold"><span class="text-green">Editar Asesor</span></div>

                    <div class="panel-body text-uppercase">
                        {!!Form::model ($asesor, ['method'=>'PATCH', 'route'=>['asesores_tienda_rpl.update', $asesor]])!!}
                        {{Form::token()}}

                        <input type="hidden" name="url" value="{{URL::previous ()}}">
                        <div class="form-group">
                            <div class="col-md-3">
                                <label for="name">CH</label>
                                <input type="number" name="ch" required value="{{$asesor->ch}}" class="form-control text-uppercase">
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="name">Fecha ingreso</label>
                            <div class="input-group">
                                <input type="text" value="{{$asesor->fecha_ingreso}}" class="form-control text-uppercase" disabled="disabled">
                            </div>
                        </div>


                        <div class="form-group col-md-3">
                            <div class="">
                                <label for="name">Documento</label>
                                <input type="text" name="documento" required value="{{$asesor->documento}}" class="form-control text-uppercase">
                            </div>
                        </div>


                        <div class="form-group col-md-3">
                            <div class="">
                                <label for="name">Staff</label>
                                <input type="number" name="staff"  value="{{$asesor->staff}}" class="form-control">
                            </div>
                        </div>



                        <div class="form-group col-md-6">
                            <label>Asesor</label>
                            <input type="text" name="nombre" required value="{{$asesor->nombre}}" class="form-control text-uppercase" placeholder="APELLIDOS, NOMBRES">
                        </div>

                        <div class="form-group col-md-3">
                            <div class="">
                                <label for="name">user</label>
                                <input type="text" name="user_red"  value="{{$asesor->user_red}}" class="form-control">
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">Cargo GO</label>
                            <select name="cargo_go" class="selectpicker form-control text-uppercase " data-live-search="true" title="Cargo" required>
                                @foreach($cargos as $cargo)
                                    @if($cargo == $asesor->cargo_go)
                                        <option selected  value="{{$cargo}}">{{$cargo}}</option>
                                    @else
                                        <option value="{{$cargo}}">{{$cargo}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">Agrupación</label>
                            <select name="agrupacion" class="selectpicker form-control text-uppercase agrupacion" id="agrupacion" data-live-search="true" title="agrupacion" required>
                                @foreach($agrupaciones as $agrupacion)
                                    @if($asesor->agrupacion == $agrupacion)
                                        <option selected value="{{$agrupacion}}">{{$agrupacion}}</option>
                                    @else
                                        <option  value="{{$agrupacion}}">{{$agrupacion}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div id="asesor" style="display: none" class="asesor">
                            <div class="form-group col-md-4">
                                <label for="">Team Leader</label>
                                <select name="tienda_teamleader_id" class="selectpicker form-control text-uppercase " data-size="8" data-live-search="true" title="Team Leader">
                                    @foreach($tiendas as $tienda )
                                        @foreach($tienda->teamleaders as $teamleader)
                                            @if($asesor->id_teamleader == $teamleader->id)
                                                <option selected value="{{$tienda->id}}-{{$teamleader->id}}">{{$tienda->tienda_nombre}} - {{$teamleader->nombre}}</option>
                                            @else
                                                <option value="{{$tienda->id}}-{{$teamleader->id}}">{{$tienda->tienda_nombre}} - {{$teamleader->nombre}}</option>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">Supervisor</label>
                                <select name="supervisor_id" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione Supervisor">
                                    @foreach($supervisores as $supervisor)
                                        @if($asesor->supervisor_guiatigo_id == $supervisor->id)
                                            <option selected value="{{$supervisor->id}}">{{$supervisor->nombre}}</option>
                                        @else
                                            <option  value="{{$supervisor->id}}">{{$supervisor->nombre}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="retencion_call" style="display: none" class="retencion_call">
                            <div class="form-group col-md-4">
                                <label for="">RAC Leader</label>
                                <select name="tl_retencion_call" class="selectpicker form-control text-uppercase " data-live-search="true" title="RAC">
                                    @foreach($tls_retencion_call as $tl )
                                        @if($asesor->tl_retencion_call_id == $tl->id)
                                            <option selected value="{{$tl->id}}">{{$tl->nombre.' - '.$tl->clasificacionRetencion->nombre}}</option>
                                        @else
                                            <option  value="{{$tl->id}}">{{$tl->nombre.' - '.$tl->clasificacionRetencion->nombre}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="retencion_tiendas" style="display: none" class="retencion_tiendas">
                            <div class="form-group col-md-4">
                                <label for="">RAC Leader</label>
                                <select name="tls_retencion_tiendas" class="selectpicker form-control text-uppercase"
                                        data-size="8" data-live-search="true" title="RAC Leader">
                                    @foreach($tls_retencion_tiendas as $tl )
                                        @foreach($tl->tiendas as $tienda)
                                            @if($asesor->id_tienda == $tienda->id)
                                                <option selected value="{{$tl->id}}-{{$tienda->id}}">{{$tienda->tienda_nombre}} - {{$tl->nombre}}</option>
                                            @else
                                                <option  value="{{$tl->id}}-{{$tienda->id}}">{{$tienda->tienda_nombre}} - {{$tl->nombre}}</option>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group text-center col-md-offset-2 col-md-6">
                            <br>
                            <input name="_token" value="{{csrf_token()}}" type="hidden">
                            <button class="btn btn-primary" type="submit">Guardar</button>
                            <button class="btn btn-danger" type="reset">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!!Form::close()!!}
    </div>


    @push('scripts')
        <script>

            $(document).ready(function () {
                $('.datepicker').datepicker({
                    format: "dd/mm/yyyy",
                    language: "es",
                    autoclose: true
                });

                if($('.agrupacion').val() == 'RETENCION CALL')
                {
                    $('#asesor').hide();
                    $('#retencion_call').show();
                    $('#retencion_tiendas').hide();;
                }
                else if($('.agrupacion').val() == 'ASESOR')
                {
                    $('#asesor').show();
                    $('#retencion_call').hide();
                    $('#retencion_tiendas').hide();
                }
                else if($('.agrupacion').val() == 'RETENCION TIENDA')
                {
                    $('#asesor').hide();
                    $('#retencion_call').hide();
                    $('#retencion_tiendas').show();
                }
            })



            $('.agrupacion').change(function ()
            {
                if($(this).val() == 'ASESOR')
                {
                    $('#asesor').show();
                    $('#retencion_call').hide();
                    $('#retencion_tiendas').hide();
                }
                else if ($(this).val() == 'RETENCION CALL')
                {
                    $('#asesor').hide();
                    $('#retencion_call').show();
                    $('#retencion_tiendas').hide();

                }
                else if ($(this).val() == 'RETENCION TIENDA')
                {
                    $('#asesor').hide();
                    $('#retencion_call').hide();
                    $('#retencion_tiendas').show();
                }

            });
        </script>
    @endpush
@endsection
