{!! Form::open(array('url'=>'asesores_tienda','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="form-group form-inline">

        <select name="asesor_id" class="form-control selectpicker text-uppercase col-lg-4" id="id_representante" title="Seleccione Representante" data-live-search="true">
            @foreach($asesores as $asesor)
                <option value="{{$asesor->id}}">ch: {{$asesor->ch}} - {{$asesor->nombre}}</option>
            @endforeach
        </select>

        <select name="tienda_id" class="form-control selectpicker text-uppercase col-lg-4" id="id_jefe" title="Jefe Tienda" data-live-search="true">
            @foreach($tiendas as $tienda)
                <option value="{{$tienda->id}}">Tienda:{{$tienda->jefetienda ? $tienda->tienda_nombre.'-'.$tienda->jefetienda->nombre : $tienda->tienda_nombre}}</option>
            @endforeach
        </select>

        <select name="zona_id" class="form-control selectpicker text-uppercase col-lg-4" id="zona_id" title="Seleccione Zona" data-live-search="true">
            @foreach($zonas_tienda as $zona)
                <option value="{{$zona->id}}">{{$zona->representante_zonal_nombre}} - {{$zona->zona}}</option>
            @endforeach
        </select>

        <select name="estado" class="form-control selectpicker text-uppercase col-lg-4"  title="activo" data-live-search="true">
            <option value="ACTIVO">Activo</option>
            <option value="INACTIVO">inactivo</option>
        </select>
    <button type="submit" class="btn btn-success "><span>Buscar </span><i class="fa fa-search col-lg-2" aria-hidden="true"></i></button>

</div>

{{Form::close()}}
