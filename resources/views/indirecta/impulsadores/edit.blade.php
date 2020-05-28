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
    <div class="container">
        <div class="row">
            {!!Form::model ($impulsador, ['method'=>'PATCH', 'route'=>['asesores_indirecta.update', $impulsador]])!!}
            {{Form::token()}}
            <div class="panel panel-default col-md-7 col-md-offset-1">
                <div class="panel-heading text-bold"><span class="text-purple">Editar ASESOR</span></div>

                <div class="panel-body text-uppercase">


                    <input type="hidden" name="url" value="{{URL::previous ()}}">

                    <div class="form-group col-md-3">
                        <div class="">
                            <label for="name">CH</label>
                            <input type="number" name="ch" required value="{{$impulsador->ch}}" class="form-control text-uppercase">
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">Fecha ingreso</label>
                        <div class="input-group">
                            <input type="text" disabled value="{{$impulsador->fecha_ingreso}}" class="form-control text-uppercase" name="fecha_ingreso">
                        </div>
                    </div>


                    <div class="form-group col-md-3">
                        <div class="">
                            <label for="name">Documento</label>
                            <input type="text" name="documento" required value="{{$impulsador->documento}}" class="form-control text-uppercase">
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
                        <input type="text" name="nombre" required value="{{$impulsador->nombre}}" class="form-control text-uppercase" placeholder="APELLIDOS, NOMBRES">
                    </div>


                    <div class="form-group col-md-6">
                        <label for="">Coordinador</label>
                        <select name="coordinador_zona" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione Coordinador">
                            @foreach($coordinadores as $coordinador )
                                @foreach($coordinador->zonas as $zona)
                                    @if($impulsador->coordinador_id == $coordinador->id and $impulsador->zona->id == $zona->id)
                                        <option selected  value="{{$coordinador->id.'-'.$zona->id}}">{{$coordinador->ch.' - '.$coordinador->nombre.' - '.$zona->nombre}}</option>
                                    @else
                                        <option value="{{$coordinador->id.'-'.$zona->id}}">{{$coordinador->ch.' - '.$coordinador->nombre.' - '.$zona->nombre}}</option>
                                    @endif
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-offset-0 col-md-4">
                        <label for="">Clasificación</label>
                        <select name="clasificacion_id" class="selectpicker form-control text-uppercase " data-live-search="true" title="seleccione clasificacion" required>
                            @foreach($clasificaciones as $clasificacion)
                                @if($impulsador->clasificacion_id == $clasificacion->id)
                                    <option selected value="{{$clasificacion->id}}">{{$clasificacion->nombre}}</option>
                                @else
                                    <option  value="{{$clasificacion->id}}">{{$clasificacion->nombre}}</option>
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
