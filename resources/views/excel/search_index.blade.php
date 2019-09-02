{!! Form::open(array('url'=>'/excel','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="form-group form-inline">

        <input type="number" name="mes" class="form-control text-uppercase" placeholder="MES: YYYYMM">

    <a href="{{URL::action('ExcelController@exportNominaDirecta')}}">
        <button class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Datos del Asesor"><i class="fa fa-pencil"></i></button>
    </a>

</div>

{{Form::close()}}
