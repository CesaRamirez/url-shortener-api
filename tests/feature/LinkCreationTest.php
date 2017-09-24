<?php

use App\Exceptions\CodeGenerationException;
use App\Link;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LinkCreationTest extends TestCase
{
    /**
     * @test Fails if no url given.
     *
     *
     * @return void
     */
    public function fails_if_no_url_given()
    {
        $response = $this->json('POST', '/', [
            'url' => 'www.google.com'
        ])
        ->seeInDatabase('links', [
            'original_url' => 'http://www.google.com',
            'code'         => '1'
        ])
        ->seeJson([
            'data' => [
                'original_url'  => 'http://www.google.com',
                'shortened_url' => env('CLIENT_URL') . '/1',
                'code'          => '1'
            ]
        ])
        ->assertResponseStatus(200);
    }

    /**
     * @test Link is only shortened once.
     *
     *
     * @return void
     */
    public function link_is_only_shortened_once()
    {
        $url = 'http://www.google.com';

        $this->json('POST', '/', ['url' => $url]);
        $this->json('POST', '/', ['url' => $url]);

        $link = Link::where('original_url', $url)->get();

        $this->assertCount(1, $link);
    }

    /**
     * @test Requested count is incremeted.
     *
     *
     * @return void
     */
    public function requested_count_is_incremented()
    {
        $url = 'http://www.google.com';

        $this->json('POST', '/', ['url' => $url]);
        $this->json('POST', '/', ['url' => $url]);

        $this->seeInDatabase('links', [
            'original_url'    => $url,
            'requested_count' => 2
        ]);
    }

}
