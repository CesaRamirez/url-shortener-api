<?php

namespace App\Http\Controllers;

use App\Link;
use Cache;
use Illuminate\Http\Request;

class LinkStatsController extends Controller
{
    protected $link;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    public function show(Request $request)
    {
        $code = $request->get('code');

        $link =  Cache::remember("link.{$code}", 10, function () use ($code) {
            return $this->link->byCode($code)->first();
        });

        if ( $link === null) {
            return response(null, 404);
        }

        return $this->linkResponse($link, true);
    }

}
