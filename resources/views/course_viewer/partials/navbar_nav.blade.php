<ul class="nav navbar-nav">
    @if (isset($currentManual))
{{--        @if (count($manuals) > 1)--}}
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-book"></span> {{ $manuals[$currentManual] }} <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    @foreach ($manuals as $id=>$manual)
                        <li><a href="{{ route('course', [$id, 'v1']) }}">{{ $manual }}</a> </li>
                    @endforeach
                </ul>
            </li>
        {{--@else--}}
            {{--<li><p class="navbar-text"><span class="glyphicon glyphicon-book"></span> {{ $manuals[$currentManual] }}</p></li>--}}
        {{--@endif--}}
    @endif

    @if (isset($currentVersion))
{{--        @if (count($versions) > 1)--}}
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-bookmark"></span> {{ $currentVersion }} <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    @foreach ($versions as $version)
                        <li><a href="{{ route('course', [$currentManual, $version]) }}">{{ $version }}</a> </li>
                    @endforeach
                </ul>
            </li>
        {{--@else--}}
            {{--<li><p class="navbar-text"><span class="glyphicon glyphicon-bookmark"></span> {{ $currentVersion }}</p></li>--}}
        {{--@endif--}}
    @endif

    @if (Auth::check())
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-download-alt"></span> Pobierz <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('course.pdf', [$currentManual, $version, 'print'=>0]) }}">PDF</a></li>
                <li><a href="{{ route('course.pdf', [$currentManual, $version, 'print'=>1]) }}">E-Book PDF</a></li>
                @if(Auth::check() && \Permissions::can('course.pdf.booklet'))
                    <li><a href="{{ route('course.pdf', [$currentManual, $version, 'print'=>2]) }}">Booklet</a></li>
                @endif
                @if(Auth::check() && \Permissions::can('course.pdf.whitelabel'))
                    <li><a href="{{ route('course.pdf', [$currentManual, $version, 'print'=>0, 'nobranding'=>1]) }}">PDF (WhiteLabel)</a></li>
                    <li><a href="{{ route('course.pdf', [$currentManual, $version, 'print'=>1, 'nobranding'=>1]) }}">E-Book PDF (WhiteLabel)</a></li>
                    @if(Auth::check() && \Permissions::can('course.pdf.booklet'))
                        <li><a href="{{ route('course.pdf', [$currentManual, $version, 'print'=>2, 'nobranding'=>1]) }}">Booklet (WhiteLabel)</a></li>
                    @endif
                @endif
            </ul>
        </li>
    @else
        <li class="dropdown">
            <a href="{{ route('auth.login') }}" ><span class="glyphicon glyphicon-download-alt"></span> Pobierz</a>
        </li>
    @endif

</ul>

<ul class="nav navbar-nav  pull-right">

    @if(Auth::check())
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <strong>{{ Auth::user()->name }}</strong>
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('auth.logout') }}">Wyloguj się</a></li>
            </ul>
        </li>
    @else
        <li>
            <a href="{{ route('auth.login') }}">Zaloguj się</a>
        </li>
    @endif


</ul>
