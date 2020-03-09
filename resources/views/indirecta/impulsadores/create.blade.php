@extends ('layouts.admin_indirecta')
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
    <div class="row">
        {!!Form::open(array('url'=>'asesores_indirecta','method'=>'POST','autocomplete'=>'off'))!!}
        {{Form::token()}}
        <div class="panel panel-default col-lg-6">
            <div class="panel-heading text-bold"><span class="text-purple">NUEVO ASESOR</span></div>

            <div class="panel-body text-uppercase">


                <input type="hidden" name="url" value="{{URL::previous ()}}">

                <div class="form-group col-md-3">
                    <div class="">
                        <label for="name">CH</label>
                        <input type="number" name="ch" required value="{{old('ch')}}" class="form-control text-uppercase">
                    </div>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="name">Fecha ingreso</label>
                    <div class="input-group">
                        <input type="text" class="form-control datepicker" name="fecha_ingreso">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </div>
                    </div>
                </div>


                <div class="form-group col-md-3">
                    <div class="">
                        <label for="name">Documento</label>
                        <input type="text" name="documento" required value="{{old('documento')}}" class="form-control text-uppercase">
                    </div>
                </div>


                <div class="form-group col-md-3">
                    <div class="">
                        <label for="name">Staff</label>
                        <input type="number" name="staff"  value="{{old('staff')}}" class="form-control">
                    </div>
                </div>



                <div class="form-group col-md-6">
                    <label>Asesor</label>
                    <input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control text-uppercase" placeholder="APELLIDOS, NOMBRES">
                </div>


                <div class="form-group col-md-6">
                    <label for="">Coordinador</label>
                    <select name="coordinador_zona" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione Coordinador">
                        @foreach($coordinadores as $coordinador )
                            @foreach($coordinador->zonas as $zona)
                                <option  value="{{$coordinador->id.'-'.$zona->id}}">{{$coordinador->nombre.' - '.$zona->nombre}}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-offset-0 col-md-4">
                    <label for="">Clasificación</label>
                    <select name="clasificacion_id" class="selectpicker form-control text-uppercase " data-live-search="true" title="seleccione clasificacion" required>
                        @foreach($clasificaciones as $clasificacion)
                            <option  value="{{$clasificacion->id}}">{{$clasificacion->nombre}}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group col-md-4">
                    <label for="">consideración</label>
                    <select name="consideracion_id" class="selectpicker form-control text-uppercase " data-live-search="true" title="Consideracion" required>
                        <option  value="6">Nuevo Ingreso</option>
                        <option value="12">Cambio de canal</option>
                    </select>
                </div>

                <div class="form-group col-md-4 ">
                    <label for="" class="col-md-3">Observaciones</label>
                    <textarea class="form-control" rows="2" name="detalles_consideracion"></textarea>
                </div>
            </div>
        </div>
        <div class="panel panel-default col-lg-6">
                <div class="panel-heading text-bold"><span class="text-purple">PDV - Circuito</span></div>
                <div class="panel-body text-uppercase">
                    <div class="form-group form-inline">
                        <select id="ppdv_id" class="selectpicker form-control text-uppercase col-md-offset-1 col-lg-4" data-live-search="true" title="Seleccione PDV">
                            @foreach($pdvs as $pdv )
                                <option  value="{{$pdv->id}}">{{'ID PDV'}}: {{$pdv->codigo}} -{{'Circuito'}}: {{$pdv->circuito ? $pdv->circuito->codigo : ''}} - {{$pdv->circuito ? $pdv->circuito->zona->nombre : ''}}</option>
                            @endforeach
                        </select>
                        <button type="button" id="bt_add" class="btn btn-default text-gray col-md-offset-2" style="background-color: #5d59a6">Agregar</button>
                    </div>

                    <div class="col-lg-6">
                        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                            <thead style="background-color: #5d59a6" class="text-gray">
                            <th>OPC</th>
                            <th>PDV</th>
                            <th>Circuito</th>
                            </thead>
                            <tbody class="text-uppercase">

                            </tbody>
                        </table>

                    </div>
                </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="guardar">
                <div class="form-group">
                    <input name="_token" value="{{csrf_token()}}" type="hidden">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <button class="btn btn-danger" type="reset">Cancelar</button>
                </div>
            </div>
        </div>

        {!!Form::close()!!}
    </div>



    @push('scripts')
        <script>

            $(document).ready(function(){
                $('.datepicker').datepicker({
                    format: "dd/mm/yyyy",
                    language: "es",
                    autoclose: true
                });

                $('#bt_add').click(function () {
                    agregar();
                    limpiar()
                });
            })
            var cont = 0;
            $("#guardar").hide();

            function agregar() {
                idpdv = $("#ppdv_id").val();
                pdv = ($("#ppdv_id").text().split('-')[0]).split(':')[1];
                circuito = ($("#ppdv_id").text().split('-')[1]).split(':')[1];

                if(idpdv!="")
                {
                    var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning text-center btn-xs" onclick="eliminar('+cont+');">x</buton></td><td><input name="idpdv[]" value="'+idpdv+'">'+pdv+'</td><td><input name="circuito[]" value="'+circuito+'">'+circuito+'</td></tr>'
                    cont++;
                    $("#detalles").append(fila);
                    $("#guardar").show();
                }
                else {
                    $("#guardar").hide();
                    alert("Error al ingresar un registro");
                }

            }

            function eliminar(index) {
                $("#fila"+index).remove();
            }


        </script>
    @endpush
@endsection
