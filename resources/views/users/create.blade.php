@extends ('layouts.admin_tienda')
@section ('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Nuevo usuario</h3>
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
    {!!Form::open(array('url'=>'users','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
    <div class="row">
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control text-uppercase" placeholder="Nombre y Apellido">
            </div>
        </div>

        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="nombre">email</label>
                <input type="text" name="email" required value="{{old('email')}}" class="form-control" placeholder="user@tigo.net.py">
            </div>
        </div>

        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="role">Rol</label>
                <select name="role" class="form-control text-uppercase" id="role" title="Seleccione un rol" data-live-search="true">
                    @foreach($roles as $role)
                        <option value="{{$role->id}}">{{strtoupper ($role->nombre)}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label>Canal</label>
                <select name="canal" class="form-control text-uppercase" style="display: none;" id="canal" title="Seleccione un canal" data-live-search="true">
                    @foreach($canales as $canal)
                        <option value="{{$canal->id}}">{{strtoupper ($canal->canal)}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="panel panel-default col-lg-6" style="display: none">
            <div class="panel-heading text-bold"><span class="">Zonas Directa</span></div>
            <div class="panel-body text-uppercase">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover" >
                        <thead class="text-center" >
                            <th>ID</th>
                            <th>Zona</th>
                            <th class="text-center">Agregar</th>
                        </thead>
                        @foreach($zonas_directa as $zona)
                            <tr class="text-uppercase">
                                <td>{{$zona->id}}</td>
                                <td>{{$zona->zona}}</td>
                                <td class="text-center"><input type="checkbox" value="{{$zona->id}}" name="zona_id[]"></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-default col-lg-6" style="display: none" id="tabla_tiendas">
            <div class="panel-heading text-bold"><span class="">Zonas Tienda</span></div>
            <div class="panel-body text-uppercase">
                <table class="table table-striped table-bordered table-condensed table-hover" >
                    <thead class="text-center" >
                    <th>ID</th>
                    <th>Zona</th>
                    <th>Agregar</th>
                    </thead>
                    @foreach($zonas_tienda as $zona)
                        <tr class="text-uppercase">
                            <td>{{$zona->id}}</td>
                            <td>{{$zona->zona}}</td>
                            <td class="text-center"><input type="checkbox" value="{{$zona->id}}" name="zona_id[]"></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    {{Form::close()}}
    @push('scripts')
        <script>
            $(document).ready(function () {

                $("#role").click(function () {
                    if($(this).val() == 1){
                        $("#canal").show();
                    }
                    else
                    {
                        $("#canal").hide();
                    }
                })

                $("#canal").click(function () {
                    if($("#canal").val() == 3)
                    {
                        $("#tabla_tiendas").show();
                    }
                    else
                    {
                        $("#tabla_tiendas").hide();
                    }
                })


            })
        </script>
    @endpush
@endsection
