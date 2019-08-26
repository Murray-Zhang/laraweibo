@extends('layouts.default')
@section('title', '所有⽤⼾')
@section('content')
    <div class="offset-md-2 col-md-8">
        <h2 class="mb-4 text-center">所有⽤⼾</h2>
        <div class="list-group list-group-flush">
            @foreach ($users as $user)
            {{-- 将user视图单个剥离--}}
                @include('users._user')
            @endforeach
        </div>

        <div class="mt-3">
            {!! $users->links() !!}
        </div>
    </div>
@stop