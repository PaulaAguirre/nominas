@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Nueva Nomina Directa</h3>
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
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        @include('nomina_directa.search')
    </div>

    {!!Form::open(array('url'=>'nomina_directa','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}

        <div class="row text-uppercase">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead class="text-center" style="background-color: #8eb4cb">
                        <th>Region/Zona</th>
                        <th>Rep Zonal - Rep Jefe</th>
                        <th>CH</th>
                        <th>Representante</th>
                        <th>Consideraciones</th>
                        </thead>
                        @foreach ($personas_directa as $persona)
                            <tr class="text-uppercase">
                                <td>{{$persona->region->region.' '.$persona->zona->zona}}</td>
                                <td>{{$persona->representanteZonal->nombre}} / {{$persona->representanteJefe->nombre}}</td>
                                <td>{{$persona->ch}}</td>
                                <td><input type="hidden" name="idrepresentante[]" value="{{$persona->id_persona}}" >{{$persona->nombre}}</td>
                                <td>
                                    <select name="consideraciones[]" class="form-control" id="activo">
                                        <option value="no aplica" selected>No aplica</option>
                                        <option value="vacaciones" >Vacaciones</option>
                                        <option value="reposo maternidad">Reposo Maternidad</option>
                                        <option value="desvinculacion">Desvinculacion</option>
                                        <option value="renuncia">Renuncia</option>
                                        <option value="otros">Otros</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                        @include('nomina_directa.modal_nomina')
                    </table>
                    <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12 text-center" id="guardar">
                         <div class="form-group">
                            <input name="_token" value="{{csrf_token()}}" type="hidden">
                             <a href="" data-target="#modal-nomina-create" data-toggle="modal" data-placement="top" title="generar"><button class="btn btn-primary">Generar <i class="fa fa-book" aria-hidden="true"></i></button></a>
                             <button class="btn btn-danger" type="reset">Cancelar</button>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    {!!Form::close()!!}

@endsection
