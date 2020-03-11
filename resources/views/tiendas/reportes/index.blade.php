@extends ('layouts.admin_tienda')
@section ('contenido')

    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
           <h3>Reportes</h3>
        </div>

    </div>

    <div class="row text-uppercase">

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="text-center" style="background-color: #2ab27b">
                        <th>Mes</th>
                        <th class="col-lg-1 ">descargar</th>

                    </thead>

                        <tr class="text-uppercase text-sm">
                            <th>enero 2020</th>
                            <th class="text-center"><a href="{{URL::asset('img/cierre_enero.xlsx')}}">
                                    <button class="btn btn-dropbox btn-xs" data-toggle="tooltip" data-placement="top" title="descargar"><i class="fa fa-download"></i></button>
                                </a></th>
                        </tr>
                    <tr class="text-uppercase text-sm">
                        <th>febrero 2020</th>
                        <th class="text-center"><a href="{{URL::asset('img/tiendas/cierre febrero 2020 tiendas.xlsx')}}">
                            </a></th>
                    </tr>
                    <tr class="text-uppercase text-sm">
                        <th>marzo 2020</th>
                        <th class="text-center"><a href="">
                            </a></th>
                    </tr>
                    <tr class="text-uppercase text-sm">
                        <th>abril 2020</th>
                        <th class="text-center"><a href="">
                            </a></th>
                    </tr>
                    <tr class="text-uppercase text-sm">
                        <th>mayo 2020</th>
                        <th class="text-center"><a href="">
                            </a></th>
                    </tr>
                    <tr class="text-uppercase text-sm">
                        <th>junio 2020</th>
                        <th class="text-center"><a href="">
                            </a></th>
                    </tr>
                    <tr class="text-uppercase text-sm">
                        <th>julio 2020</th>
                        <th class="text-center"><a href="">
                            </a></th>
                    </tr>
                    <tr class="text-uppercase text-sm">
                        <th>agosto 2020</th>
                        <th class="text-center"><a href="">
                            </a></th>
                    </tr>
                    <tr class="text-uppercase text-sm">
                        <th>setiembre 2020</th>
                        <th class="text-center"><a href="">
                            </a></th>
                    </tr>
                    <tr class="text-uppercase text-sm">
                        <th>octubre 2020</th>
                        <th class="text-center"><a href="">
                            </a></th>
                    </tr>
                    <tr class="text-uppercase text-sm">
                        <th>noviembre 2020</th>
                        <th class="text-center"><a href="">
                            </a></th>
                    </tr>
                    <tr class="text-uppercase text-sm">
                        <th>diciembre 2020</th>
                        <th class="text-center"><a href="">
                            </a></th>
                    </tr>

                </table>
            </div>
        </div>
    </div>
@endsection
