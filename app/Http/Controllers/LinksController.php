<?php

namespace App\Http\Controllers;

use App\Link;
use Cache;
use Illuminate\Http\Request;

class LinksController extends Controller
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

    /**
     * Store URL shortened
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url'
        ], [
            'url.required' => 'Please enter a URL to shorten.',
            'url.url'      => 'That don\'t look like a valid URL'
        ]);

        $link = $this->link->firstOrNew([
            'original_url' => $request->get('url')
        ]);

        if ( !$link->exists ) {
            $link->save();
        }

        $link->increment('requested_count');

        return $this->linkResponse($link);
    }

    /**
     * Show URL shortened
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $code = $request->get('code');

        $link =  Cache::rememberForever("link.{$code}", function () use ($code) {
            return $this->link->byCode($code)->first();
        });

        if ( $link === null) {
            return response(null, 404);
        }

        $link->increment('used_count');

        return $this->linkResponse($link);
    }

}
