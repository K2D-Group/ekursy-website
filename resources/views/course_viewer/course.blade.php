@extends('course_viewer.partials.app')

@section('content')
    <div class="col-lg-12 documentation">
        <div class="row">
            <div class="col-lg-12">
                <p>
                    @if(!is_null($author) || !is_null($reviewer))
                        <span class="pull-left">
                            @if(!is_null($author))
                                <small>Autorzy: <b>{{ $author }}</b></small>
                            @endif
                            @if(!is_null($reviewer))
                                <small>Recenzenci: <b>{{ $reviewer }}</b></small>
                            @endif
                        </span>
                    @endif

                    @if(!is_null($date) || !is_null($sources))
                        <span class="pull-right">
                            @if(!is_null($sources))
                                <small>Źródła: <b>{!! $sources !!}</b></small>
                            @endif

                            @if(!is_null($date))
                                <small>Aktualizacje: <b>{{ $date }}</b></small>
                            @endif
                        </span>
                    @endif
                </p>
            </div>
        </div>

        {!! $content !!}

        @include('course_viewer.partials.footer')
    </div>
@stop