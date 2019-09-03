@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

            <div class="form-group">
                @include('excel.consideraciones')
                @include('excel.nuevos_ingresos')

            </div>
        </div>
    </div>



@endsection
