
<div class="form-group">
    {!! Form::open(array('url'=>'/excel_nuevos_ingresos','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
    <div class="form-group form-inline">
        <label for="">Seleccione Rango de fechas</label>
        <div class="input-group">
            <input type="text" class="form-control datepicker" name="fecha_inicial">
            <div class="input-group-addon">
                <span class="fa fa-calendar"></span>
            </div>
            <input type="text" class="form-control datepicker" name="fecha_final">
        </div>
    </div>
    <div class="form-group">
        <a href="{{URL::action('ExcelController@exportNuevosIngresos')}}">
            <button class="btn btn-bitbucket">Nuevos Ingresos</button>
        </a>
    </div>


</div>
{{Form::close()}}


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
