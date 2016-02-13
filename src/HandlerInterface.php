<?php

namespace NavJobs\RabbitMessenger;

interface HandlerInterface
{
    /**
     * Implement a method to return the exchange name the handler should listen to.
     *
     * @return mixed
     */
    public function getExchangeName();

    /**
     * Implement a method to operate on the message.
     *
     * @param $message
     * @return mixed
     */
    public function handle($message);

}