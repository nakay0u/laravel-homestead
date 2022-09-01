@extends('layouts.default')

@section('page-title')
    ツイート一覧
@endsection

@section('content')
    <div class="row">
        <div class="col-md-2">
            @auth
            <a class="btn btn-primary" href="{{ route('tweets.create') }}">ツイート新規投稿</a>    
            @endauth
        </div>

        <div class="col-md-10">
            @if(Session::has('flash_message'))
                <div class="alert alert-success">
                    {{ Session::get('flash_message') }}
                </div>
            @endif
            <table class="table">
                <tbody>
                    @foreach($tweets as $tweet)
                    <tr>
                        <td>{{ $tweet->body }}</td>
                        <td class="text-right">{{ $tweet->user->name }}</td>
                        <td class="text-right"><a href="{{ route('tweets.show', $tweet->id) }}">詳細</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
