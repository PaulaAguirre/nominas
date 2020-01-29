{!! Form::open(array('url'=>'nomina_indirecta','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="form-group form-inline">

    <select name="impulsador_id" class="form-control selectpicker text-uppercase col-lg-4" id="id_representante" title="Seleccione Asesor" data-live-search="true">
        @foreach($impulsadores as $impulsador)
            <option value="{{$impulsador->impulsador->id}}">ch: {{$impulsador->impulsador ? $impulsador->impulsador->ch : '' }} - {{$impulsador->impulsador ? $impulsador->impulsador->nombre : ''}}</option>
        @endforeach
    </select>

    <select name="coordinador_id" class="form-control selectpicker text-uppercase col-lg-4" id="id_jefe" title="Selecione coordinador" data-live-search="true">
        @foreach($coordinadores as $coordinador)
            <option value="{{$coordinador->id}}">CH: {{$coordinador->ch}} - {{$coordinador->nombre}}</option>
        @endforeach
    </select>

    <select name="zona_id" class="form-control selectpicker text-uppercase col-lg-4" id="zona_id" title="Seleccione Zona" data-live-search="true">
        @foreach($zonas as $zona)
            <option value="{{$zona->id}}">{{$zona->representante_zonal_nombre}} - {{$zona->nombre}}</option>
        @endforeach
    </select>

    <select name="activo" class="form-control selectpicker text-uppercase col-lg-4"  title="activo" data-live-search="true">
        <option value="">Activo</option>
        <option value="pendiente">pendiente inactivación</option>
        <option value="aprobado">inactivo</option>
    </select>
    <button type="submit" class="btn btn-default text-gray" style="background-color: #5d59a6"><span>Buscar </span><i class="fa fa-search col-lg-2" aria-hidden="true"></i></button>

</div>

{{Form::close()}}
