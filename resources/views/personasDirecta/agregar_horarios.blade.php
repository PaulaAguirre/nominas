@extends ('layouts.admin')
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
            <div class="col-md-8 text-uppercase col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><span class="text-bold text-info">Asesor: {{$persona->personaDirecta->nombre}}</span></div>

                    <div class="panel-body">
                        {!!Form::model ($persona, ['method'=>'PATCH', 'route'=>['horarios.update', $persona]])!!}
                        {{Form::token()}}

                        <input type="hidden" name="url" value="{{URL::previous ()}}">
                        <legend>Horarios</legend>
                        <div class="container">
                            <label for="dtp_input3" class="col-md-2 control-label">DIAS</label>
                                <div class="form-group">
                                    <div class="checkbox">
                                        @if($dias_persona->contains('LUNES'))
                                            <label><input type="checkbox" checked value="{{"LUNES"}}" name="dias[]">{{"LUNES"}}</label>
                                        @else
                                            <label><input type="checkbox"  value="{{"LUNES"}}" name="dias[]">{{"LUNES"}}</label>
                                        @endif
                                        @if($dias_persona->contains('MARTES'))
                                            <label><input type="checkbox" checked value="{{"MARTES"}}" name="dias[]">{{"MARTES"}}</label>
                                        @else
                                            <label><input type="checkbox"  value="{{"MARTES"}}" name="dias[]">{{"MARTES"}}</label>
                                        @endif
                                        @if($dias_persona->contains('MIÉRCOLES'))
                                            <label><input type="checkbox" checked value="{{"MIÉRCOLES"}}" name="dias[]">{{"MIÉRCOLES"}}</label>
                                        @else
                                            <label><input type="checkbox"  value="{{"MIÉRCOLES"}}" name="dias[]">{{"MIÉRCOLES"}}</label>
                                        @endif
                                        @if($dias_persona->contains('JUEVES'))
                                            <label><input type="checkbox" checked value="{{"JUEVES"}}" name="dias[]">{{"JUEVES"}}</label>
                                        @else
                                            <label><input type="checkbox"  value="{{"JUEVES"}}" name="dias[]">{{"JUEVES"}}</label>
                                        @endif
                                        @if($dias_persona->contains('VIERNES'))
                                            <label><input type="checkbox" checked value="{{"VIERNES"}}" name="dias[]">{{"VIERNES"}}</label>
                                        @else
                                            <label><input type="checkbox"  value="{{"VIERNES"}}" name="dias[]">{{"VIERNES"}}</label>
                                        @endif
                                        @if($dias_persona->contains('SÁBADO'))
                                            <label><input type="checkbox" checked value="{{"SÁBADO"}}" name="dias[]">{{"SÁBADO"}}</label>
                                        @else
                                            <label><input type="checkbox"  value="{{"SÁBADO"}}" name="dias[]">{{"SÁBADO"}}</label>
                                        @endif
                                    </div>
                                </div>
                        </div>
                        <br>
                        <div class="container">
                            @if(!($persona->hora_entrada and $persona->hora_salida))
                                    <div class="form-group">
                                        <label for="dtp_input3" class="col-md-2 control-label">Hora Entrada</label>
                                        <div class="input-group date form_time col-md-5" data-date="" data-date-format="hh:ii"  data-link-format="hh:ii">
                                            <input class="form-control" size="16" type="text" value="" name="hora_entrada" >
                                            <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                                        </div>
                                    </div>

                                <div class="form-group">
                                    <label for="dtp_input2" class="col-md-2 control-label">Hora Salida</label>
                                    <div class="input-group date form_time col-md-5" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
                                        <input class="form-control" size="16" type="text" value="" name="hora_salida" >
                                        <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                                    </div>
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="dtp_input3" class="col-md-2 control-label">Hora Entrada</label>
                                    <div class="input-group date  col-md-5" data-date="" data-date-format="hh:ii"  data-link-format="hh:ii">
                                        <input class="form-control" size="16" type="text" value="{{$persona->hora_entrada}}" name="hora_entrada" >
                                        <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dtp_input2" class="col-md-2 control-label">Hora Salida</label>
                                    <div class="input-group date col-md-5" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
                                        <input class="form-control" size="16" type="text" value="{{$persona->hora_salida}}" name="hora_salida" >
                                        <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12 text-center col-lg-offset-1" id="guardar">
                            <div class="form-group">
                                <input name="_token" value="{{csrf_token()}}" type="hidden">
                                <button class="btn btn-primary" type="submit">Guardar</button>
                                <button id="btn_cancelar" class="btn btn-danger" type="reset">Cancelar</button>
                            </div>
                        </div>
                    </div>

        </div>
        {!!Form::close()!!}
    </div>


@push('scripts')
    <script>
        $(document).ready(function () {

            $('.form_time').datetimepicker({
                language:  'es',
                weekStart: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 1,
                minView: 0,
                maxView: 1,
                forceParse: 0
            });

        })


    </script>
@endpush
@endsection
