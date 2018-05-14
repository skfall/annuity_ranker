@extends('layouts.default')

@section('content')
        <div class="log_wrapper" style="width: 100%; max-width: 1000px; margin: 0 auto;">
            <div class="log_header" style="background: #eee; padding: 10px; margin: 10px 10px 0 10px;">Log: </div>
            <div class="log" id="log" style="background: #eee; padding: 10px; margin: 0 10px 10px 10px; height: 100px; overflow: hidden; overflow-y: scroll;">
                <ul class="target" id="log_target"></ul>
            </div>
        </div>

        <div class="wrapper" style="width: 100%; max-width: 1000px; margin: 0 auto; padding: 30px 15px;">
        <div class="annuities">
            @forelse ($annuities as $key => $an)
                <div class="annuity" style="background: #eee; padding: 10px; margin: 10px; float: left; border: 1px solid #333; cursor: pointer;" onclick="network.get_questions('{{ $an->id }}')">
                    <p>{{ $an->name }}</p>
                </div>
    
                @if ($key == count($annuities) - 1)
                    <div class="annuity" style="background: #eee; padding: 10px; margin: 10px; float: left; border: 1px solid #333; cursor: pointer;" onclick="network.get_questions('{{ $an->id }}')">
                        <p>All annuities</p>
                    </div>
                @endif
            @empty
                <p>No annuities</p>
            @endforelse
        </div>

        <div class="questions" style="clear: both;">

        </div>
    </div>
@endsection