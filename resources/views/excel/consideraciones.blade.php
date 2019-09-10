
<div class="form-group">
    {!! Form::open(array('url'=>'/exportar_consideraciones','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
    <div class="form-group form-inline">
        <div class="input-group">
            <input type="text" class="form-control datepicker" name="fecha_inicial">
            <div class="input-group-addon">
                <span class="fa fa-calendar"></span>
            </div>
            <input type="text" class="form-control datepicker" name="fecha_final">
        </div>
        <div class="form-group">
            <a href="{{URL::action('ExcelController@exportConsideracionesController')}}">
                <button class="btn btn-bitbucket">exportar consideraciones</button>
            </a>
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
{{Form::close()}}
