@extends ('layouts.admin')
@section ('contenido')
    <div class="row">

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

            <div class="form-group">
                <h3>Reportes</h3>
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
                        <button class="btn btn-success">Nuevos Ingresos</button>
                    </a>
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
