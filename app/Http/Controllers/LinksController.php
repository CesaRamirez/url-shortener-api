<?php

namespace App\Http\Controllers;

use App\Link;
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
            $link->update([
                'code' => $link->getCode()
            ]);
        }

        $link->increment('requested_count');

        return response()->json([
            'data' => [
                'original_url'  => $link->original_url,
                'shortened_url' => env('CLIENT_URL') . '/' . $link->code,
                'code'          => $link->code
            ]
        ], 200);
    }



}
