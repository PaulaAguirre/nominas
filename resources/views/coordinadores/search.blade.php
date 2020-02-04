
    {!! Form::open(array('url'=>'coordinadores','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
    <div class="form-group form-inline">

        <select name="id_coordinador" class="form-control selectpicker text-uppercase col-md-offset-0" id="id_persona" title="Seleccione Coordinador" data-live-search="true">
            @foreach($coordinadores as $coordinador)
                <option value="{{$coordinador->id_persona}}">{{$coordinador->ch}}-{{$coordinador->nombre}}</option>
            @endforeach
        </select>

        <select name="id_zona" class="form-control selectpicker text-uppercase col-md-offset-0" id="id_persona" title="Seleccione Zona" data-live-search="true">
            @foreach($zonas as $zona)
                <option value="{{$zona->id}}">{{$zona->zona}}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary"><span>Buscar </span><i class="fa fa-search col-lg-2" aria-hidden="true"></i></button>

    </div>
    {!! Form::close() !!}
