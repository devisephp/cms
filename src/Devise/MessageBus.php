<?php namespace Devise;

use App, Event, Config;

trait MessageBus
{
    /**
     * Fire an event
     *
     * @param  string  $event
     * @param  mixed   $payload
     * @param  bool    $halt
     * @return array|null
     */
    protected function fire($event, $payload = array(), $halt = false)
    {
        return Event::fire($event, $payload, $halt);
    }

    /**
     * Resolve things from the IoC container
     *
     * @param  string $abstract
     * @param  array  $parameters
     * @return mixed
     */
    protected function resolve($abstract, $parameters = array())
    {
        return App::make($abstract, $parameters);
    }

    /**
     * Get the configuration for this path from Laravel
     *
     * @param  string $path
     * @param  mixed  $defaultValue
     * @return mixed
     */
    protected function config($path, $defaultValue = null)
    {
        return Config::get($path, $defaultValue);
    }
}