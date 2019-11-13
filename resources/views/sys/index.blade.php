@extends('layouts.app2')

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
                    <div class="panel-heading text-bold"><span class="text-info">SELECCIONE CANAL</span></div>

                    <div class="panel-body text-uppercase">

                        <div class="form-group text-center col-md-offset-3 col-md-6">
                            <br>
                           <a href="{{url('nomina_directa')}}">
                               <button class="btn btn-block btn-facebook">DIRECTA</button>
                           </a>
                            <br>
                            <a>
                                <button class="btn btn-block btn-success">TIENDAS</button>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
