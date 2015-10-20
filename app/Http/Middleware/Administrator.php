<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\User;

class Administrator
{

    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->is_admin != 1) {
            return (new Response('You have to be an administrator to perform this function', 403));
        }

        return $next($request);
    }
}
