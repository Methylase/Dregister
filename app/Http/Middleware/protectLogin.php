<?php

namespace Corox\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Corox\Models\Corox_model;
class protectLogin
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

                    return $next($request);
          
           /*
            if(Auth::user()->isAdmin()){
                    return $next($request);
            }
            if(Auth::user()->isMember()){
                    return $next($request);
            }
      
            */
        }else {
          return redirect('/Dregister/');
    }
}
}