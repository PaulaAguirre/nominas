@extends ('layouts.admin_indirecta')
@section ('contenido')

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            @if (count($errors)>0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading text-bold"><span class="text-purple">NUEVO CIRCUITO</span></div>

                    <div class="panel-body text-uppercase">
                        {!!Form::open(array('url'=>'circuitos','method'=>'POST','autocomplete'=>'off'))!!}
                        {{Form::token()}}

                        <input type="hidden" name="url" value="{{URL::previous ()}}">
                        <div class="form-group">
                            <div class="">
                                <label for="name">Circuito</label>
                                <input type="text" name="codigo" required value="{{old('codigo')}}" class="form-control text-uppercase">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Coordinador</label>
                            <select name="coordinador_zona" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione coordinador">
                                @foreach($coordinadores as $coordinador )
                                    @foreach($coordinador->zonas as $zona)
                                        <option value="{{$coordinador->id}}-{{$zona->id}}">{{$coordinador->nombre}} - {{$zona->nombre}}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Auditor</label>
                            <select name="auditor_id" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione auditor">
                                @foreach($auditores as $auditor )
                                    <option value="{{$auditor->id}}">{{'CH:'.$auditor->ch}} - {{$auditor->nombre}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group text-center">
                            <br>
                            <input name="_token" value="{{csrf_token()}}" type="hidden">
                            <button class="btn btn-primary" type="submit">Guardar</button>
                            <button class="btn btn-danger" type="reset">Cancelar</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {!!Form::close()!!}
    </div>


@endsection
