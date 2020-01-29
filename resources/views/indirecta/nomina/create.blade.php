@extends ('layouts.admin_indirecta')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <h3>Nueva Nomina Tiendas - <span class="text-success">Mes: {{$mes_nomina}}</span> </h3>
            @include('indirecta.nomina.search_create')
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

    {!!Form::open(array('url'=>'nomina_indirecta','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}

        <div class="row text-uppercase">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover" id="tabla_persona">
                        <thead class="text-center text-gray" style="background-color: #5d59a6">
                        <th>Zona</th>
                        <th>Rep Zonal</th>
                        <th>Coordinador</th>
                        <th>CH</th>
                        <th>Representante</th>
                        </thead>
                        @foreach ($impulsadores as $impulsador)
                            <tr class="text-uppercase">
                                <td>{{$impulsador->zona ? $impulsador->zona->nombre : ''}}</td>
                                <td>{{$impulsador->zona ? $impulsador->zona->representante_zonal_nombre : ''}}</td>
                                <td>{{$impulsador->coordinador ? $impulsador->coordinador->nombre : ''}}</td>
                                <td>{{$impulsador->ch}}</td>
                                <td><input type="hidden" name="impulsador_id[]" value="{{$impulsador->id}}">
                                    <input type="hidden" name="impulsador_mes[]" id="impulsador_mes" value="{{$impulsador->id.$mes_nomina}}">{{$impulsador->nombre}}</td>
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



