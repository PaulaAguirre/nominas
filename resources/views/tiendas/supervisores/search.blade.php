
    {!! Form::open(array('url'=>'supervisores_tienda','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
    <div class="form-group form-inline">

        <select name="supervisor_id" class="form-control selectpicker text-uppercase col-md-offset-0" id="id_persona" title="Seleccione Supervisor" data-live-search="true">
            @foreach($supervisores as $supervisor)
                <option value="{{$supervisor->id}}">CH:{{$supervisor->ch}}-{{$supervisor->nombre}}</option>
            @endforeach
        </select>


        <button type="submit" class="btn btn-success"><span>Buscar </span><i class="fa fa-search col-lg-2" aria-hidden="true"></i></button>

    </div>
    {!! Form::close() !!}
