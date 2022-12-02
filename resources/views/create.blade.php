@extends('layout')
@section('content')
<div class="container content">  

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="POST" id="create-form" action="/todo/store" class="form1">
      <h3>Create Todo</h3>
          @csrf
      <fieldset>
          <label for="">Title</label>
          <input placeholder="title of todo" type="text" name="title">
      </fieldset>
      <fieldset>
          <label for="">Target Date</label>
          <input placeholder="Target Date" type="date" name="date">
      </fieldset>
      <fieldset>
          <label for="">Description</label>
          <textarea placeholder="Type your descriptions here..." tabindex="5" name="description"></textarea>
      </fieldset>
      <fieldset>
          <button name="submit" type="submit" id="contactus-submit">Submit</button>
      </fieldset>
      <fieldset>
          <a href="/todo/" class="btn-cancel btn-lg btn">Cancel</a>
      </fieldset>
    </form>
  </div>
@endsection