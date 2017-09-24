<?php

use App\Exceptions\CodeGenerationException;
use App\Link;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LinkStatsTest extends TestCase
{
    /**
     * @test Links stats can be shown by shortened code.
     *
     *
     * @return void
     */
    public function links_stats_can_be_shown_by_shortened_code()
    {
        $link = factory(Link::class)->create([
            'requested_count' => 5,
            'used_count'      => 234
        ]);

        $this->json('GET', '/stats', [
            'code' => $link->code
        ])
        ->seeJson($this->expectedJson($link))
        ->assertResponseStatus(200);
    }

    /**
     * @test Link stats fails if not found.
     *
     *
     * @return void
     */
    public function link_stats_fails_if_not_found()
    {
        $this->json('GET', '/stats', [ 'code' => 'avb'])
             ->assertResponseStatus(404);
    }

    /**
     * Expected Json to Link model
     *
     * @param  \App\Link   $link [description]
     *
     * @return array
     */
    protected function expectedJson(Link $link)
    {
        return [
            'original_url'    => $link->original_url,
            'shortened_url'   => $link->shortenedUrl(),
            'code'            => $link->code,
            'requested_count' => $link->requested_count,
            'used_count'      => $link->used_count,
            'created_at'      => $link->created_at->toDateTimeString(),
            'updated_at'      => $link->updated_at->toDateTimeString()
        ];
    }
}
