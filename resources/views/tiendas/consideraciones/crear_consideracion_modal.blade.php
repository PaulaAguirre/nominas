<div class="modal fade modal-slide-in-right" aria-hidden="true"
     role="dialog" tabindex="-1" id="modal-consideracion-store-{{$asesor->id}}">
    {!!Form::model ($asesor, ['method'=>'PATCH','files'=>true, 'route'=>['asesores_tienda.consideracion', $asesor]])!!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title text-blue">Agregar Consideración: {{$asesor->asesor->nombre}}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="text-blue">Consideración</label>
                    <select class="form-control" id="id_consideracion" name="id_consideracion">
                        @foreach($consideraciones as $consideracion)
                                <option value="{{$consideracion->id}}">{{strtoupper ($consideracion->nombre ? $consideracion->nombre : '')}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="text-blue">comentarios</label>
                    <textarea name="detalles_consideracion" required value="" placeholder="detalles de la consideración" class="form-control text-uppercase"></textarea>
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
