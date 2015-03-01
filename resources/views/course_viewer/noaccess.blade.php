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
                            {{--@if(!is_null($reviewer))--}}
                                {{--<small>Recenzenci: <b>{{ $reviewer }}</b></small>--}}
                            {{--@endif--}}
                        </span>
                    @endif

                    @if(!is_null($date) || !is_null($sources))
                        <span class="pull-right">
                            {{--@if(!is_null($sources))--}}
                                {{--<small>Źródła: <b>{!! $sources !!}</b></small>--}}
                            {{--@endif--}}

                            @if(!is_null($date))
                                <small>Aktualizacje: <b>{{ $date }}</b></small>
                            @endif
                        </span>
                    @endif
                </p>
            </div>
        </div>

        <h1>{{ $title or 'Musisz być zalogowany aby wyświetlić tą stronę' }}</h1>
        <h2>Musisz być zalogowany aby wyświetlić tą stronę</h2>
        <p>W celu wyświetlenia zawartości tej podstrony prosimy cię o <a href="{{ route('auth.login') }}">zalogowanie się</a>.</p>
        <p class="text-center">
            <a href="{{ route('auth.login', ['return' => Request::url()]) }}">
                <img src="{{ asset('images/login_k2d.png') }}" width="{{ 649/2.5 }}" height="{{ 138/2.5 }}" class="dont-bootstrap" style="padding: 10px"/>
            </a>
            <a href="{{ route('auth.login.social', ['facebook', 'return' => Request::url()]) }}">
                <img src="{{ asset('images/login_fb.png') }}" width="{{ 649/2.5 }}" height="{{ 138/2.5 }}" class="dont-bootstrap" style="padding: 10px"/>
            </a>
            <a href="{{ route('auth.login.social', ['bitbucket', 'return' => Request::url()]) }}">
                <img src="{{ asset('images/login_bb.png') }}" width="{{ 649/2.5 }}" height="{{ 138/2.5 }}" class="dont-bootstrap" style="padding: 10px"/>
            </a>
        </p>
        @include('course_viewer.partials.footer')
    </div>
@stop