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
            <h3>Tiendas
                    <a href="{{url('teamleaders/create')}}"><button class="btn btn-success">Nuevo Teamleader <i class="fa fa-user-plus" aria-hidden="true"></i></button></a></h3>
        </div>
    </div>

    <div class="row text-uppercase">

        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
            @include('tiendas.teamleaders.search')
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center" style="background-color: #2ab27b">
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>CH</th>
                        <th>Tiendas</th>
                        <th class="text-center">OPC</th>

                    </thead>
                    @foreach ($teamleaders as $teamleader)
                        <tr class="text-uppercase text-sm">
                            <td>{{$teamleader->id}}</td>
                            <td>{{$teamleader->nombre}}</td>
                            <td>{{$teamleader->ch}}</td>
                            <td>@foreach($teamleader->tiendas as $tienda)
                                    {{$tienda->tienda_nombre}} -
                                @endforeach
                            </td>
                            <td><a href="{{URL::action('TeamleaderController@edit', $teamleader->id)}}">
                                    <button class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></button</a></td>
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
