@extends('layouts.app')

@section('content')
    <div class="container" style="{{ request()->is('app/auswertung-ontour') ? 'min-width: 100%;' : '' }}">
    <div class="row justify-content-center">
        <div class="{{ request()->is('app/auswertung-ontour') ? 'col-md-12' : 'col-md-8' }} p-0">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif


                    <div id="vue-app"></div>
        </div>
    </div>
</div>
@endsection
@section('vue-scripts')
    @vite(['resources/js/app.js'])
@endsection
