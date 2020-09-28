@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading text-bold"><span class="text-info">Descargar Nómina</span></div>

                    <div class="panel-body text-uppercase">


                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed table-hover">
                                    <thead class="text-center" style="background-color: #8eb4cb">
                                        <th class="col-lg-3">Mes</th>
                                        <th class="col-lg-1">Directa</th>
                                        <th class="col-lg-1 ">Tiendas</th>
                                        <th class="col-lg-1 ">Indirecta</th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th>Enero 2020</th>
                                        <th class="text-center"><a href="{{URL::asset('img/directa/cierre_enero.xlsx')}}">
                                                <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>
                                            </a>
                                        </th>
                                        <th class="text-center"><a href="{{URL::asset('img/cierre_enero.xlsx')}}">
                                                <button class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>
                                            </a>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Febrero 2020</th>
                                        <th class="text-center"><a href="{{URL::asset('img/directa/cierre_febrero_2020.xlsx')}}">
                                                <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>
                                            </a>
                                        </th>
                                        <th class="text-center"><a href="{{URL::asset('img/tiendas/cierre febrero 2020 tiendas.xlsx')}}">
                                                <button class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>
                                            </a>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>marzo 2020</th>
                                        <th class="text-center"><a href="{{URL::asset('img/directa/cierre_marzo_2020.xlsx')}}">
                                                <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>

                                            </a>
                                        </th>
                                        <th class="text-center"><a href="{{URL::asset('img/tiendas/cierre_marzo_2020.xlsx')}}">
                                                <button class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>
                                            </a>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Abril 2020</th>
                                        <th class="text-center"><a href="{{URL::asset('img/directa/cierre_abril_directa_2020.xlsx')}}">
                                                <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>

                                            </a>
                                        </th>
                                        <th class="text-center"><a href="{{URL::asset('img/tiendas/cierre_abril.xlsx')}}">
                                                <button class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>
                                            </a>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Mayo 2020</th>
                                        <th class="text-center"><a href="{{URL::asset('img/directa/cierre final mayo.xlsx')}}">
                                                <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>

                                            </a>
                                        </th>
                                        <th class="text-center"><a href="{{URL::asset('img/tiendas/cierre final mayo.xlsx')}}">
                                                <button class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>
                                            </a>
                                        </th>
                                    </tr>

                                    <tr>
                                        <th>Junio 2020</th>
                                        <th class="text-center"><a href="{{URL::asset('img/directa/cierre_junio_2020.xlsx')}}">
                                                <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>

                                            </a>
                                        </th>
                                        <th class="text-center"><a href="{{URL::asset('img/tiendas/cierre_junio_2020.xlsx')}}">
                                                <button class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>
                                            </a>
                                        </th>
                                    </tr>

                                    <tr>
                                        <th>Julio 2020</th>
                                        <th class="text-center"><a href="{{URL::asset('img/directa/cierre_julio_2020.xlsx')}}">
                                                <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>

                                            </a>
                                        </th>
                                        <th class="text-center"><a href="{{URL::asset('img/tiendas/cierre_julio_2020.xlsx')}}">
                                                <button class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>
                                            </a>
                                        </th>

                                        <th class="text-center"><a href="{{URL::asset('img/indirecta/nomina_indirecta_julio.xlsx')}}">
                                                <button class="btn btn-yahoo btn-xs" data-toggle="tooltip" data-placement="top" title="descargar Nomina"><i class="fa fa-download"></i></button>
                                            </a>
                                            <a href="{{URL::asset('img/indirecta/pdas_julio.xlsx')}}">
                                                <button class="btn btn-yahoo btn-xs" data-toggle="tooltip" data-placement="top" title="descargar PDV"><i class="fa fa-download"></i></button>
                                            </a>
                                        </th>
                                    </tr>

                                    <tr>
                                        <th>Agosto 2020</th>
                                        <th class="text-center"><a href="{{URL::asset('img/directa/cierre_agosto_2020.xlsx')}}">
                                                <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>

                                            </a>
                                        </th>
                                        <th class="text-center"><a href="{{URL::asset('img/tiendas/cierre_agosto_tiendas_2020.xlsx')}}">
                                                <button class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>
                                            </a>
                                        </th>

                                        <th class="text-center"><a href="{{URL::asset('img/indirecta/nomina_indirecta_agosto.xlsx')}}">
                                                <button class="btn btn-yahoo btn-xs" data-toggle="tooltip" data-placement="top" title="descargar Nomina"><i class="fa fa-download"></i></button>
                                            </a>
                                            <a href="{{URL::asset('img/indirecta/pdas_agosto.xlsx')}}">
                                                <button class="btn btn-yahoo btn-xs" data-toggle="tooltip" data-placement="top" title="descargar PDV"><i class="fa fa-download"></i></button>
                                            </a>

                                            <a href="{{URL::asset('img/indirecta/auditores_agosto.xlsx')}}">
                                                <button class="btn btn-yahoo btn-xs" data-toggle="tooltip" data-placement="top" title="descargar Auditores"><i class="fa fa-download"></i></button>
                                            </a>
                                        </th>
                                    </tr>


                                    <tr>
                                        <th>setiembre 2020</th>
                                        <th class="text-center"><a href="{{URL::asset('/excel_directa_mes_anterior')}}">
                                                <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>

                                            </a>
                                        </th>
                                        <th class="text-center"><a href="{{url('/excel_tienda_rpl')}}">
                                                <button class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>
                                            </a>
                                        </th>

                                        <th class="text-center"><a href="{{url('/excel_indirecta')}}">
                                                <button class="btn btn-yahoo btn-xs" data-toggle="tooltip" data-placement="top" title="descargar Nomina"><i class="fa fa-download"></i></button>
                                            </a>
                                            <a href="{{url('/pdas_indirecta')}}">
                                                <button class="btn btn-yahoo btn-xs" data-toggle="tooltip" data-placement="top" title="descargar PDV"><i class="fa fa-download"></i></button>
                                            </a>
                                            <a href="{{url('/circuitos_auditores')}}">
                                                <button class="btn btn-yahoo btn-xs" data-toggle="tooltip" data-placement="top" title="descargar Auditores"><i class="fa fa-download"></i></button>
                                            </a>
                                        </th>
                                    </tr>

                                    <tr>
                                        <th>Octubre 2020</th>
                                        <th class="text-center"><a href="{{URL::asset('/excel')}}">
                                                <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>

                                            </a>
                                        </th>
                                        <th class="text-center"><a href="{{url('/excel_tienda')}}">
                                                <button class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>
                                            </a>
                                        </th>

                                        <th class="text-center"><a href="{{url('/excel_indirecta')}}">
                                                <button class="btn btn-yahoo btn-xs" data-toggle="tooltip" data-placement="top" title="descargar Nomina"><i class="fa fa-download"></i></button>
                                            </a>
                                            <a href="{{url('/pdas_indirecta')}}">
                                                <button class="btn btn-yahoo btn-xs" data-toggle="tooltip" data-placement="top" title="descargar PDV"><i class="fa fa-download"></i></button>
                                            </a>
                                            <a href="{{url('/circuitos_auditores')}}">
                                                <button class="btn btn-yahoo btn-xs" data-toggle="tooltip" data-placement="top" title="descargar Auditores"><i class="fa fa-download"></i></button>
                                            </a>
                                        </th>
                                    </tr>
                                    </tbody>

                                </table>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
