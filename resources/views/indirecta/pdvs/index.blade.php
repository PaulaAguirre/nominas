@extends ('layouts.admin_indirecta')
@section ('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>PDVs
                <a href="{{url('pdvs/create')}}"><button class="btn btn-microsoft">Crear PDV</button></a>
                <a href="{{url('circuitos/create')}}"><button class="btn btn-success">Crear Circuito</button></a>
            </h3>
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

    {{Form::token()}}
    <div class="row text-uppercase">
        @include('indirecta.pdvs.search_index')
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_persona">
                    <thead class="text-center text-gray" style="background-color: #5d59a6">
                    <th>ID</th>
                    <th>ID PDV</th>
                    <th>Nombre</th>
                    <th>CIRCUITO</th>
                    <th>CH</th>
                    <th>Impulsador</th>
                    <th class="col-lg-1">Coordinador</th>
                    <th>ZONA</th>
                    <th>OPC</th>
                    </thead>
                    @foreach($pdvs as $pdv)
                        <tr class="text-uppercase">
                            <td>{{$pdv->id}}</td>
                            <td>{{$pdv->codigo}}</td>
                            <td>{{$pdv->nombre}}</td>
                            <td>{{$pdv->circuito ? $pdv->circuito->codigo : ''}}</td>
                            <td>{{$pdv->impulsador ? $pdv->impulsador->ch :''}}</td>
                            <td>{{$pdv->impulsador ? $pdv->impulsador->nombre : ''}}</td>
                            <td>{{$pdv->impulsador ? $pdv->impulsador->coordinador->nombre : ''}}</td>
                            <td>{{$pdv->circuito ? $pdv->circuito->zona->nombre : ''}}</td>
                            <td class="text-center">
                                <a href="{{URL::action('PdvController@edit', $pdv->id)}}">
                                    <button class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Datos del Asesor"><i class="fa fa-pencil"></i></button>
                                    <a href="" data-target="#modal-delete-{{$pdv->id}}" data-toggle="modal"><button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button></a>

                                </a>

                            </td>
                        </tr>
                        @include('indirecta.pdvs.modal')
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
