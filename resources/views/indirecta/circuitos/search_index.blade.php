{!! Form::open(array('url'=>'circuitos','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="form-group form-inline">

    <select name="auditor_id" class="form-control selectpicker text-uppercase col-lg-4" id="impulsador_id" title="Seleccione Auditor" data-live-search="true">
        @foreach($auditores as $auditor)
            <option value="{{$auditor->id}}">ch: {{$auditor->ch}} - {{$auditor->nombre}}</option>
        @endforeach
    </select>

    <select name="coordinador_id" class="form-control selectpicker text-uppercase col-lg-4" id="pdv_id  " title="Seleccione coordinador" data-live-search="true">
        @foreach($coordinadores as $coordinador)
            <option value="{{$coordinador->id}}">{{$coordinador->nombre}}</option>
        @endforeach
    </select>

    <select name="circuito_id" class="form-control selectpicker text-uppercase col-lg-4" id="pdv_id  " title="Seleccione circuito" data-live-search="true">
        @foreach($circuitos as $circuito)
            <option value="{{$circuito->id}}">{{$circuito->codigo}}</option>
        @endforeach
    </select>

    <button type="submit" class="btn btn-default text-gray" style="background-color: #5d59a6"><span>Buscar </span><i class="fa fa-search col-lg-2" aria-hidden="true"></i></button>

</div>

{{Form::close()}}
