<?php

namespace NavJobs\RabbitMessenger\Test\Integration;

use NavJobs\RabbitMessenger\RabbitMessengerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [RabbitMessengerServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('rabbit-messenger.host', 'localhost');
        $app['config']->set('rabbit-messenger.port', 5672);
        $app['config']->set('rabbit-messenger.user', 'guest');
        $app['config']->set('rabbit-messenger.password', 'guest');
    }
}