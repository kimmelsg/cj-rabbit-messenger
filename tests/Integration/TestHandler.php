<?php

namespace NavJobs\RabbitMessenger\Test\Integration;

use NavJobs\RabbitMessenger\HandlerInterface;

class TestHandler implements HandlerInterface
{
    protected $exchangeName = 'test';

    /**
     * Implement a method to return the exchange name the handler should listen to.
     *
     * @return mixed
     */
    public function getExchangeName()
    {
        return $this->exchangeName;
    }

    /**
     * Implement a method to operate on the message.
     *
     * @param $message
     * @return mixed
     */
    public function handle($message)
    {
        dd('what');
    }
}