<?php

namespace NavJobs\RabbitMessenger\Test\Integration;

use Illuminate\Support\Facades\Artisan;

class ConsumerTest extends TestCase
{

    /**
     * @test
     */
    public function it_consumes_a_message_and_calls_the_specified_handler()
    {
//        Artisan::call('rabbit:consume', [
//            'handlerName' => TestHandler::class
//        ]);
    }
}