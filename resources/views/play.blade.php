@extends('layouts.app')

@section('title', __('Card Game'))

@section('after-styles-end')
@endsection

@section('content')

<div class="row mt-5">
    <div class="col-4 mx-auto">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Card Game</h5>
                <form action="{{route('game.post_game') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">

                    @csrf

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-3">
                                    <label>How many players : </label>
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control" name="players" value="0" min="0" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Play Game</button>
                        </div>
                        <!--col-->
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection


@section('after-scripts-end')


@endsection