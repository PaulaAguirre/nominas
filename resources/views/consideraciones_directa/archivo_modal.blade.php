<div class="modal fade modal-slide-in-right" aria-hidden="true"
     role="dialog" tabindex="-1" id="modal-delete-{{$persona->id_persona_directa}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"><span class="text-danger"> {{'Asesor: '.$persona->personaDirecta->nombre.' - '.'CH: '.$persona->personaDirecta->ch}}</span></h4>
            </div>
            <div class="modal-body">
                <img style="width: 200px" src={{ asset('storage/'.$persona->archivos->pluck('nombre')->first()) }}>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>

</div>
