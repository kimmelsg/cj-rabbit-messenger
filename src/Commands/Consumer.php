<?php

namespace NavJobs\RabbitMessenger\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Consumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbit:consume
                            {handlerName : the class name of the handler}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consumes messages from Rabbit MQ using the specified handler';

    private $connection;

    /**
     * Create a new command instance.
     * @param AMQPStreamConnection $AMQPStreamConnection
     */
    public function __construct(AMQPStreamConnection $AMQPStreamConnection)
    {
        parent::__construct();
        $this->connection = $AMQPStreamConnection;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $handler = app($this->argument('handlerName'));
        $exchangeName = $handler->getExchangeName();
        $queueName = method_exists($handler, 'getQueueName') ? $handler->getQueueName() : '';
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

        list($queue_name, ,) = $channel->queue_declare(
            $queue = $queueName,
            $passive = false,
            $durable = true,
            $exclusive = false,
            $auto_delete = true,
            $nowait = false,
            $arguments = null,
            $ticket = null
        );

        $channel->queue_bind(
            $queue = $queue_name,
            $exchange = $exchangeName,
            $routing_key = '',
            $nowait = false,
            $arguments = null,
            $ticket = null
        );

        $channel->basic_qos(
            $prefetch_size = null,
            $prefetch_count = 1,
            $a_global = null
        );

        $channel->basic_consume(
            $queue = $queue_name,
            $consumer_tag = '',
            $no_local = false,
            $no_ack = false,
            $exclusive = false,
            $nowait = false,
            function ($message) use ($handler) {
                $handler->handle($message->getBody());
                $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
            },
            $ticket = null,
            $arguments = []
        );

        while(count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $this->connection->close();
    }
}
