@extends('layouts.default')

@section('content')
    <div class="container manual_page">
        <div class="row">
            <div class="col col-xs-12 content_target">
                {!! $page->content !!}
            </div>
        </div>
    </div>
@endsection