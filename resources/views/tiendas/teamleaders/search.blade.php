
    {!! Form::open(array('url'=>'teamleaders','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
    <div class="form-group form-inline">

        <select name="teamleader_id" class="form-control selectpicker text-uppercase col-md-offset-0" id="id_persona" title="Seleccione Teamleader" data-live-search="true">
            @foreach($teamleaders as $teamleader)
                <option value="{{$teamleader->id}}">{{$teamleader->nombre}}</option>
            @endforeach
        </select>

        <select name="tienda_id" class="form-control selectpicker text-uppercase col-md-offset-0" id="id_persona" title="Seleccione tienda" data-live-search="true">
            @foreach($tiendas as $tienda)
                <option value="{{$tienda->id}}">{{$tienda->tienda_nombre}}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-success"><span>Buscar </span><i class="fa fa-search col-lg-2" aria-hidden="true"></i></button>

    </div>
    {!! Form::close() !!}
