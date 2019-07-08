{!! Form::open(array('url'=>'nomina_directa','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="form-group form-inline">

        <select name="id_persona" class="form-control selectpicker text-uppercase col-lg-4" id="id_representante" title="Seleccione Representante" data-live-search="true">
            @foreach($personas as $persona)
                <option value="{{$persona->id_nomina}}">ch: {{$persona->personaDirecta->ch}} - {{$persona->personaDirecta->nombre}}</option>
            @endforeach
        </select>

            <input type="text" name="mes" class="form-control text-uppercase" placeholder="MES: YYYYMM">

    <button type="submit" class="btn btn-primary "><span>Buscar </span><i class="fa fa-search col-lg-2" aria-hidden="true"></i></button>

</div>

{{Form::close()}}
