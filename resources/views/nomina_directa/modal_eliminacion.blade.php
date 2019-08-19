<div class="modal fade modal-slide-in-right" aria-hidden="true"
     role="dialog" tabindex="-1" id="modal-nomina-delete-{{$persona->id_nomina}}">
    {{Form::Open(array('action'=>array('NominaDirectaController@destroy', $persona->id_nomina),'method'=>'delete'))}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title text-danger">Inactivar Asesor: {{$persona->personaDirecta->nombre}}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="text-danger">Motivo</label>
                    <select class="form-control" id="motivo_inactivacion" name="motivo_inactivacion">
                        <option value="renuncia" selected>Renuncia</option>
                        <option value="desvinculacion">Desvinculacion</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="text-danger">Detalles de la inactivación</label>
                    <input type="text" name="detalles_inactivacion" required value="{{old('detalles_inactivacion')}}" class="form-control" placeholder="detalles de la inactivación">
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