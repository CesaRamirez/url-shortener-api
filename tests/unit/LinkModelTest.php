<?php

use App\Exceptions\CodeGenerationException;
use App\Link;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LinkModelTest extends TestCase
{
    protected $mappings = [
        1         => 1,
        100       => '1C',
        1000000   => '4c92',
        999999999 => '15FTGf'
     ];

    /**
     * @test Correct code is generated.
     *
     *
     * @return void
     */
    public function correct_code_is_generated()
    {
        $link = new Link;

        foreach ($this->mappings as $id => $expectedCode) {
            $link->id = $id;
            $this->assertEquals($link->getCode(), $expectedCode);
        }
    }

    /**
     * @test Exception is thrwon with no id.
     *
     *
     * @return void
     */
    public function exception_is_thrown_with_no_id()
    {
        $this->expectException(CodeGenerationException::class);

        $link = new Link;
        $link->getCode();
    }

    /**
     * @test Can get model by Code.
     *
     *
     * @return void
     */
    public function can_get_model_by_code()
    {
        $link = factory(App\Link::class)->create([
            'code' => 'abc'
        ]);

        $model = $link->byCode($link->code)->first();

        $this->assertInstanceOf(Link::class, $model);
        $this->assertEquals($model->original_url, $link->original_url);
    }

    /**
     * @test Can get Shortened URL from Link model
     *
     *
     * @return void
     */
    public function can_get_shortened_url_from_link_model()
    {
        $link = factory(App\Link::class)->create([
            'code' => 'abc'
        ]);

        $this->assertEquals($link->shortenedUrl(),                                                  env('CLIENT_URL') . '/' . $link->code);
    }

    /**
     * @test Null is returned when no Code present on Model.
     *
     *
     * @return void
     */
    public function null_is_returned_for_shortened_url_when_no_code_present_on_model()
    {
        Link::flushEventListeners();
        $link = factory(App\Link::class)->create();

        $this->assertNull($link->shortenedUrl());
    }

}
