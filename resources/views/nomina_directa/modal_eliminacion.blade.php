<div class="modal fade modal-slide-in-right" aria-hidden="true"
     role="dialog" tabindex="-1" id="modal-nomina-delete-{{$persona->id_persona_directa}}">
    {{Form::Open(array('action'=>array('NominaDirectaController@destroy', $persona->id_persona_directa),'method'=>'delete'))}}
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

                <label class="text-danger">Motivo</label>
                <input type="text" name="motivo_inactivacion" required value="{{old('motivo_inactivacion')}}" class="form-control" placeholder="motivos de la inactivación">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-warning">Confirmar</button>
            </div>
        </div>
    </div>
    {{Form::Close()}}

</div>
