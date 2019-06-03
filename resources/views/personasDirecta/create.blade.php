@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Agregar Representante</h3>
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

    {!!Form::open(array('url'=>'representantes_directa','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}

    <div class="row">

        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="memo">Código Humano</label>
                <input type="number" name="ch"  value="{{old('ch')}}" class="form-control text-uppercase" placeholder="ej: 69xxx">
            </div>
        </div>

        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <label for="numero">Nro de  cédula</label>
                <input type="number" name="documento_persona"  value="{{old('documento_persona')}}" class="form-control text-uppercase" placeholder="nro de ci">
            </div>
        </div>

        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre"  value="{{old('nombre')}}" class="form-control text-uppercase" placeholder="Nombre">
            </div>
        </div>

        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="">Cargo</label>
                <select name="cargo" class="form-control" title="hola" required>
                    <option value="representante">Representante</option>
                    <option value="representante jefe" >Representante Jefe</option>
                    <option value="representante zonal">Representante Zonal</option>
                </select>
            </div>
        </div>

        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="monto">Monto Contractual</label>
                <input type="number" name="monto_contractual" required value="{{old('monto_contractual')}}" class="form-control text-uppercase" placeholder="monto contractual">
            </div>
        </div>

        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="monto">Monto cheque</label>
                <input type="number" name="monto_cheque" required value="{{old('monto_cheque')}}" class="form-control text-uppercase" placeholder="monto total">
            </div>
        </div>


        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="monto">Monto Factura</label>
                <input type="number" name="monto_factura" required value="{{old('monto_factura')}}" class="form-control text-uppercase" placeholder="monto factura">
            </div>
        </div>


        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="monto">Monto Acumulado</label>
                <input type="number" name="monto" required value="{{old('monto')}}" class="form-control text-uppercase" placeholder="monto total">
            </div>
        </div>

    </div>

    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12" id="guardar">
        <div class="form-group text-center">
            <input name="_token" value="{{csrf_token()}}" type="hidden">
            <button class="btn btn-primary" type="submit">Guardar</button>

            <button class="btn btn-danger" type="reset">Cancelar</button>

        </div>
    </div>
    {!!Form::close()!!}

@endsection

