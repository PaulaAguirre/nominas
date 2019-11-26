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
                    <div class="panel-heading text-bold"><span class="text-green">Editar tienda</span></div>

                    <div class="panel-body text-uppercase">
                        {!!Form::model ($tienda, ['method'=>'PATCH', 'route'=>['tiendas.update', $tienda]])!!}
                        {{Form::token()}}

                        <input type="hidden" name="url" value="{{URL::previous ()}}">
                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="name">Nombre Tienda</label>
                                <input name="tienda_nombre" type="text" value="{{$tienda->tienda_nombre}}" class="form-control text-uppercase">
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="name">clasificacion</label>
                            <select name="clasificacion" class="selectpicker form-control text-uppercase " data-live-search="true" title="Clasificación">
                                @foreach($clasificaciones as $clasificacion)
                                    @if($tienda->clasificacion == $clasificacion)
                                        <option selected value="{{$clasificacion}}">{{$clasificacion}}</option>
                                    @else
                                        <option value="{{$clasificacion}}">{{$clasificacion}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group col-md-4">
                            <div class="">
                                <label for="name">Zona Tienda</label>
                                <input type="text" name="zona_tienda" required value="{{$tienda->zona_tienda}}" class="form-control text-uppercase">
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="name">Jefe Tienda</label>
                            <select name="jefe_tienda_id" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione Jefe">
                                @foreach($jefes_tienda as $jefe)
                                    @if($tienda->jefe_tienda_id == $jefe->id)
                                        <option selected value="{{$jefe->id}}">{{$jefe->nombre}}</option>
                                    @else
                                        <option value="{{$jefe->id}}">{{$jefe->nombre}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="name">Zona</label>
                            <select name="zona_id" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione zona">
                                @foreach($zonas as $zona)
                                    @if($tienda->zona_id == $zona->id)
                                        <option selected value="{{$zona->id}}">{{$zona->zona}}</option>
                                    @else
                                        <option value="{{$zona->id}}">{{$zona->zona}} - {{$zona->representante_zonal_nombre}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="name">Tipo Tienda</label>
                            <select name="tipo_tienda" class="selectpicker form-control text-uppercase " data-live-search="true" title="Tipo Tienda">
                                @foreach($tipos_tienda as $tipo)
                                    @if($tienda->tipo_tienda == $tipo)
                                        <option selected value="{{$tipo}}">Tipo: {{$tipo}}</option>
                                    @else
                                        <option  value="{{$tipo}}">Tipo: {{$tipo}}</option>
                                    @endif
                                @endforeach
                            </select>
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
            })
        </script>
    @endpush
@endsection
