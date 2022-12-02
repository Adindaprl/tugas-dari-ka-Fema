<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //cek apakah ada hisory login di authnya, kalau ada dibolehkan lanjut akses laman
        if (Auth::check()){
            return $next($request);
        }
        // kalau gada history login bakal diarahin ke logiin dengan pesan
        return redirect('/')->with('notAllowed', 'silakan login terlebih dahulu');
    }
}
