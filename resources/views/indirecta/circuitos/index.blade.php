@extends ('layouts.admin_indirecta')
@section ('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>circuitos
                <a href="{{url('circuitos/create')}}"><button class="btn btn-success">Crear Circuito</button></a></h3>
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
        @include('indirecta.circuitos.search_index')
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_persona">
                    <thead class="text-center text-gray" style="background-color: #5d59a6">
                    <th>ID</th>
                    <th>CIRCUITO</th>
                    <th>Auditor CH</th>
                    <th>Auditor</th>
                    <th>Coordinador</th>
                    <th>Coordinador CH</th>
                    <th>OPC</th>
                    </thead>
                    @foreach($circuitos as $circuito)
                        <tr class="text-uppercase">
                            <td>{{$circuito->id}}</td>
                            <td>{{$circuito->codigo}}</td>
                            <td>{{$circuito->auditor ? $circuito->auditor->ch : ''}}</td>
                            <td>{{$circuito->auditor ? $circuito->auditor->nombre : ''}}</td>
                            <td>{{$circuito->coordinador ? $circuito->coordinador->nombre : '' }}</td>
                            <td>{{$circuito->coordinador ? $circuito->coordinador->ch : '' }}</td>

                            <td> <a href="{{URL::action('CircuitoController@edit', $circuito->id)}}">
                                    <button class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Datos del Asesor"><i class="fa fa-pencil"></i></button>
                                </a></td>

                        </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>

@endsection
