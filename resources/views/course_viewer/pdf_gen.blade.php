@extends('course_viewer.partials.app')

@section('content')
    <div class="col-lg-12 documentation">

        <h1>{{ $title}}</h1>
        <h2 id="head">Trwa generowanie pliku PDF do pobrania</h2>
        <p class="text-center" id="output">
            <img src="{{ asset('images/spinner.gif') }}" width="{{ 128 }}" height="{{ 128 }}" class="dont-bootstrap" />
        </p>
        @include('course_viewer.partials.footer')
    </div>
@stop

@section('script')
    <script type="text/javascript" language="javascript">
        $(document).ready(function() {
            $.ajax({
                url: "{{ $ajaxLink }}",
                type: 'GET',
                data: {
                    gen: "1",
                    nobranding: "{{ $nobranding }}"
                },
                success: function(data) {
                    $('#head').html("Plik gotowy do pobrania");
                    $('#output').html(
                            '<a class="btn btn-success" target="_blank" href="' + data.link +
                            '">Pobierz: <strong>'+ data.name +'</strong></a>'
                    );
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $('#head').html("Nie można wygenerować pliku PDF.");
                    $('#output').html(
                            'W tej chwili nie jest możliwe wygenerowanie tego PDF\'a.'
                    );
                }
            });
        });
    </script>
@stop