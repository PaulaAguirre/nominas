@extends ('layouts.admin_tienda')
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
            <h3>Representantes Canal Tiendas (todas las zonas)
                    <a href="asesores_tienda/create"><button class="btn btn-success">Nuevo Asesor  <i class="fa fa-user-plus" aria-hidden="true"></i></button></a></h3>
        </div>
    </div>
    @include('tiendas.asesores.search_index')
    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center" style="background-color: #2ab27b">
                        <th>ID</th>
                        <th>CH</th>
                        <th>Nombre</th>
                        <th>Staff</th>
                        <th>CI</th>
                        <th>Jefe Zonal</th>
                        <th>Jefe Tienda</th>
                        <th>Team Leader</th>
                        <th>Zona</th>
                        <th>Tienda</th>
                        <th>Estado</th>
                        <th class="text-center">Opciones</th>

                    </thead>
                    @foreach ($asesores as $asesor)
                        <tr class="text-uppercase text-sm">
                            <td>{{$asesor->id}}</td>
                            <td>{{$asesor->ch}}</td>
                            <td>{{$asesor->nombre}}</td>
                            <td>{{$asesor->staff}}</td>
                            <td>{{$asesor->documento}}</td>
                            <td>{{$asesor->zonaTienda($asesor->id)->representante_zonal_nombre}}</td>
                            <td>{{$asesor->tienda->jefetienda ? $asesor->tienda->jefetienda->nombre : 'sin jefe'}}</td>
                            <td>{{$asesor->teamleader->nombre}}</td>
                            <td>{{$asesor->zonaTienda($asesor->id)->zona}}</td>
                            <td>{{$asesor->tienda->tienda_nombre}}</td>
                            <td>{{$asesor->activo}}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </table>
            </div>
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
