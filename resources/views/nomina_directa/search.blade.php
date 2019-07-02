{!! Form::open(array('url'=>'nomina_directa/create','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="">
    <div class="form-inline">
        <select name="id_representante" class="form-control selectpicker text-uppercase col-lg-3 " id="id_representante" title="Seleccione Representante" data-live-search="true">
            @foreach($personas_directa as $persona)
                <option value="{{$persona->id_persona}}">{{strtoupper ($persona->nombre)}}</option>
            @endforeach
        </select>
        <select name="id_jefe" class="form-control selectpicker text-uppercase col-lg-3 " id="id_jefe" title="Selecccione Jefe" data-live-search="true">
            @foreach($jefes as $jefe)
                <option value="{{$jefe->id_persona}}">{{strtoupper ($jefe->nombre)}}</option>
            @endforeach
        </select>
        <select name="id_zonal" class="form-control selectpicker text-uppercase col-lg-3 " id="id_zonal" title="Selecccione Rep. Zonal" data-live-search="true">
            @foreach($zonales as $zonal)
                <option value="{{$zonal->id_persona}}">{{strtoupper ($zonal->nombre)}}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary "><span>Buscar </span><i class="fa fa-search" aria-hidden="true"></i></button>

    </div>


</div>
<br>
{{Form::close()}}
