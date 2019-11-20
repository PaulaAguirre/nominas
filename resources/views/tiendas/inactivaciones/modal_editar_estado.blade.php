<div class="modal fade modal-slide-in-right" aria-hidden="true"
     role="dialog" tabindex="-1" id="modal-inactivacion_estado-update-{{$asesor->id}}">
    {{Form::Open(array('action'=>array('InactivacionTiendaController@updateEstado', $asesor->id),'method'=>'patch'))}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title text-blue">Cambio de Estado de Inactivación: {{$asesor->asesor->nombre}}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="text-blue">Estado</label>
                    <select class="form-control aprobacion" id="aprobacion-{{$asesor->id}}" name="estado_inactivacion">
                        @if($asesor->estado_inactivacion=='aprobado')
                            <option value="aprobado" selected >Aprobado</option>
                            <option value="rechazado">rechazado</option>
                            <option value="pendiente">pendiente</option>
                        @elseif($asesor->estado_inactivacion=='rechazado')
                            <option value="aprobado"  >Aprobado</option>
                            <option value="rechazado" selected>rechazado</option>
                            <option value="pendiente">pendiente</option>
                        @endif

                    </select>
                </div>
                <div class="form-group">
                    <label class="text-blue">porcentaje</label>
                    <select class="form-control text-uppercase " name="objetivo[]" id="objetivo-{{$asesor->id}}">
                        @foreach($porcentajes as $porcentaje)
                            @if($asesor->porcentaje_objetivo == $porcentaje)
                                <option value="{{$porcentaje}}" selected>{{$porcentaje}}</option>
                            @else
                                <option value="{{$porcentaje}}" >{{$porcentaje}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="text-blue">comentarios</label>
                    <textarea name="comentario_inactivacion" required  class="form-control" placeholder="detalles de la inactivación" rows="2">{{$asesor->estado_inactivacion=='aprobado' ? $asesor->comentario_inactivacion : $asesor->motivo_rechazo_inactivacion}}</textarea>
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
