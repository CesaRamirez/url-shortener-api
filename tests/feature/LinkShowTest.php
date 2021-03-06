<?php

use App\Exceptions\CodeGenerationException;
use App\Link;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LinkShowTest extends TestCase
{
    /**
     * @test Requested link details are returned.
     *
     *
     * @return void
     */
    public function requested_link_details_are_returned()
    {
        $link = factory(Link::class)->create();

        $response = $this->json('GET', '/', [
            'code' => $link->code
        ])
        ->seeJson([
            'original_url'  => $link->original_url,
            'shortened_url' => $link->shortenedUrl(),
            'code'          => $link->code
        ])
        ->assertResponseStatus(200);
    }

    /**
     * @test Requested link details are returned.
     *
     *
     * @return void
     */
    public function throws_404_if_no_link_found()
    {
        $response = $this->json('GET', '/', [ 'code' => 'abc' ]);

        $response->assertResponseStatus(404);

        $this->assertEmpty($this->response->getContent());
    }

    /**
     * @test Used count is incremented.
     *
     *
     * @return void
     */
    public function used_count_is_incremented()
    {
        $link = factory(Link::class)->create();

        $response = $this->json('GET', '/', [ 'code' => $link->code ]);
        $response = $this->json('GET', '/', [ 'code' => $link->code ]);
        $response = $this->json('GET', '/', [ 'code' => $link->code ]);

        $this->seeInDatabase('links', [
            'original_url' => $link->original_url,
            'used_count'   => 3
        ]);
    }

}
