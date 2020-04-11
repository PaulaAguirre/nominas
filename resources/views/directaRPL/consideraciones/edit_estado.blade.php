<div class="modal fade modal-slide-in-right" aria-hidden="true"
     role="dialog" tabindex="-1" id="modal-nomina-update-{{$persona->id_nomina}}">
    {{Form::Open(array('action'=>array('ConsideracionDirectaRPLController@updateEstado', $persona->id_nomina),'method'=>'patch'))}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title text-blue">Cambio de Estado: {{$persona->personaDirecta->nombre}}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="text-blue">Estado</label>
                    <select class="form-control aprobacion" id="aprobacion-{{$persona->id_nomina}}" name="estado_consideracion">
                        @if($persona->estado_consideracion=='aprobado')
                            <option value="aprobado" selected >Aprobado</option>
                            <option value="rechazado">rechazado</option>
                            <option value="pendiente">pendiente</option>
                        @elseif($persona->estado_consideracion=='rechazado')
                            <option value="aprobado"  >Aprobado</option>
                            <option value="rechazado" selected>rechazado</option>
                            <option value="pendiente">pendiente</option>
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label class="text-blue">porcentaje</label>
                    <select class="form-control text-uppercase " name="objetivo" id="objetivo-{{$persona->id_nomina}}">
                        @foreach($porcentajes as $porcentaje)
                            @if($persona->porcentaje_id == $porcentaje->id)
                                <option value="{{$porcentaje->id.'-'.$porcentaje->porcentaje}}" selected>{{$porcentaje->nombre.' - OBJ:'.$porcentaje->porcentaje}}</option>
                            @else
                                <option value="{{$porcentaje->id.'-'.$porcentaje->porcentaje}}" >{{$porcentaje->nombre.' - OBJ:'.$porcentaje->porcentaje}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>



                <div class="form-group">
                    <label class="text-blue">comentarios</label>
                    <input type="text" name="comentario_consideracion" required value="{{$persona->estado_consideracion=='aprobado' ? $persona->comentario_consideracion : $persona->motivo_rechazo_consideracion}}" class="form-control" placeholder="detalles de la inactivación">
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-warning">Confirmar</button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('.aprobacion').change(function(){
                    var id = $(this).prop('id').split('-')[1];
                    if ($(this).val()=='rechazado')
                    {
                        $("#objetivo-"+id).hide();

                    }
                    else if ($(this).val()=='aprobado')
                    {
                        $("#objetivo-"+id).show();
                    }
                    else
                    {

                        $("#objetivo-"+id).hide();
                    }

                });

            })
        </script>
    @endpush
    {{Form::Close()}}

</div>
