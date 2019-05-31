
    {!! Form::open(array('url'=>'representantes_directa','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
    <div class="input-group">
        <input type="text" class="form-control" placeholder="buscar" name="name">
        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </span>
    </div><!-- /input-group -->
    {!! Form::close() !!}
