@extends('layout')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control {{ $errors->has('name')? 'is-invalid':'' }}" value="{{ old('name') }}"/>
            @if($errors->has('name'))
              <span class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
              </span>
            @endif
        </div>
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
            <label for="retyped_password">Retyped Password</label>
            <input type="password" name="password_confirmation" id="retyped_password" class="form-control"/>
        </div>
        <button type="submit" name="register" class="btn btn-primary btn-block">Register!</button>
    </form>
@endsection('content')