<?php

namespace App\Http\Controllers;

use App\Link;
use Cache;
use Illuminate\Http\Request;

class LinkStatsController extends Controller
{
    /**
     * Link.
     *
     * @var \App\Link
     */
    protected $link;

    /**
     * Create a new controller instance.
     */
    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    /**
     * Show stats URL shortened.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $code = $request->get('code');

        $link =  Cache::remember("link.{$code}", 10, function () use ($code) {
            return $this->link->byCode($code)->first();
        });

        if ($link === null) {
            return response(null, 404);
        }

        return $this->linkResponse($link, true);
    }
}
