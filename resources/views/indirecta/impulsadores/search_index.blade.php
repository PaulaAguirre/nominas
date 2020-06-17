{!! Form::open(array('url'=>'asesores_indirecta','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="form-group form-inline">

        <select name="impulsador_id" class="form-control selectpicker text-uppercase col-lg-4" id="id_representante" title="Seleccione Representante" data-live-search="true">
            @foreach($impulsadores as $impulsador)
                <option value="{{$impulsador->id}}">ch: {{$impulsador->ch}} - {{$impulsador->nombre}}</option>
            @endforeach
        </select>

        <select name="coordinador_id" class="form-control selectpicker text-uppercase col-lg-4" id="id_jefe" title="Jefe indirecta" data-live-search="true">
            @foreach($coordinadores as $coordinador)
                <option value="{{$coordinador->id}}">{{$coordinador->ch.' - '.$coordinador->nombre}}</option>
            @endforeach
        </select>

        <select name="zona_id" class="form-control selectpicker text-uppercase col-lg-4" id="zona_id" title="Seleccione Zona" data-live-search="true">
            @foreach($zonas_indirecta as $zona)
                <option value="{{$zona->id}}">{{$zona->representante_zonal_nombre}} - {{$zona->nombre}}</option>
            @endforeach
        </select>

        <select name="estado" class="form-control selectpicker text-uppercase col-lg-4"  title="activo" data-live-search="true">
            <option value="ACTIVO">Activo</option>
            <option value="INACTIVO">inactivo</option>
        </select>
    <button type="submit" class="btn btn-linkedin "><span>Buscar </span><i class="fa fa-search col-lg-2" aria-hidden="true"></i></button>

</div>

{{Form::close()}}
