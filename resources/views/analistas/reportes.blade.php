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
            <div class="col-md-7 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading text-bold"><span class="text-info">Descargar Nómina</span></div>

                    <div class="panel-body text-uppercase">


                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed table-hover">
                                    <thead class="text-center" style="background-color: #8eb4cb">
                                        <th>Mes</th>
                                        <th>Canal</th>
                                        <th class="col-lg-1 ">descargar</th>
                                    </thead>
                                    <tr class="text-uppercase text-sm">
                                        <td>Febero 2020</td>
                                        <td>Directa</td>
                                        <td class="text-center"><a href="{{URL::asset('excel')}}">
                                                <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="text-uppercase text-sm">
                                        <td>Febero 2020</td>
                                        <td>Tiendas</td>
                                        <td class="text-center"><a href="{{URL::asset('excel_tienda')}}">
                                                <button class="btn btn-facebook btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
