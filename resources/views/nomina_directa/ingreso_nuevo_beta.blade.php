@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Ingresar Asesor - Mes: 2019-11</h3>
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

    {!!Form::open(array('url'=>'ingresar_nuevo_asesor','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}


    <div class="row">
        <div class="panel panel-primary col-lg-10">
            <div class="panel-body col-lg-offset-2" style="">
                <div class="row col-lg-8 col-sm-8 col-md-8 col-xs-8">
                    <div class="form-inline ">
                        <select name="pidrepresentante" class="selectpicker text-uppercase col-lg-8" id="pidrepresentante" title="Seleccione un Asesor" data-live-search="true">
                            @foreach($personas_a_ingresar as $persona)
                                <option value="{{$persona}}">{{strtoupper ($persona->ch)}} - {{$persona->nombre}}</option>
                            @endforeach
                        </select>
                        <button type="button" id="bt_add" class="btn btn-primary ">Agregar</button>
                    </div>
                </div>
                <br>
                <br>

                <div class="col-lg-8 col-sm-8 col-md-8 col-xs-8">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                        <thead style="background-color: #8eb4cb">
                        <th>Opciones</th>
                        <th>Nombre</th>
                        </thead>
                        <tbody class="text-uppercase">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-8" id="guardar">
            <div class="form-group">
                <input name="_token" value="{{csrf_token()}}" type="hidden">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
        </div>
    </div>
    {!!Form::close()!!}

    @push('scripts')
        <script>
            $(document).ready(function(){
                $('#bt_add').click(function () {
                    agregar();
                    limpiar()
                })
            })
            var cont = 0;
            $("#guardar").hide();

            function agregar() {
                idrepresentante = $("#pidrepresentante").val();
                representante = $("#pidrepresentante option:selected").text();
                if(idrepresentante!=""){
                    var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idrepresentante[]" value="'+idrepresentante+'">'+representante+'</td></tr>'
                    cont++;
                    $('#detalles').append(fila);
                    $('#guardar').show();

                }
                else{
                    $("#guardar").hide();
                    alert("Error al agregar Asesor");
                }


            }

            function eliminar(index) {
                $("#fila"+index).remove();
            }

        </script>
    @endpush
@endsection
