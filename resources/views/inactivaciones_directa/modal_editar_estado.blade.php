<div class="modal fade modal-slide-in-right" aria-hidden="true"
     role="dialog" tabindex="-1" id="modal-inactivacion_estado-update-{{$persona->id_nomina}}">
    {{Form::Open(array('action'=>array('InactivacionesDirectaController@updateEstado', $persona->id_nomina),'method'=>'patch'))}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title text-blue">Cambio de Estado de Inactivación: {{$persona->personaDirecta->nombre}}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="text-blue">Estado</label>
                    <select class="form-control" id="estado_inactivacion" name="estado_inactivacion">
                        @if($persona->estado_inactivacion=='aprobado')
                            <option value="aprobado" selected >Aprobado</option>
                            <option value="rechazado">rechazado</option>
                            <option value="pendiente">pendiente</option>
                        @elseif($persona->estado_inactivacion=='rechazado')
                            <option value="aprobado"  >Aprobado</option>
                            <option value="rechazado" selected>rechazado</option>
                            <option value="pendiente">pendiente</option>
                        @endif

                    </select>
                </div>

                <div class="form-group">
                    <label class="text-blue">comentarios</label>
                    <textarea name="comentario_inactivacion" required  class="form-control" placeholder="detalles de la inactivación" rows="2">{{$persona->estado_inactivacion=='aprobado' ? $persona->comentario_inactivacion : $persona->motivo_rechazo_inactivacion}}</textarea>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-warning">Confirmar</button>
            </div>
        </div>
    </div>
    {{Form::Close()}}

</div>
