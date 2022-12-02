@extends ('layout')
@section ('content')
<script src="https://kit.fontawesome.com/a81368914c.js" ></script>
<div class="bg" style="background-color: rgb(255, 255, 255)">
<div  class="container">
  <div class="img">
    <img src="{{asset('assets/img/cat.gif')}}"/>
  </div>
  <div class="login-container">
    <form method="POST" action="/login/auth">
      @if (session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
  @endif
      @if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if (Session::get('notAllowed'))
<div class="alert alert-danger">
    {{ Session::get('notAllowed') }}
</div>
@endif
  @csrf
  <img class="avator" src="{{asset('assets/img/avator.svg')}}"/>
    <h2>WELCOME</h2>
    <div class="input-div" one>
    <div class="i">
      <i class="fas fa-user"></i>
    </div>
    <div>
      <h5>Username</h5>
      <input class="input" type="text" name="username"/>
    </div>
  </div>
  <div class="input-div" two>
    <div class="i">
      <i class="fas fa-lock"></i>
    </div>
    <div>
      <h5>password</h5>
      <input class="input" type="password" name="password" />
    </div>
  </div>
  <div class="reg">
  <a href="/register"> Don't have account?</a>
</div>
  <button type="submit" class="btnlog">LOGIN</button>
</form>
</div>
</div>
</div>
@endsection

