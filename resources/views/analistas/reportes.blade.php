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
                                        <th class="text-center"><a href="{{URL::asset('excel')}}">
                                                <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>

                                            </a>
                                        </th>
                                        <th class="text-center"><a href="{{URL::asset('excel_tienda')}}">
                                                <button class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>
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
