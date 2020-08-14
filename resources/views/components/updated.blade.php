<p>
    {{ $slot ? 'Added ' }} {{ $date }}
    @if(isset($name))
      by {{ $post->user->name }}
    @endif

</p>