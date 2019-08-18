
{!! Form::open(array('url'=>'aprobacion_nomina_directa/201909','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="input-group col-lg-3">
    <input type="text" class="form-control" placeholder="MES: YYYYMM" name="mes">
    <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </span>
</div><!-- /input-group -->
{!! Form::close() !!}
