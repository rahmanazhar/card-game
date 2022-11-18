@extends('layouts.app')

@section('title', __('Card Game'))

@section('after-styles-end')
@endsection

@section('content')
<div class="mx-3">
    <div class="row mt-3">

        <div class="col-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Card Game</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($playerWithCards as $player)
        <div class="col-2 mx-auto">
            <div class="card">
                <div class="card-body">
                    <p>Player <b>{{$player->name}}</b></p>
                    <p>{{count($player->cards)}} Cards in Hand</p>
                    <p>@foreach($player->cards as $cards){{$cards->name}}{{(next($player->cards)==true)?",":""}}@endforeach</p>
                </div>
            </div>

        </div>
        @endforeach
    </div>
</div>

@endsection


@section('after-scripts-end')


@endsection