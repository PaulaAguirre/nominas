@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <h3>Nueva Nomina Directa - <span class="text-info">Mes: {{$mes_nomina->format ('Y-m')}}</span> </h3>
            @include('nomina_directa.search')
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
                        <th>Activo</th>
                        </thead>
                        @foreach ($personas_directa as $persona)
                            <tr class="text-uppercase">
                                <td>{{$persona->region->region.' '.$persona->zona->zona}}</td>
                                <td>{{$persona->representanteZonal->nombre}}
                                    / {{$persona->representanteJefe->nombre}}</td>
                                <td>{{$persona->ch}}</td>
                                <td><input type="hidden" name="idrepresentante[]" value="{{$persona->id_persona}}" >
                                    <input type="hidden" name="persona_mes[]" id="persona_mes" value="{{$persona->id_persona.$mes_nomina->format ('Ym')}}">
                                   {{$persona->nombre}}</td>
                                <td>
                                    <select name="activo[]" class="form-control" id="activo">
                                        <option value="activo" selected>Si</option>
                                        <option value="inactivo" >No</option>
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

    @push('scripts')
        <script>

            function setear_mes_persona() {

                persona = document.getElementById('idrepresentante');
                persona_mes = document.getElementById('persona_mes');
                persona_mes.val(persona);

            }

        </script>
    @endpush

@endsection



