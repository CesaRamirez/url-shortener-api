<?php

use App\Exceptions\CodeGenerationException;
use App\Http\Middleware\ModifiesUrlRequestData;
use App\Link;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UrlMiddlewareTest extends TestCase
{
    /**
     * @test Http is preprended to url.
     *
     *
     * @return void
     */
    public function http_is_preprended_to_url()
    {
        $request = new Request;

        $request->replace([
            'url' => 'google.com'
        ]);

        $middleware = new ModifiesUrlRequestData;

        $middleware->handle($request, function ($req) {
            $this->assertEquals('http://google.com', $req->url);
        });
    }

    /**
     * @test Http is not preprended to url if scheme exists.
     *
     *
     * @return void
     */
    public function http_is_not_preprended_to_url_if_scheme_exists()
    {
        $request = new Request;

        $urls = [
            'ftp://google.com',
            'http://google.com',
            'https://google.com'
        ];

        foreach ($urls as $url) {
            $request->replace([
                'url' => $url
            ]);

            $middleware = new ModifiesUrlRequestData;

            $middleware->handle($request, function ($req) use ($url) {
                $this->assertEquals($url, $req->url);
            });
        }
    }

}
