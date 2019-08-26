{!! Form::open(array('url'=>'aprobacion_consideraciones_directa/201908','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="form-group form-inline">

    <select name="id_persona" class="form-control selectpicker text-uppercase col-lg-4" id="id_representante" title="Seleccione Representante" data-live-search="true">
        @foreach($personas_consideracion as $persona)
            <option value="{{$persona->id_persona_directa}}">ch: {{$persona->personaDirecta->ch}} - {{$persona->personaDirecta->nombre}}</option>
        @endforeach
    </select>

    <select name="id_consideracion" class="form-control selectpicker text-uppercase col-lg-4" id="id_consideracion" title="Seleccione consideracion" data-live-search="true">
        @foreach($consideraciones as $consideracion)
            <option value="{{$consideracion->id}}">{{$consideracion->nombre}}</option>
        @endforeach
    </select>
    <select name="id_jefe" class="form-control selectpicker text-uppercase col-lg-4" id="id_jefe" title="Seleccione Jefe" data-live-search="true">
        @foreach($jefes as $jefe)
            <option value="{{$jefe->id_persona}}">ch:{{$jefe->ch}} - {{$jefe->nombre}}</option>
        @endforeach
    </select>

    <select name="id_zona" class="form-control selectpicker text-uppercase col-lg-4" id="id_zona" title="Seleccione Zona" data-live-search="true">
        @foreach($zonas as $zona)
            <option value="{{$zona->id}}">{{$zona->representante_zonal_nombre}} - {{$zona->zona}}</option>
        @endforeach
    </select>

    <button type="submit" class="btn btn-primary "><span>Buscar </span><i class="fa fa-search col-lg-2" aria-hidden="true"></i></button>

</div>

{{Form::close()}}
