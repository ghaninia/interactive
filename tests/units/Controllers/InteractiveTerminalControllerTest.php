<?php

namespace GhaniniaIR\Tests\Units\Controllers;

use Illuminate\Http\Response;
use GhaniniaIR\Tests\TestCase;
use GhaniniaIR\Tests\Units\Utilies\Cache\Drivers\Traits\FileCacheTrait;

class InteractiveTerminalControllerTest extends TestCase
{
    use FileCacheTrait;

    /** @test */
    public function pushNewSentenceToTerminal()
    {
        $response = $this->postJson(
            route("interactive.set"),
            [
                "sentence" => '$name = "hello world";'
            ]
        );

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                "result" => [
                    "hello world"
                ]
            ]);
    }
    
    /** @test */
    public function errValidationTerminal()
    {
        $response = $this->postJson(
            route("interactive.set"),
        );

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                "sentence"
            ]);
    }

    /** @test */
    public function errMiddlewareTerminal()
    {
        config()->set("interactive.route.middlewares" , [
            "auth"
        ]);

        $response = $this->postJson(
            route("interactive.set"),
            [
                "sentence" => '$name = "hello world";'
            ]
        );

        $response->assertStatus(Response::HTTP_UNAUTHORIZED) ;
    }
}
