@extends('layout')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control {{ $errors->has('email')? 'is-invalid':'' }}" value="{{ old('email') }}"/>
            @if($errors->has('email'))
              <span class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
            @endif
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}"/>
            @if($errors->has('password'))
              <span class="invalid-feedback">
               <strong>{{ $errors->first('password') }}</strong>
              </span>
            @endif
        </div>

        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" name="remember" id="" class="form-check-input" value="{{ old('remember') ? 'checked':'' }}">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>
        </div>
        <button type="submit" name="register" class="btn btn-primary btn-block">Login</button>
    </form>
@endsection('content')