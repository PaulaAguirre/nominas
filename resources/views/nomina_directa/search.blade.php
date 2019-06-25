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

        <label class="col-lg-offset-1 text-info">MES: </label>
        <div class="form-group col-lg-offset-0">
            <select name="mes"class="form-control selectpicker" id="mes" title="Selecione el mes a generar" required>
                <option value="{{$meses[0]}}" >{{$meses[0]}}</option>
                <option value="{{$meses[1]}}">{{$meses[1]}}</option>
            </select>
        </div>

    </div>


</div>
<br>
{{Form::close()}}
