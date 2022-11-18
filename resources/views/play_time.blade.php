@extends('layouts.app')

@section('title', __('Card Game'))

@section('after-styles-end')
@endsection

@section('content')

<div class="row mt-5">
    @foreach($playerWithCards as $player)
    <div class="col-4 mx-auto">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Card Game</h5>
                <p>Player</p>

    @foreach($player as $player)
            </div>
        </div>

    </div>
    @endforeach
</div>

@endsection


@section('after-scripts-end')


@endsection