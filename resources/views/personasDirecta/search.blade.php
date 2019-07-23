
    {!! Form::open(array('url'=>'representantes_directa','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
    <div class="form-group form-inline col-md-offset-0">

        <select name="id_persona" class="form-control selectpicker text-uppercase col-md-offset-0" id="id_persona" title="Seleccione Representante" data-live-search="true">
            @foreach($personasDirecta as $persona)
                <option value="{{$persona->id_persona}}">ch: {{$persona->ch}} - {{$persona->nombre}}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary"><span>Buscar </span><i class="fa fa-search col-lg-2" aria-hidden="true"></i></button>

    </div>
    {!! Form::close() !!}
