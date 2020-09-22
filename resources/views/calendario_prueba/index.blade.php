@extends ('layouts.admin')
@section ('contenido')

    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div id='fullcalendar'></div>
        </div>
    </div>



    @push('scripts')
        <script>

            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('fullcalendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: [ 'dayGrid' ]
                });

                calendar.render();
            });

        </script>

    @endpush
@endsection
