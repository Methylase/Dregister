<?php

namespace Corox\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class ProtectRegister
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
                if(Auth::user()->isMember()){
                        return redirect('/Dregister/dashboard');
                }
                return $next($request);
       }
    }
}
