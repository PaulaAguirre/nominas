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
            {!!Form::model ($pdv, ['method'=>'PATCH', 'route'=>['pdvs.update', $pdv]])!!}
            {{Form::token()}}
            <div class="col-md-5 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading text-bold"><span class="text-purple">Editar PDV</span></div>

                    <div class="panel-body text-uppercase">

                        <input type="hidden" name="url" value="{{URL::previous ()}}">
                        <div class="form-group">
                            <div class="">
                                <label for="name">PDV</label>
                                <input type="number" name="codigo" required value="{{$pdv->codigo}}" class="form-control text-uppercase">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <label for="name">Circuito</label>
                                <select name="circuito_id" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione circuito">
                                    @foreach($circuitos as $circuito )
                                        @if($pdv->circuito_id == $circuito->id)
                                            <option selected value="{{$circuito->id}}">{{$circuito->coordinador ? $circuito->coordinador->nombre : ''}} - {{$circuito->codigo}}</option>
                                        @else
                                            <option value="{{$circuito->id}}">{{$circuito->coordinador ? $circuito->coordinador->nombre : ''}} - {{$circuito->codigo}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <label for="name">Nombre Cliente</label>
                                <input type="text" name="nombre"  value="{{$pdv->nombre}}" class="form-control text-uppercase">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <label for="name">IMPULSADOR</label>
                                <select name="impulsador_id" class="selectpicker form-control text-uppercase " data-live-search="true" title="Seleccione impulsador">
                                    @foreach($impulsadores as $impulsador )
                                        @if($pdv->impulsador_id == $impulsador->id)
                                            <option selected value="{{$impulsador->id}}">{{$impulsador->ch}} - {{$impulsador->nombre}}</option>
                                        @else
                                            <option  value="{{$impulsador->id}}">{{$impulsador->ch}} - {{$impulsador->nombre}}</option>
                                        @endif
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
    </div>

@endsection

