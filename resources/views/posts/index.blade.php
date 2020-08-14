@extends('layout')

@section('content')
<div class="row">
   <div class="col-8">
   @forelse($post as $post)  
    <p>

      <h3>
        @if($post->trashed())
         <del>
        @endif
        <a CLASS="{{ $post->trashed() ? 'text-muted' :'' }}" href="{{ route('posts.show',['post'=> $post->id]) }}">{{ $post->title }}</a>
        @if($post->trashed())
         </del>
        @endif
      </h3>

      {{-- <p>
        Added {{ $post->created_at->diffForHumans() }}
        by {{ $post->user->name }}
      </p> --}}

      @updated(['date'=>$post->create_at, 'name'=>$post->user->name])
        
      @endupdated

      @if($post->comments_count)
         <p>{{ $post->comments_count }} comments</p>
      @else
        <p>No comment yet!</p>
      @endif

      @can('update',$post)
      <a href="{{ route('posts.edit',['post'=>$post->id]) }}" class="btn btn-primary">Edit</a>
      @endcan

      @if(!$post->trashed())
      @can('delete',$post)
      <form method="POST" class="fm-inline" action="{{ route('posts.destroy',['post'=>$post->id]) }}">
        @csrf
        @method('DELETE')
        <input type="submit" value="DELETE!" class="btn btn-primary"/>
      </form>
      @endcan
      @endif
      
    </p>
   @empty
    <p>No Blog Post Yet!</p>
   @endforelse
  </div>
  <div class="col-4">
    <div class="conatiner">
      <div class="row">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Most Commented</h5>
            <h6 class="card-subtitle mb-2 text-muted">What people are currently talking about!</h6>
          </div>
            <div class="list-group list-group-flush">
              @foreach($mostCommented as $post)
                <li class="list-group-item">
                <a href="{{ route('posts.show',$post->id) }}">{{ $post->title }}</a>
                </li>
              @endforeach
            </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="card" style="width:100%">
          <div class="card-body">
            <h5 class="card-title">Most Active User</h5>
            <h6 class="card-subtitle mb-2 text-muted">User with most posts written!</h6>
          </div>
            <div class="list-group list-group-flush">
              @foreach($mostActiveUser as $user)
                <li class="list-group-item">
                  {{ $user->name }}
                </li>
              @endforeach
            </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="card" style="width:100%">
          <div class="card-body">
            <h5 class="card-title">Most Active Last Month</h5>
            <h6 class="card-subtitle mb-2 text-muted">User with most posts written in last month!</h6>
          </div>
            <div class="list-group list-group-flush">
              @foreach($mostActiveLastMonth as $user)
                <li class="list-group-item">
                  {{ $user->name }}
                </li>
              @endforeach
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection