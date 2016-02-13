<?php

namespace NavJobs\RabbitMessenger\Test\Integration;

use Illuminate\Support\Facades\App;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class AMWPStreamConnectionBindingTest extends TestCase
{

    /**
     * @test
     */
    public function it_binds_the_stream_to_the_app_and_config()
    {
        $stream = App::make(AMQPStreamConnection::class);

        $this->assertNotNull($stream);
    }
}