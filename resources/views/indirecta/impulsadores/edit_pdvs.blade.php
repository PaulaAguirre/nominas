@extends ('layouts.admin_indirecta')
@section ('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Agregar PDVs - Asesor: {{$impulsador->nombre}} </h3>
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

    {!!Form::model ($impulsador, ['method'=>'PATCH', 'route'=>['editar_pdv', $impulsador]])!!}
    {{Form::token()}}
    <div class="row text-uppercase">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_persona">
                    <thead class="text-center text-gray" style="background-color: #5d59a6">
                    <th>ID</th>
                    <th>ID PDV</th>
                    <th>CIRCUITO</th>
                    <th class="col-lg-1">Agregar</th>
                    </thead>
                    @foreach ($circuitos as $circuito)
                        @foreach($circuito->pdvs as $pdv)
                        <tr class="text-uppercase">
                            <td>{{$pdv->id}}</td>
                            <td>{{$pdv->codigo}}</td>
                            <td>{{$pdv->circuito ? $pdv->circuito->codigo : ''}}</td>
                            @if($impulsador->pdvs->contains('id', $pdv->id))
                                <td class="text-center"><input type="checkbox" value="{{$pdv->id}}" name="idpdv[]" checked></td>
                            @else
                                <td class="text-center"><input type="checkbox" value="{{$pdv->id}}" name="idpdv[]"></td>
                            @endif
                        </tr>
                        @endforeach
                    @endforeach
                </table>
                <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12 text-center" id="guardar">
                    <div class="form-group">
                        <input name="_token" value="{{csrf_token()}}" type="hidden">
                        <button class="btn btn-primary" type="submit">Guardar</button>
                        <button id="btn_cancelar" class="btn btn-danger" type="reset">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
