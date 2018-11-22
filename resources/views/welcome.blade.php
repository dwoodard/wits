@extends('layouts.blank', ['sidebar' => false])

@section('content')

    <div class="title m-b-md">
        <h1 class="text-center">
        <i class="fa fa-cubes" aria-hidden="true"></i>
        Weber Inventory Tracking System
        </h1>

        <h2 class="text-center">
            <a href="/login">Login <i class="fa fa-sign-in-alt " aria-hidden="true"></i></a>
        </h2>

    </div>

    <div>

        @if (Auth::check())

        @endif
    </div>
</div>
@endsection



