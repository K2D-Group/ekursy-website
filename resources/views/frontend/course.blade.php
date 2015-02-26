@extends('frontend.partials.app')

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

                    @if(!is_null($date))
                        <span class="pull-right">
                            <small>{{ $date }}</small>
                        </span>
                    @endif
                </p>
            </div>
        </div>

        {!! $content !!}

        @include('frontend.partials.footer')
    </div>
@stop