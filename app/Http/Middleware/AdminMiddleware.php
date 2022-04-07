<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
//use App\Http\Middleware\Auth;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminMiddleware
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
        if (Auth::user()->is_admin)
        return $next($request);

    return response()->json(['message'=>'No tens privilegis d\'Administrador']);  
    }  
    
}
