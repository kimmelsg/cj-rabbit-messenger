<?php

namespace NavJobs\RabbitMessenger\Test\Integration;

class ConfigTest extends TestCase
{

    /**
     * @test
     */
    public function it_has_config_variables()
    {
        $this->assertEquals(config('rabbit-messenger.host'), 'localhost');
        $this->assertEquals(config('rabbit-messenger.port'), '5672');
        $this->assertEquals(config('rabbit-messenger.user'), 'guest');
        $this->assertEquals(config('rabbit-messenger.password'), 'guest');
    }
}