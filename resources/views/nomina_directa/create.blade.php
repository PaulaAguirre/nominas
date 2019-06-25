@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
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

    {!!Form::open(array('url'=>'nomina_directa','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}

    <div class="">
        <div class="form-inline">
            <select name="id_representante" class="form-control selectpicker text-uppercase col-lg-3 " id="id_representante" title="Seleccione Representante" data-live-search="true">
                @foreach($personas_directa as $persona)
                    <option value="{{$persona->id_persona}}">{{strtoupper ($persona->nombre)}}</option>
                @endforeach
            </select>
            <select name="id_jefe" class="form-control selectpicker text-uppercase col-lg-3 " id="id_jefe" title="Selecccione Jefe" data-live-search="true">
                @foreach($jefes as $jefe)
                    <option value="{{$jefe->id_persona}}">{{strtoupper ($jefe->nombre)}}</option>
                @endforeach
            </select>
            <select name="id_zonal" class="form-control selectpicker text-uppercase col-lg-3 " id="id_zonal" title="Selecccione Rep. Zonal" data-live-search="true">
                @foreach($zonales as $zonal)
                    <option value="{{$zonal->id_persona}}">{{strtoupper ($zonal->nombre)}}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary "><span>Buscar </span><i class="fa fa-search" aria-hidden="true"></i></button>

            <label class="col-lg-offset-1 text-info">MES: </label>
            <div class="form-group col-lg-offset-0">
                <select name="mes"class="form-control selectpicker" id="mes" title="Selecione el mes a generar" required onclick="setear_mes_persona()">
                    <option value="{{$meses[0]}}" >{{$meses[0]}}</option>
                    <option value="{{$meses[1]}}">{{$meses[1]}}</option>
                </select>
            </div>
        </div>
    </div>
    <br>
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
                                <td><input type="hidden" name="idrepresentante[]" value="{{$persona->id_persona}}" >
                                    <input type="hidden" name="persona_mes[]" id="persona_mes">
                                   {{$persona->nombre}}</td>
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



