{!! Form::open(array('url'=>'nomina_tienda/create','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="">
    <div class="form-inline">
        <select name="zona_id" class="form-control selectpicker  text-uppercase col-lg-5 " title="Selecccione Zona" data-live-search="true">
            @foreach($zonas_tienda as $zona)
                <option value="{{$zona->id}}">{{strtoupper ($zona->zona)}}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary "><span>Buscar </span><i class="fa fa-search" aria-hidden="true"></i></button>

    </div>


</div>
<br>
{{Form::close()}}
