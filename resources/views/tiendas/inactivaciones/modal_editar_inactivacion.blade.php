<div class="modal fade modal-slide-in-right" aria-hidden="true"
     role="dialog" tabindex="-1" id="modal-inactivacion-update-{{$asesor->id}}">
    {{Form::Open(array('action'=>array('InactivacionTiendaController@updateInactivacion', $asesor->id),'method'=>'patch', 'enctype'=>'multipart/form-data'))}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title text-danger">Editar Inactivación: {{$asesor->asesor->nombre}}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="text-danger">Motivo</label>
                    <select class="form-control" id="motivo_inactivacion" name="motivo_inactivacion">
                        @if($asesor->motivo_inactivacion == 'renuncia')
                            <option value="renuncia" selected>Renuncia</option>
                            <option value="desvinculacion">Desvinculacion</option>
                            <option value="cambio de canal">Cambio de Canal</option>
                        @elseif($asesor->motivo_inactivacion == 'desvinculacion')
                            <option value="renuncia" >Renuncia</option>
                            <option value="desvinculacion" selected>Desvinculacion</option>
                            <option value="cambio de canal">Cambio de Canal</option>
                        @else
                            <option value="renuncia" >Renuncia</option>
                            <option value="desvinculacion"> </option>
                            <option value="cambio de canal" selected>Cambio de Canal</option>
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label class="text-danger">Detalles de la inactivación</label>
                    <textarea rows="2" name="detalles_inactivacion" required class="form-control" placeholder="detalles de la inactivación">{{$asesor->detalles_inactivacion}}</textarea>
                </div>

                <div class="form-group">
                    <label for="">adjuntar</label>
                    <input type="file" name="archivo">
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
