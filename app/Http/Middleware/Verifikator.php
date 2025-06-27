<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Verifikator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        //ROLE ADMINISTRATOR
        if($userRole == 1)
        {
            return redirect()->route('administrator.dashboard');
        }
        //ROLE OPERATOR
        if($userRole == 2)
        {
            return redirect()->route('verifikator.dashboard');
        }
        //ROLE VERIFIKATOR
        if($userRole == 3)
        {
            return $next($request);

        }
        //ROLE KABALAI
        if($userRole == 4)
        {
            return redirect()->route('kabalai.dashboard');
        }
    }
}
