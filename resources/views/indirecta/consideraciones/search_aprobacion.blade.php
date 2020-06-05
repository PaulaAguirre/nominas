{!! Form::open(array('url'=>'aprobacion_consideraciones_indirecta','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="form-group form-inline">

    <select name="impulsador_id" class="form-control selectpicker text-uppercase col-lg-4" id="impulsador_id" title="Seleccione Representante" data-live-search="true">
        @foreach($impulsadores as $impulsador)
            <option value="{{$impulsador->id_impulsador}}">ch: {{$impulsador->impulsador->ch}} - {{$impulsador->impulsador->nombre}}</option>
        @endforeach
    </select>

    <select name="id_consideracion" class="form-control selectpicker text-uppercase col-lg-4" id="id_consideracion" title="Seleccione consideracion" data-live-search="true">
        @foreach($consideraciones as $consideracion)
            <option value="{{$consideracion->id}}">{{$consideracion->nombre}}</option>
        @endforeach
    </select>

    <button type="submit" class="btn btn-default text-gray" style="background-color: #5d59a6"><span>Buscar </span><i class="fa fa-search col-lg-2" aria-hidden="true"></i></button>

</div>

{{Form::close()}}
