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
                    <div class="panel-heading text-bold"><span class="text-purple">NUEVO PDV</span></div>

                    <div class="panel-body text-uppercase">
                        {!!Form::open(array('url'=>'pdvs','method'=>'POST','autocomplete'=>'off'))!!}
                        {{Form::token()}}

                        <input type="hidden" name="url" value="{{URL::previous ()}}">
                        <div class="form-group">
                            <div class="">
                                <label for="name">PDV</label>
                                <input type="number" name="codigo" required value="{{old('codigo')}}" class="form-control text-uppercase">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <label for="name">Circuito</label>
                                <select name="circuito_id" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione circuito">
                                    @foreach($circuitos as $circuito )
                                        <option value="{{$circuito->id}}">{{$circuito->coordinador ? $circuito->coordinador->nombre : ''}} - {{$circuito->codigo}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="">
                                <label for="name">Nombre Cliente</label>
                                <input type="text" name="nombre"  value="{{old('nombre')}}" class="form-control text-uppercase">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <label for="name">IMPULSADOR</label>
                                <select name="impulsador_id" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione impulsador">
                                    @foreach($impulsadores as $impulsador )
                                        <option value="{{$impulsador->id}}">{{$impulsador->ch}} - {{$impulsador->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
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
