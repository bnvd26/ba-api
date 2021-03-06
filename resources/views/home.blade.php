@extends('layouts.app')

@section('content')

<head>
    <script>
        window.Laravel = {!! json_encode([
            'user' => auth()->check() ? auth()->user()->id : null,
        ]) !!};
        
    </script>
</head>
<div class="container">
    <h1>HOME</h1>
    <h2>Tout les posts</h2>
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger" role="alert">
        <strong>{{ $error }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endforeach
    @include('post.create')
    @foreach ($posts as $post)
    <div class="card" style="border: 0.1px solid black; margin: 20px;padding:20px">
        <div class="card-header" style="display:flex;justify-content:space-between;align-items:center">
            <h3><a href={{route('post.show', ['id'=>$post->id]) }}>{{ $post->title }}</a></h3>
            <div style="display:flex;justify-content:space-between;align-items:center">
                @if ($post->userLiked($post->id))
                @include('like.unlike', ['id' => $post->id])
                @else
                @include('like.like', ['id' => $post->id])
                @endif
                <div>
                    {{$post->countLike($post->id)}} Like
                </div>
            </div>
        </div>
        <div class="card-body">
            <p class="card-title">{{ $post->content }}</p>
            @if ($post->user)
            <h5 class="card-text"> Author: {{ $post->user->name }}</h5>

            @foreach ($post->tags as $tag)
            @if ($tag)
            <h6><span class="badge badge-secondary">Tag</span>{{$tag->name}} </h6>
            @endif
            @endforeach

            {{-- {{dump($post->userLiked($post->id) ? 'ok' : 'not ok')}}
            @include('like.create', ['id' => $post->id, 'like' => $post->userLiked($post->id) ? false : true]) --}}
            @if ($post->comments && $post->comments->count() > 0)
            <div class="container" style="width:80%;">
                <h3>Commentaires</h3>
                @foreach ($post->comments as $comment)
                <div style="border:0.1px solid black;margin:10px;">
                    <p class="card_text"> {{ $comment->comment }}</p>
                </div>
                @endforeach
                @include('comment.create', ['id' => $post->id])
            </div>
            @else

            @endif
            @endif
        </div>
    </div>
    @endforeach
    {{ $posts->links() }}
</div>
@endsection