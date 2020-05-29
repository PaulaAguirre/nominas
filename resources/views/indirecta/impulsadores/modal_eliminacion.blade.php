<div class="modal fade modal-slide-in-right" aria-hidden="true"
     role="dialog" tabindex="-1" id="modal-nomina-delete-{{$impulsador->id}}">
    {{Form::Open(array('action'=>array('ImpulsadorController@destroy', $impulsador->id),'method'=>'delete', 'enctype'=>'multipart/form-data'))}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title text-danger">Inactivar Asesor: {{$impulsador->impulsador ? $impulsador->impulsador->nombre : ''}}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="text-danger">Motivo</label>
                    <select class="form-control" id="motivo_inactivacion" name="motivo_inactivacion">
                        <option value="renuncia" selected>Renuncia</option>
                        <option value="desvinculacion">Desvinculacion</option>
                        <option value="cambio de canal">Cambio de Canal</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="text-danger">Detalles de la inactivación</label>
                    <textarea rows="2" name="detalles_inactivacion" required value="{{old('detalles_inactivacion')}}" class="form-control" placeholder="detalles de la inactivación"></textarea>
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
