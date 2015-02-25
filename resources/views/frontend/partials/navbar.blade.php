<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid" style="height: 61px">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

			<span class="navbar-brand">
				<a href="/">K2D</a>

				<div class="pull-right">
                    <button type="button" data-toggle="offcanvas">
                        <span class="glyphicon glyphicon-chevron-left" id="collapse-sidebar-button"></span>
                    </button>
                </div>
			</span>
        </div>

        <div id="navbar" class="collapse navbar-collapse">
            @include('frontend.partials.navbar_nav')

            {{--@if (true)--}}
                {{--@include('frontend.partials.search_form')--}}
            {{--@endif--}}
        </div>
    </div>
</nav>
