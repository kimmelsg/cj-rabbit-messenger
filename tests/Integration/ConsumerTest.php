<?php

namespace NavJobs\RabbitMessenger\Test\Integration;

use Illuminate\Support\Facades\Artisan;
use Mockery;

class ConsumerTest extends TestCase
{

    /**
     * @test
     */
    public function it_consumes_a_message_and_calls_the_specified_handler()
    {
//        $handler = Mockery::spy(TestHandler::class);
//
//        Artisan::call('rabbit:consume', [
//            'handlerName' => TestHandler::class
//        ]);
//
//        $handler->shouldHaveReceived('handle');
    }
}