<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuspendedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()->is_suspended){
            auth()->guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();  
                     
             session()->flash('warning', "Your account is suspended. Access Denied!"); 
             

            return redirect(route('login'));
        }
        return $next($request);
    }
}
