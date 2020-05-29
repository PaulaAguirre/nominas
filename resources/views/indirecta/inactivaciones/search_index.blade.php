{!! Form::open(array('url'=>'inactivaciones_indirecta','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="form-group form-inline">

    <select name="asesor_id" class="form-control selectpicker text-uppercase col-lg-4" id="asesor_id" title="Seleccione Representante" data-live-search="true">
        @foreach($impulsadores_inactivos as $impulsador)
            <option value="{{$impulsador->impulsador_id}}">ch: {{$impulsador->impulsador->ch}} - {{$impulsador->impulsador->nombre}}</option>
        @endforeach
    </select>

    <select name="estado" class="form-control selectpicker text-uppercase col-lg-4" id="estado" title="estado" data-live-search="true">
            <option value="aprobado">aprobado</option>
            <option value="rechazado">rechazado</option>
            <option value="pendiente">pendiente</option>
    </select>

    <button type="submit" class="btn btn-default text-gray" style="background-color: #5d59a6"><span>Buscar </span><i class="fa fa-search col-lg-2" aria-hidden="true"></i></button>

</div>

{{Form::close()}}
