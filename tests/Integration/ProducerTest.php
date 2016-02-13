<?php

namespace NavJobs\RabbitMessenger\Test\Integration;

use Mockery;
use NavJobs\RabbitMessenger\Producer;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ProducerTest extends TestCase
{

    /**
     * @test
     */
    public function it_sends_a_message_to_rabbit_mq()
    {
        $stream = Mockery::spy(AMQPStreamConnection::class);
        $stream->shouldReceive('channel')
            ->once()
            ->andReturn(
                $channel = Mockery::spy(AMQPChannel::class)
            );

        $producer = new Producer($stream);
        $producer->send('test');

        $channel->shouldHaveReceived('exchange_declare');
        $channel->shouldHaveReceived('basic_publish');

        Mockery::close();
    }
}