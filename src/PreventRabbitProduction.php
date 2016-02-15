<?php

namespace NavJobs\RabbitMessenger;

use Mockery;

trait PreventRabbitProduction
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
