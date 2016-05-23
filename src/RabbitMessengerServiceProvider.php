<?php

namespace NavJobs\RabbitMessenger;

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

        $this->app->bind(AMQPStreamConnection::class, function ($app) {
            return new AMQPStreamConnection(
                config('rabbit-messenger.host'),
                config('rabbit-messenger.port'),
                config('rabbit-messenger.user'),
                config('rabbit-messenger.password')
            );
        });

        $this->app->bind('command.rabbit.consume', function ($app) {
            return $app['NavJobs\RabbitMessenger\Commands\Consumer'];
        });

        $this->commands('command.rabbit.consume');
    }
}