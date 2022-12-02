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
    <form method="POST" id="create-form" action="/todo/update/{{$todo['id']}}" class="form1">
        {{-- mengambil dan mengirim data input ke controller yang nantinya diambil oleh request $request --}}
      <h3>Edit Todo</h3>
      {{-- karena di route nya pake method patch sedangkan attribute method di form cuman bisa post/get. 
        jadi yang post yang ditimpa --}}
      @method('PATCH')
          @csrf
      <fieldset>
          <label for="">Title</label>
          {{--attribute value fungsinya untuk memasukan data ke input.
            kenapa datanya harus disimpan di input? karena ini kan ditur edit. kalau fitur edit belum 
            tentu semua data column diubah. jadi untuk mengantisipasi hal itum tamoilin dulu semua data
            di inputnya baru nantinya pengguna yang menentukan data input mana yg mau diubah--}}
          <input placeholder="title of todo" type="text" name="title" value="{{ $todo['title'] }}">
      </fieldset>
      <fieldset>
          <label for="">Target Date</label>
          <input placeholder="Target Date" type="date" name="date" value="{{ $todo['date'] }}">
      </fieldset>
      <fieldset>
          <label for="">Description</label>
          {{-- karena textarea tidak termasuk tag input, untuk menampilkan value nya di prttrngshsn 
            (sebelum penutup tag </textarea>) --}}
          <textarea placeholder="Type your descriptions here..." tabindex="5" name="description" value="{{ $todo['description'] }}"></textarea>
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