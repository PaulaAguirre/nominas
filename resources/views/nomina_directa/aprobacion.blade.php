@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <h3>Aprobar nuevos Asesores - <span class="text-info">Mes: {{$mes}}</span> </h3>
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

    {!!Form::model ($mes, ['method'=>'PATCH', 'route'=>['nomina_directa_aprobacion.aprobacion', $mes]])!!}
    {{Form::token()}}
    <br>
    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_persona">
                    <thead class="text-center" style="background-color: #8eb4cb">
                        <th>CH</th>
                        <th>Representante</th>
                        <th>Region/Zona</th>
                        <th>Rep Zonal - Rep Jefe</th>
                        <th>Aprobar</th>
                    </thead>
                    @foreach ($personas_directa as $persona)
                        <tr class="text-uppercase" id="td_personas">
                            <td >{{$persona->personaDirecta->ch}}<input type="hidden" name="id_nomina[]" value="{{$persona->id_nomina}}"></td>
                            <td>{{$persona->personaDirecta->nombre}}</td>
                            <td>{{$persona->personaDirecta->zona->region->region.' / '.$persona->personaDirecta->zona->zona}}</td>
                            <td>{{$persona->personaDirecta->representanteJefe->zona->representante_zonal_nombre}}
                                / {{$persona->personaDirecta->representanteJefe->nombre}}</td>
                            <td>
                                <select name="aprobacion[]" class="form-control" id="">
                                    <option value="aprobado" >aprobado</option>
                                    <option value="rechazado">rechazado</option>
                                    <option value="pendiente" selected>pendiente</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12 text-center" id="guardar">
                    <div class="form-group">
                        <input name="_token" value="{{csrf_token()}}" type="hidden">
                        <button class="btn btn-success " type="submit" id="btn_enviar">Enviar <i class="fa fa-send-o"></i></button>
                       <span class=""><button class="btn btn-danger " id="btn_cancelar" type="reset" >Cancelar</button></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!!Form::close()!!}

    @push('scripts')
        <script>
            $(document).ready(function () {
                $("#btn_enviar").hide();
                $("#btn_cancelar").hide();

                var nfilas = $("#tabla_persona tr").length -1;

                if ( nfilas > 0)
                {
                    $("#btn_enviar").show();
                    $("#btn_cancelar").show();
                }

            })
        </script>
    @endpush

@endsection



