<?php

namespace NavJobs\RabbitMessenger\Test\Integration;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use NavJobs\RabbitMessenger\Producer;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ProducerTest extends TestCase
{

    /**
     * @test
     */
    public function it_consumes_a_message_and_calls_the_specified_handler()
    {
        $stream = Mockery::mock(AMQPStreamConnection::class);
        $producer = App::make(Producer::class);

        $producer->send('test');


        $stream->shouldHaveReceived('channel');
    }
}