@extends ('layouts.admin_tienda')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <h3>Nueva Nomina Tiendas - <span class="text-success">Mes: {{$mes_nomina}}</span> </h3>
            @include('tiendas.nomina.search_create')
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

    {!!Form::open(array('url'=>'nomina_tienda','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}

        <div class="row text-uppercase">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_persona">
                        <thead class="text-center" style="background-color: #2ab27b">
                        <th>Zona</th>
                        <th>Rep Zonal</th>
                        <th>Jefe Tienda</th>
                        <th>CH</th>
                        <th>Representante</th>
                        </thead>
                        @foreach ($asesores as $asesor)
                            <tr class="text-uppercase">
                                <td>{{$asesor->tienda->zona ? $asesor->tienda->zona->zona : ''}}</td>
                                <td>{{$asesor->tienda->zona ? $asesor->tienda->zona->representante_zonal_nombre : ''}}</td>
                                <td>{{$asesor->tienda->jefetienda ? $asesor->tienda->jefetienda->nombre : ''}}</td>
                                <td>{{$asesor->ch}}</td>
                                <td><input type="hidden" name="id_asesor[]" value="{{$asesor->id}}">
                                    <input type="hidden" name="asesor_mes[]" id="persona_mes" value="{{$asesor->id.$mes_nomina}}">{{$asesor->nombre}}</td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12 text-center" id="guardar">
                         <div class="form-group">
                            <input name="_token" value="{{csrf_token()}}" type="hidden">
                             <button class="btn btn-primary" type="submit">Generar</button>
                             <button id="btn_cancelar" class="btn btn-danger" type="reset">Cancelar</button>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    {!!Form::close()!!}

    @push('scripts')
        <script>
            $(document).ready(function () {
                $("#btn_generar").hide();
                $("#btn_cancelar").hide();

                var nfilas = $("#tabla_persona tr").length -1;

                if ( nfilas > 0)
                {
                    $("#btn_generar").show();
                    $("#btn_cancelar").show();
                }

            })
        </script>
    @endpush

@endsection



