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
                    <div class="panel-heading text-bold"><span class="text-green">NUEVO ASESOR</span></div>

                    <div class="panel-body text-uppercase">
                        {!!Form::open(array('url'=>'asesores_tienda','method'=>'POST','autocomplete'=>'off'))!!}
                        {{Form::token()}}

                        <input type="hidden" name="url" value="{{URL::previous ()}}">
                        <div class="form-group">
                            <div class="col-md-3">
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



                        <div class="form-group col-md-8">
                            <label>Asesor</label>
                            <input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control text-uppercase" placeholder="APELLIDOS, NOMBRES">
                        </div>

                        <div class="form-group col-md-4">
                            <div class="">
                                <label for="name">user</label>
                                <input type="text" name="user_red"  value="{{old('user')}}" class="form-control">
                            </div>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="">Team Leader</label>
                            <select name="tienda_teamleader_id" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione Team Leader">
                                @foreach($tiendas as $tienda )
                                    @foreach($tienda->teamleaders as $teamleader)
                                        <option value="{{$tienda->id}}-{{$teamleader->id}}">{{$tienda->tienda_nombre}} - {{$teamleader->nombre}}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-offset-0 col-md-4">
                            <label for="">Cargo GO</label>
                            <select name="cargo_go" class="selectpicker form-control text-uppercase " data-live-search="true" title="seleccione Cargo" required>
                                @foreach($cargos as $cargo)
                                    <option  value="{{$cargo}}">{{$cargo}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group form-group col-md-4">
                            <label><input type="checkbox" name="especialista" value="si"> Especialista</label>
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
