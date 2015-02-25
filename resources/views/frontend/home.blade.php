@extends('frontend.partials.app')

@section('content')
    <div class="col-lg-12 documentation">
        <div class="row">
            <div class="col-lg-12">
                <p>
					<span class="pull-left">
													<small>Authored By <b>The Codex Project</b></small>
											</span>

					<span class="pull-right">
						<small>Tuesday, January 27, 2015</small>
					</span>
                </p>
            </div>
        </div>

        <h1>Introduction</h1>
        <p><strong>Codex</strong> is a simple file-based Markdown documentation platform built on top of Laravel. It's completely customizable and dead simple to use to create beautiful documentation.</p>
        <p><a href="https://caffeinated.ninja"><img src="http://img.shields.io/badge/author-Shea_Lewis-blue.svg?style=flat-square" alt="Author" class="img-responsive img-thumbnail"></a>
            <a href="https://github.com/caffeinated/codex"><img src="http://img.shields.io/badge/source-caffeinated/codex-blue.svg?style=flat-square" alt="Source" class="img-responsive img-thumbnail"></a>
            <a href="https://travis-ci.org/caffeinated/codex"><img src="http://img.shields.io/travis/caffeinated/codex/master.svg?style=flat-square" alt="Build Status" class="img-responsive img-thumbnail"></a>
            <a href="https://scrutinizer-ci.com/g/caffeinated/codex/?branch=master"><img src="http://img.shields.io/scrutinizer/g/caffeinated/codex.svg?style=flat-square" alt="Scrutinizer Code Quality" class="img-responsive img-thumbnail"></a>
            <a href="https://tldrlegal.com/license/mit-license"><img src="http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="License" class="img-responsive img-thumbnail"></a></p>
        <p><a href="https://insight.sensiolabs.com/projects/2cdec527-cb61-4a38-8c44-775d30d55ea0"><img src="https://insight.sensiolabs.com/projects/2cdec527-cb61-4a38-8c44-775d30d55ea0/big.png" alt="SensioLabsInsight" class="img-responsive img-thumbnail"></a></p>
        <h2>Completely Open Source <a class="header-anchor" id="completely-open-source" href="#completely-open-source"></a></h2>
        <p>I built Codex to be open and available to <em>everyone</em>. Documentation is incredibly important that can make or break even the best development projects. This is why the code powering Codex is available on <a href="https://github.com/caffeinated/codex">GitHub</a> under the <a href="https://tldrlegal.com/license/mit-license">MIT license</a>.</p>
        <p>In short, I want to see beautiful documentation being written everywhere! No excuses!</p>
        <h2>Features <a class="header-anchor" id="features" href="#features"></a></h2>
        <ul>
            <li>Laravel 4.2</li>
            <li>Github-flavored Markdown</li>
            <li>Host an unlimited number of <em>manuals</em> with accompanying <em>versions</em></li>
            <li>Code highlighting</li>
            <li>Easy TOC / navigation system</li>
            <li>SEO friendly URLs</li>
            <li>Simple search</li>
            <li>Supports Google Analytics</li>
            <li>Supplied theme built on Bootstrap</li>
            <li>Automatic header anchors</li>
        </ul>

        @include('frontend.partials.footer')
    </div>
@stop