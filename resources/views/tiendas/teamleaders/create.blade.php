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
            <div class="col-lg-4 col-lg-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading text-bold"><span class="text-green">NUEVO Team Leader</span></div>

                    <div class="panel-body text-uppercase">
                        {!!Form::open(array('url'=>'teamleaders','method'=>'POST','autocomplete'=>'off'))!!}
                        {{Form::token()}}

                        <input type="hidden" name="url" value="{{URL::previous ()}}">

                        <div class="form-group col-md-6">
                            <label for="name">CH</label>
                            <input type="number" name="ch"  value="{{old('ch')}}" class="form-control text-uppercase">
                        </div>


                        <div class="form-group col-md-6">
                            <div class="">
                                <label for="name">Documento</label>
                                <input type="number" name="documento" value="{{old('documento')}}" class="form-control text-uppercase">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control text-uppercase" placeholder="APELLIDOS, NOMBRES">
                        </div>

                        <div class="form-group">
                            <label> Asesor Experto
                                <input type="checkbox" name="asesor_experto" value="si">
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="">TIPO</label>
                            <select name="tipo" id="tipo" class="selectpicker form-control text-uppercase tipo" title="Seleccione clasificación" required>
                                @foreach($tipos as $tipo)
                                    <option value="{{$tipo}}">{{$tipo}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group retencion_call" style="display: none" class="retencion_call" id="retencion_call">
                            <label for="">Clasificación</label>
                            <select name="clasificacion_call_id" id="clasificacion_call_id" class="selectpicker form-control text-uppercase " title="Seleccione clasificación">
                                @foreach($clasificaciones_call as $clasificacion)
                                    <option value="{{$clasificacion->id}}">{{$clasificacion->nombre}}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group text-center">
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

        @push('scripts')
            <script>
                $('.tipo').change(function ()
                {
                   if ($(this).val() == 'RAC RETENCION CALL')
                   {
                        $('#retencion_call').show();
                   }
                   else
                   {
                       $('#retencion_call').hide();
                   }

                });

            </script>
        @endpush
    </div>


    @push('scripts')
        <script>

            $(document).ready(function () {
                $('.datepicker').datepicker({
                    format: "dd/mm/yyyy",
                    language: "es",
                    autoclose: true
                });
            })
        </script>
    @endpush
@endsection
