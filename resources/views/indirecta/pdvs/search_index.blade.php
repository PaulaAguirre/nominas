{!! Form::open(array('url'=>'pdvs','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="form-group form-inline">

    <select name="impulsador_id" class="form-control selectpicker text-uppercase col-lg-4" id="impulsador_id" title="Seleccione Representante" data-live-search="true">
        @foreach($impulsadores as $impulsador)
            <option value="{{$impulsador->id}}">ch: {{$impulsador->ch}} - {{$impulsador->nombre}}</option>
        @endforeach
    </select>

    <select name="pdv_id" class="form-control selectpicker text-uppercase col-lg-4" id="pdv_id  " title="Seleccione pdv" data-live-search="true">
        @foreach($pdvs as $pdv)
            <option value="{{$pdv->id}}">{{$pdv->codigo.' - '.$pdv->nombre}}</option>
        @endforeach
    </select>

    <button type="submit" class="btn btn-default text-gray" style="background-color: #5d59a6"><span>Buscar </span><i class="fa fa-search col-lg-2" aria-hidden="true"></i></button>

</div>

{{Form::close()}}
