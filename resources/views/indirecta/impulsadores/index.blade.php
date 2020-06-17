@extends ('layouts.admin_indirecta')
@section ('contenido')
    <style>
        table tr th {
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .sorting {
            background-color: #D4D4D4;
        }

        .asc:after {
            content: ' ↑';
        }

        .desc:after {
            content: " ↓";
        }
    </style>

    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Representantes Asesores Indirecta(todas las zonas)</h3>
        </div>
    </div>

    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @include('indirecta.impulsadores.search_index')
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center text-gray" style="background-color:#5d59a6">
                        <th>ID</th>
                        <th>CH</th>
                        <th>Nombre</th>
                        <th>Clasificación</th>
                        <th>CI</th>
                        <th>Jefe Zonal</th>
                        <th>Coordinador</th>
                        <th>Estado</th>
                        <th class="text-center">OPC</th>

                    </thead>
                    @foreach ($impulsadores as $impulsador)
                        <tr class="text-uppercase text-sm">
                            <td>{{$impulsador->id}}</td>
                            <td>{{$impulsador->ch}}</td>
                            <td>{{$impulsador->nombre}}</td>
                            <td>{{$impulsador->clasificacion ? $impulsador->clasificacion->nombre : ''}}</td>
                            <td>{{$impulsador->documento}}</td>
                            <td>{{$impulsador->zona->representante_zonal_nombre.' - '.$impulsador->zona->nombre}}</td>
                            <td>{{$impulsador->coordinador ? $impulsador->coordinador->nombre : ''}}</td>
                            <td>{{$impulsador->activo}}</td>
                            <td>
                                @if(auth()->user()->hasRoles(['zonal']) and (\Carbon\Carbon::today() < (new Carbon\Carbon('first day of this month'))->addDay(19)))

                                    <a href="{{URL::action('ImpulsadorController@edit', $impulsador->id)}}">
                                        <button class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Datos del Asesor"><i class="fa fa-pencil"></i></button></a>
                                @else
                                    <a href="{{URL::action('ImpulsadorController@edit', $impulsador->id)}}">
                                        <button class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Datos del Asesor"><i class="fa fa-pencil"></i></button>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>

            </div>
            {{$impulsadores->render()}}
        </div>
    </div>

    @push('scripts')
        <script>

            $('th').click(function() {
                var table = $(this).parents('table').eq(0)
                var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
                this.asc = !this.asc
                if (!this.asc) {
                    rows = rows.reverse()
                }
                for (var i = 0; i < rows.length; i++) {
                    table.append(rows[i])
                }
                setIcon($(this), this.asc);
            })

            function comparer(index) {
                return function(a, b) {
                    var valA = getCellValue(a, index),
                        valB = getCellValue(b, index)
                    return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
                }
            }

            function getCellValue(row, index) {
                return $(row).children('td').eq(index).html()
            }

            function setIcon(element, asc) {
                $("th").each(function(index) {
                    $(this).removeClass("sorting");
                    $(this).removeClass("asc");
                    $(this).removeClass("desc");
                });
                element.addClass("sorting");
                if (asc) element.addClass("asc");
                else element.addClass("desc");
            }jquery.tablesorter.js
        </script>
    @endpush

@endsection
