<?php

namespace App\Http\Controllers;

use App\Link;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $code = $request->get('code');

        $link = Link::byCode('code', $code)->first();
    }

}
