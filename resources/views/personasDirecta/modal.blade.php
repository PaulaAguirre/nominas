<div class="modal fade modal-slide-in-right" aria-hidden="true"
     role="dialog" tabindex="-1" id="modal-delete-{{$persona->id_persona}}">
    {{Form::Open(array('action'=>array('PersonaDirectaController@destroy', $persona->id_persona),'method'=>'delete'))}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"><span class="text-danger">Inactivar Asesor:</span></h4>
            </div>
            <div class="modal-body">
                <p>Confirme si desea Inactivar al Representante:</p>
                <p><span class="text-bold">{{$persona->nombre}}</span>  CH: {{$persona->ch}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
    </div>
    {{Form::Close()}}

</div>
