@extends('layout')
@section('content')

    <div class="wrapper bg-white">
        @if (Session::get('notAllowed'))
<div class="alert alert-danger">
    {{ Session::get('notAllowed') }}
</div>
@endif
@if (session('successUpdate'))
<div class="alert alert-success">
    {{ session('successUpdate') }}
</div>
@endif
@if (session('successAdd'))
<div class="alert alert-success">
    {{ session('successAdd') }}
</div>
@endif
@if (session::get('delete'))
<div class="alert alert-warning">
    {{ session::get('delete') }}
</div>
@endif
@if (session::get('done'))
<div class="alert alert-warning">
    {{ session::get('done') }}
</div>
@endif
{{-- mengambil dan mengirim data input ke controller yg nantinya diambil oleh request $request --}}
        <div class="d-flex align-items-start justify-content-between">
            <div class="d-flex flex-column">
                <div class="h5">My Todo's</div>
                <p class="text-muted text-justify">
                    Here's a list of activities you have to do
                </p>
                <br>
                <div class="d-flex">
                    <a href="/todo/create" class="text-success">Create</a>  
                    <a href="" class="mx-3">Complated</a>
            </div>
            </div>
            <div class="info btn ml-md-4 ml-0">
                <span class="fas fa-info" title="Info"></span>
            </div>
        </div>
        <div class="work border-bottom pt-3">
            <div class="d-flex align-items-center py-2 mt-1">
                <div>
                    <span class="text-muted fas fa-comment btn"></span>
                </div>
                <div class="text-muted">{{ $todos->count(); }} todos</div>
                <button class="ml-auto btn bg-white text-muted fas fa-angle-down" type="button" data-toggle="collapse"
                    data-target="#comments" aria-expanded="false" aria-controls="comments"></button>
            </div>
        </div>
        <div id="comments" class="mt-1">
            {{-- looping data-data dari compact 'todos' agar dapat ditampilkan per baris datanya --}}
            @foreach ($todos as $todo)
            <div class="comment col-12">
                {{-- <div class="px-2">
                    <label class="option">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                </div> --}}
                <div class="d-flex flex-column p-2">
                    {{-- menampilkan data dinamis/data yang diambil dari DB pada blade harus menggunakan {{}} --}}
                    {{-- path yang {id} dikirim data dinamis (data dari DB) makanya disitu pake {{}} --}}
                    <a href="/todo/edit/{{$todo['id']}}" class="text-justify">
                        {{ $todo['title']}}</a>
                    <p> {{$todo['description']}} </p>
                    {{--konsep ternaryy : if column status baris ini isinya 1 bakal munculin teks 'Completed'
                    selain dari itu akan menampilkan teks 'On-process' --}}
                    <p class="text-muted">{{$todo ['status'] == 1 ?'completed' : 'On-process' }}
                        <span class="date">{{\Carbon\Carbon::parse($todo['date'])->format('j F, Y ')}}</span>
                    </p>
                        <span class="date">
                            @if ($todo['status']== 1)
                            selesai pada : {{\Carbon\Carbon::parse($todo['done_time'])->format('j F, Y ')}}
                            @else Target : {{\Carbon\Carbon::parse($todo['date'])->format('j F, Y ')}}
                            @endif
                        </span>
                    {{-- Carbon itu package laravel untuk mengelola yang berhubungan dengan date. Tadinya
                        value column date di db kan bentuknya format 2022-11-22 nah kita pengen ubah bentuk formatnya
                        jadi 22 November, 2022 --}}
                </div>
                <div class="d-flex">
                    {{-- cek kalau statusnya 1(completed), maka yang ditampilkan icon biaasa yang gabisa di klik--}}
                    @if ($todo['status']==1)
                    <span class="fa-solid fa-bookmark text-secondary btn"></span>
                    {{--kalau statusnya selain dari 1, baru muncul inon checklist yang bisa di click buat
                        update ke complated--}}
                    {{-- apabila fitur nya berhubungan dengan modifikasi database, maka gunakan form--}}
                    @else
                    <form action="{{ route('todo.update-complated', $todo['id']) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-primary mx-3">Done</button>
                    </form>
                    @endif
                <form action="{{ route('todo.delete', $todo['id']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection