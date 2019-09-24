<div class="modal fade modal-slide-in-right" aria-hidden="true"
     role="dialog" tabindex="-1" id="modal-consideracion-update-{{$persona->id_nomina}}">
    {{Form::Open(array('action'=>array('ConsideracionesDirectaController@updateConsideracion', $persona->id_nomina),'files'=>true,'method'=>'patch'))}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title text-blue">Editar Consideración: {{$persona->personaDirecta->nombre}}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="text-blue">Consideración</label>
                    <select class="form-control" id="id_consideracion" name="id_consideracion">
                        @foreach($consideraciones as $consideracion)
                            @if ($consideracion->id==$persona->id_consideracion)
                                <option value="{{$consideracion->id}}" selected>{{strtoupper ($consideracion->nombre)}}</option>
                            @else
                                <option value="{{$consideracion->id}}">{{strtoupper ($consideracion->nombre)}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="text-blue">comentarios</label>
                    <input  type="text" name="detalles_consideracion" required value="{{$persona->detalles_consideracion}}" class="form-control text-uppercase" placeholder="detalles de la inactivación">
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
