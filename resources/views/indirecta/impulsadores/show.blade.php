@extends ('layouts.admin_indirecta')
@section ('contenido')
    <div class="row">
            <h3>PDVs - Asesor: {{$impulsador->nombre}} </h3>
    </div>
    <div class="row text-uppercase">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_persona">
                    <thead class="text-center text-gray" style="background-color: #5d59a6">
                    <th>ID</th>
                    <th>ID PDV</th>
                    <th>Nombre</th>
                    <th>CIRCUITO</th>
                    </thead>
                    @foreach($pdvs as $pdv)
                        <tr class="text-uppercase">
                            <td>{{$pdv->id}}</td>
                            <td>{{$pdv->codigo}}</td>
                            <td>{{$pdv->nombre}}</td>
                            <td>{{$pdv->circuito ? $pdv->circuito->codigo : ''}}</td>
                        </tr>
                    @endforeach
                </table>
                <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12 text-center" id="guardar">
                    <div class="form-group">
                        <input name="_token" value="{{csrf_token()}}" type="hidden">
                       <a href="{{URL::previous()}}">
                           <button class="btn btn-primary" type="submit">Volver</button>
                       </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
