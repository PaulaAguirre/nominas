@extends ('layouts.admin_tienda')
@section ('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Team Leader: {{$teamleader->nombre}}  </h3>
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

    {!!Form::model ($teamleader, ['method'=>'PATCH', 'route'=>['teamleaders.update', $teamleader]])!!}
    {{Form::token()}}


        <div class="row">
            <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group col-lg-4">
                        <label for="name">CH</label>
                        <input type="number" name="ch"  value="{{$teamleader->ch}}" class="form-control text-uppercase">
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="name">Documento</label>
                        <input type="number" name="documento"  value="{{$teamleader->documento}}" class="form-control text-uppercase">
                    </div>

                    <div class="form-group col-lg-4">
                        <label> Asesor Experto <br>
                            @if($teamleader->asesor_experto == 'si')
                                <input type="checkbox" checked name="asesor_experto" value="si">
                            @else
                                <input type="checkbox"  name="asesor_experto" value="si">
                            @endif
                        </label>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="">TIPO</label>
                        <select name="tipo" id="tipo" class="selectpicker form-control text-uppercase tipo"  title="Seleccione clasificación" required>
                            @foreach($tipos as $tipo)
                                @if($tipo == $teamleader->rac_retencion)
                                    <option selected value="{{$tipo}}">{{$teamleader->rac_retencion}}</option>
                                @else
                                    <option  value="{{$tipo}}">{{$tipo}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group retencion_call col-lg-6" style="display: none" class="retencion_call" id="retencion_call">
                        <label for="">Clasificación</label>
                        <select name="clasificacion_call_id" id="clasificacion_call_id" class="selectpicker form-control text-uppercase " title="Seleccione clasificación">
                            @foreach($clasificaciones_call as $clasificacion)
                                @if($teamleader->clasificacion_id == $clasificacion->id)
                                    <option selected value="{{$clasificacion->id}}">{{$teamleader->clasificacion->nombre}}</option>
                                @else
                                    <option  value="{{$clasificacion->id}}">{{$clasificacion->nombre}}</option>
                                @endif

                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            </div>
        </div>

    <div class="row text-uppercase tiendas" id="tiendas" style="display: none">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_persona">
                    <thead class="text-center" style="background-color: #2ab27b">
                    <th>ID</th>
                    <th>Tienda</th>
                    <th>Agregar</th>
                    </thead>
                    @foreach ($tiendas as $tienda)
                        <tr class="text-uppercase">
                            <td>{{$tienda->id}}</td>
                            <td>{{$tienda->tienda_nombre}}</td>
                            @if($tienda->teamleaders->pluck('id')->contains($teamleader->id))
                                <td class="text-center"><input type="checkbox" checked value="{{$tienda->id}}" name="tienda_id[]"></td>
                            @else
                                <td class="text-center"><input type="checkbox" value="{{$tienda->id}}" name="tienda_id[]"></td>
                            @endif
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>
    <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12 text-center" id="guardar">
        <div class="form-group">
            <input name="_token" value="{{csrf_token()}}" type="hidden">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <button id="btn_cancelar" class="btn btn-danger" type="reset">Cancelar</button>
        </div>
    </div>


    @push('scripts')
        <script>

            $(document).ready(function () {
                if($('.tipo').val() == 'RAC RETENCION CALL' )
                {
                    $('#retencion_call').show();
                    $('#tiendas').hide();
                }
                else
                {
                    $('#tiendas').show();
                    $('#retencion_call').hide();
                }
            });

                $('.tipo').change(function ()
                {
                    if ($(this).val() == 'RAC RETENCION CALL')
                    {
                        $('#retencion_call').show();
                        $('#tiendas').hide();

                    }
                    else
                    {
                        $('#tiendas').show();
                        $('#retencion_call').hide();
                    }

                });





        </script>
    @endpush

@endsection
