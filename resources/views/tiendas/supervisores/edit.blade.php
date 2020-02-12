@extends ('layouts.admin_tienda')
@section ('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Supervisor: {{$supervisor->nombre}}  </h3>
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

    {!!Form::model ($supervisor, ['method'=>'PATCH', 'route'=>['supervisores_tienda.update', $supervisor]])!!}
    {{Form::token()}}
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading text-bold"><span class="text-green">Editar Supervisor</span></div>

                    <div class="panel-body text-uppercase">
                        {!!Form::model ($supervisor, ['method'=>'PATCH', 'route'=>['supervisores_tienda.update', $supervisor]])!!}
                        {{Form::token()}}

                        <input type="hidden" name="url" value="{{URL::previous ()}}">

                        <div class="form-group ">
                            <label for="name">CH</label>
                            <input type="number" name="ch"  value="{{$supervisor->ch}}" class="form-control text-uppercase">
                        </div>


                        <div class="form-group ">
                            <div class="">
                                <label for="name">Documento</label>
                                <input type="number" name="documento" value="{{$supervisor->documento}}" class="form-control text-uppercase">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" required value="{{$supervisor->nombre}}" class="form-control text-uppercase" placeholder="APELLIDOS, NOMBRES">
                        </div>


                        <div class="form-group text-center">
                            <br>
                            <input name="_token" value="{{csrf_token()}}" type="hidden">
                            <button class="btn btn-primary" type="submit">Guardar</button>
                            <button class="btn btn-danger" type="reset">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!!Form::close()!!}
    </div>

@endsection
