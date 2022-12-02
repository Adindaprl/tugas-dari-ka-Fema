<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 

     public function login(){
        return view('login');
     }
    public function register()
    {
    return view('register');
    }
    public function index()
    {
        // ambil data dari table todos dengan model todo
        // all() fungsinya untuk mengambil semua data di table
        $todos = Todo::where('user_id', '=', Auth::user()->id)->get();
        // kirim data uang sudah diabmil ke file blade /  ke dile yang menampilkan halaman
        // kirim melalui compact()
        // isi compact sesuaikan dengan nama variable
        return view ('dashboard', compact('todos'));
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
    public function registerAccount(Request $request){
    //dd($request->all());
    // validasi input
    $request ->validate([
    'email' => 'required|email:dns',
    'username' => 'required|min:4|max:8',
    'password' => 'required|min:4',
    'name' => 'required|min:3',
    ]);
    // input data ke db
    User::create([
        'name'=> $request->name,
        'username'=> $request ->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);
    // redireect kemana setelah berhasil tambah data + dikirim pemberitahuan
    return redirect('/')->with('success', 'Berhasil menambahkan akun! silakan login');
}
    public function auth(Request $request){
   //array ke 2 sebagai custom message
    $request->validate([
        'username' => 'required|exists:users,username',
        'password' => 'required',
    ],[
        'username.exists' => 'username ini belum tersedia',
        'username.required' => 'username harus diisi',
        'password.required' => 'password harus diisi',
    ]);
    $user = $request->only('username', 'password');
    if (Auth::attempt($user)){
        return redirect()->route('todo.index');
    } else {
        return redirect()->back()->with('error', 'Gagal login, silakan cek dan coba lagi!');
    }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //
      $request->validate([
        'title' => 'required|min:3',
        'date' => 'required',
        'description' => 'required|min:5',
      ]);
      // mengirim data ke DB table totos dengan model todo
      // '' = nama column di table DB
      // $request -> = value atribute name pada input
      // kenapa yang dikirim 5 data? karena table pada DB todos membutuhkan 6 column input
      // salah satunya column 'done_time' yg tipenya nullable, karena nullable jd ga perlu ngirim nilai
      //user_id untuk memberitahu data todo ini milik siapa, diambil melalui fitur auth
      // 'status' tipenya boolean, 0 =belum dikerjakan, 1= sudah dikerjakan (todonya)
    Todo::create([
        'title' => $request->title,
        'date' => $request->date,
        'description' => $request->description,
        'status' => 0,
        'user_id' => Auth::user()->id,  
    ]);
    return redirect()->route('todo.index')->with('successAdd', 'Berhasil menambahkan data Todo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */

    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        //menampiilkan halaman input form edit
        //menggambil data satu baris ketika column id pada baris tersebut sama dengan id dari parameter route
        $todo =Todo::where('id', $id)->first();
        //kirim data yang diambil ke file blade dengan compact
        return view('edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:3',
            'date' => 'required',
            'description' => 'required|min:5',
          ]);
          Todo::where('id', $id)->update([
            'title' => $request->title,
            'date' => $request->date,
            'description' => $request->description,
            'status' => 0,
            'user_id' => Auth::user()->id,
          ]);
          //kalau berhasil, halaman bakal di redirect ke halaman awal todo dengan pesan pemberitahuan
          return redirect('/todo/')->with('successUpdate', 'Data todo berhasil diperbarui');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //menghapus data di database
        // filter / dari data yang mau di hapus, baru jalankan perintah hapusnya
        Todo::where('id', '=', $id)->delete();
        // kalau udah, balik lagi ke halaman awalnya dengan pemberihuan
        return redirect()->back()->with('delete', 'Berhasil menghapus ToDo!');
    }

    public function complated()
    {
        return view('complated');
    }
    public function updateComplated($id)
    {
        //cari data yang mau diubah statusnya kadi 'complated' dan column 'done_time' 
        // yang tadinya null. diisi dengan tanggal sekarang (tanggal ketika data tdo di ubah statusnya)
        // karena status boolean, dan 0 itu untuk kondisi todo on-progres, jadi 1 nya untuk kondisi todo complated
        Todo::where('id', '=', $id)->update([
            'status' => 1,
            'done_time' => \Carbon\Carbon::now(),
        ]);
        //apabila berhasil. akan dikembalikan ke halaman awal dengan pemberitahuan
        return redirect()->back()->with('done', 'ToDo telah selesai dikerjakan!');
    }
    
}
