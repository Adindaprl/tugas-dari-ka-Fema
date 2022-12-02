@extends ('layout')
@section ('content')
<div class="d-flex justify-content-center mt-5">
  <form method="POST" action="/register/input" class="row g-9 col-5">
    @method('POST')
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
 <h1 class="d-flex justify-content-center">REGISTER</h1>
  <h5 class="d-flex justify-content-center">sign up and managing your account!</h5>
    @csrf
    <div class="input-div" one>
      <div class="i">
        <i class="fas fa-user"></i>
      </div>
      <div>
        <h5>Name</h5>
        <input class="input" type="text" name="name"/>
      </div>
    </div>
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
      <h5>Email</h5>
      <input class="input" type="email" name="email" />
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
      <button type="submit" class="btnlog">SIGN UP</button>
    </div>
  </form>
@endsection