<?php

namespace NavJobs\RabbitMessenger\Traits;

use Mockery;

trait PreventMessageProduction
{
    /**
     * @before
     */
    public function preventRabbitProduction()
    {
        $this->app->bind(Producer::class, function ($app) {
            $producer = Mockery::mock(Producer::class);
            $producer->shouldReceive('send')->andReturnNull();
            return $producer;
        });
    }
}
