<?php

namespace App\Http\Controllers;

use App\Link;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Reponse json to link model
     *
     * @param  App\Link   $link
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function linkResponse(Link $link)
    {
        return response()->json([
            'data' => [
                'original_url'  => $link->original_url,
                'shortened_url' => $link->shortenedUrl(),
                'code'          => $link->code
            ]
        ], 200);
    }
}
