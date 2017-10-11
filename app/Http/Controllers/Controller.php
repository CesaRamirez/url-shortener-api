<?php

namespace App\Http\Controllers;

use App\Link;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Reponse json to link model.
     *
     * @param App\Link $link
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function linkResponse(Link $link, $merge = false)
    {
        $array = [];

        if ($merge) {
            $array = [
                'requested_count' => (int) $link->requested_count,
                'used_count'      => (int) $link->used_count,
                'created_at'      => $link->created_at->toDateTimeString(),
                'updated_at'      => $link->updated_at->toDateTimeString(),
            ];
        }

        return response()->json(array_merge([
            'data' => [
                'original_url'  => $link->original_url,
                'shortened_url' => $link->shortenedUrl(),
                'code'          => $link->code,
            ],
        ], $array), 200);
    }
}
