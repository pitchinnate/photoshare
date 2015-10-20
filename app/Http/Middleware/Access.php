<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Photo;

class Access
{

    public function handle(Request $request, Closure $next, $param)
    {
        if($request->user()->is_admin == 0) {
            if($param == 'album') {
                $access = $request->user()->hasAccess($request->id);
            } else {
                $photo = Photo::findOrFail($request->id);
                $access = $request->user()->hasAccess($photo->album_id);
            }
            if(!$access) {
                return (new Response('You do not have access to this album or photo',403));
            }
        }

        return $next($request);
    }
}
