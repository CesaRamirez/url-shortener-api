<?php

namespace App\Http\Middleware;

use Closure;

class ModifiesUrlRequestData
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
        if ( !$request->has('url') ) {
            return $next($request);
        }

        $Validator = \Validator::make($request->only('url'), [
            'url' => 'url'
        ]);

        if ( $Validator->fails() ) {
            $request->merge([
                'url' => 'http://' . $request->url
            ]);
        }

        return $next($request);
    }
}
