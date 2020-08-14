@extends('layout')

@section('content')
      <h3>{{ $post->title }}</h3>
      <h4>{{ $post->content }}</h4>
      <p>Added {{ $post->created_at->diffForHumans() }}</p>

      @if((new Carbon\Carbon())->diffInMinutes($post->created_at) < 10000)
        @badge
            Brand New Post!
        @endbadge
      @endif

      <p>Currently read by {{ $counter }} people</p>

      <h4>Comments</h4>

      @forelse($post->comments as $comments)
        <p>
          {{ $comments->content }}
        </p>
        <p class="text-muted">
          added {{ $comments->created_at->diffForHumans() }}
        </p>
      @empty
         <p>No comment Yet!</p>
      @endforelse
       
@endsection