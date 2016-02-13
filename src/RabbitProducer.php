<?php

namespace NavJobs\RabbitMessenger;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitProducer
{
    /**
     * Create a new command instance.
     * @param AMQPStreamConnection $AMQPStreamConnection
     */
    public function __construct(AMQPStreamConnection $AMQPStreamConnection)
    {
        $this->connection = $AMQPStreamConnection;
    }

    /**
     * Send a RabbitMQ message
     *
     * @param $message
     * @param string $exchangeName
     * @return mixed
     */
    public function send($message, $exchangeName = 'default')
    {
        $message = json_encode($message);

        $channel = $this->connection->channel();

        $channel->exchange_declare(
            $exchange = $exchangeName,
            $type = 'direct',
            $passive = false,
            $durable = true,
            $auto_delete = false,
            $internal = false,
            $nowait = false,
            $arguments = null,
            $ticket = null
        );

        $message = new AMQPMessage($message, ['delivery_mode' => 2]);

        $channel->basic_publish(
            $msg = $message,
            $exchange = 'email_queue',
            $routing_key = '',
            $mandatory = false,
            $immediate = false,
            $ticket = null
        );

        $channel->close();
        $this->connection->close();
    }

}