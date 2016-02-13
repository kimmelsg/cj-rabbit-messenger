<?php

namespace NavJobs\rabbitMessenger;

use Illuminate\Support\ServiceProvider;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMessengerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/rabbit-messenger.php' => config_path('rabbit-messenger.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/rabbit-messenger.php', 'rabbit-messenger');

        $this->app->singleton(AMQPStreamConnection::class, function ($app) {
            return new AMQPStreamConnection(
                config('rabbitmq.host'),
                config('rabbitmq.port'),
                config('rabbitmq.user'),
                config('rabbitmq.password')
            );
        });

        $this->app->singleton('command.rabbit.consume', function ($app) {
            return $app['NavJobs\rabbit-messenger\Commands\Consume'];
        });

        $this->commands('command.rabbit.consume');
    }
}