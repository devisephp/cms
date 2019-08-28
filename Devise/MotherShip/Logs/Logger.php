<?php namespace Devise\Mothership\Logs;

use Devise\Mothership\Logs\Payload\Level;
use Devise\Mothership\Logs\Handlers\FatalHandler;
use Devise\Mothership\Logs\Handlers\ErrorHandler;
use Devise\Mothership\Logs\Handlers\ExceptionHandler;
use Illuminate\Support\Facades\App;

class Logger
{
    /**
     * @var Client
     */
    private static $client = null;
    private static $fatalHandler = null;
    private static $errorHandler = null;
    private static $exceptionHandler = null;

    public static function debug($toLog, $extra = array())
    {
        return self::log(Level::DEBUG, $toLog, $extra);
    }

    public static function info($toLog, $extra = array())
    {
        return self::log(Level::INFO, $toLog, $extra);
    }

    public static function notice($toLog, $extra = array())
    {
        return self::log(Level::NOTICE, $toLog, $extra);
    }

    public static function warning($toLog, $extra = array())
    {
        return self::log(Level::WARNING, $toLog, $extra);
    }

    public static function error($toLog, $extra = array())
    {
        return self::log(Level::ERROR, $toLog, $extra);
    }

    public static function critical($toLog, $extra = array())
    {
        return self::log(Level::CRITICAL, $toLog, $extra);
    }

    public static function alert($toLog, $extra = array())
    {
        return self::log(Level::ALERT, $toLog, $extra);
    }

    public static function emergency($toLog, $extra = array())
    {
        return self::log(Level::EMERGENCY, $toLog, $extra);
    }

    public static function flushAndWait()
    {
        if (is_null(self::$client))
        {
            return;
        }
        self::$client->flushAndWait();
    }

    private static function init(
        $configOrClient,
        $handleException = true,
        $handleError = true,
        $handleFatal = true
    )
    {
        $setupHandlers = is_null(self::$client);

        self::setLogger($configOrClient);

        if ($setupHandlers)
        {
            if ($handleException)
            {
                self::setupExceptionHandling();
            }
            if ($handleError)
            {
                self::setupErrorHandling();
            }
            if ($handleFatal)
            {
                self::setupFatalHandling();
            }
            self::setupBatchHandling();
        }
    }

    private static function setLogger($configOrClient)
    {
        if ($configOrClient instanceof Client)
        {
            $client = $configOrClient;
        }

        if (self::$client && !isset($client))
        {
            self::$client->configure($configOrClient);

            return;
        }

        self::$client = isset($client) ? $client : new Client($configOrClient);
    }

    private static function enable()
    {
        return self::logger()->enable();
    }

    private static function disable()
    {
        return self::logger()->disable();
    }

    private static function enabled()
    {
        return self::logger()->enabled();
    }

    private static function disabled()
    {
        return self::logger()->disabled();
    }

    private static function logger()
    {
        return self::$client;
    }

    private static function scope($config)
    {
        if (is_null(self::$client))
        {
            return new Client($config);
        }

        return self::$client->scope($config);
    }

    private static function log($level, $toLog, $extra = array(), $isUncaught = false)
    {
        if (is_null(self::$client))
        {
            self::init(['access_token' => config('devise.mothership.api-key'), 'environment' => App::environment()]);
        }

        return self::$client->log($level, $toLog, (array)$extra, $isUncaught);
    }

    private static function setupExceptionHandling()
    {
        self::$exceptionHandler = new ExceptionHandler(self::$client);
        self::$exceptionHandler->register();
    }

    private static function setupErrorHandling()
    {
        self::$errorHandler = new ErrorHandler(self::$client);
        self::$errorHandler->register();
    }

    private static function setupFatalHandling()
    {
        self::$fatalHandler = new FatalHandler(self::$client);
        self::$fatalHandler->register();
    }

    private static function getNotInitializedResponse()
    {
        return new Response(0, "Logs Not Initialized");
    }

    private static function setupBatchHandling()
    {
        register_shutdown_function('Devise\Mothership\Logs\Logger::flushAndWait');
    }

    private static function flush()
    {
        if (is_null(self::$client))
        {
            return;
        }
        self::$client->flush();
    }

    private static function addCustom($key, $value)
    {
        self::$client->addCustom($key, $value);
    }

    private static function removeCustom($key)
    {
        self::$client->removeCustom($key);
    }

    private static function getCustom()
    {
        self::$client->getCustom();
    }

    private static function configure($config)
    {
        self::$client->configure($config);
    }

    /**
     * Destroys the currently stored $client allowing for a fresh configuration.
     * This is especially used in testing scenarios.
     */
    private static function destroy()
    {
        self::$client = null;
    }

    // @codingStandardsIgnoreStart

    /**
     * Below methods are deprecated and still available only for backwards
     * compatibility. If you're still using them in your application, please
     * transition to using the ::log method as soon as possible.
     */

    /**
     * @param \Exception $exc Exception to be logged
     * @param array $extra_data Additional data to be logged with the exception
     * @param array $payload_data This is deprecated as of v1.0.0 and remains for
     * backwards compatibility. The content fo this array will be merged with
     * $extra_data.
     *
     * @return string uuid
     *
     * @deprecated 1.0.0 This method has been replaced by ::log
     */
    private static function report_exception($exc, $extra_data = null, $payload_data = null)
    {

        if ($payload_data)
        {
            $extra_data = array_merge($extra_data, $payload_data);
        }

        return self::log(Level::ERROR, $exc, $extra_data)->getUuid();
    }

    /**
     * @param string $message Message to be logged
     * @param string $level One of the values in Devise\Mothership\Logs\Payload\Level::$values
     * @param array $extra_data Additional data to be logged with the exception
     * @param array $payload_data This is deprecated as of v1.0.0 and remains for
     * backwards compatibility. The content fo this array will be merged with
     * $extra_data.
     *
     * @return string uuid
     *
     * @deprecated 1.0.0 This method has been replaced by ::log
     */
    private static function report_message($message, $level = null, $extra_data = null, $payload_data = null)
    {

        $level = $level ? $level : Level::ERROR;
        if ($payload_data)
        {
            $extra_data = array_merge($extra_data, $payload_data);
        }

        return self::log($level, $message, $extra_data)->getUuid();
    }


    /**
     * Catch any fatal errors that are causing the shutdown
     *
     * @deprecated 1.0.0 This method has been replaced by ::fatalHandler
     */
    private static function report_fatal_error()
    {
        self::$fatalHandler->handle();
    }


    /**
     * This function must return false so that the default php error handler runs
     *
     * @deprecated 1.0.0 This method has been replaced by ::log
     */
    private static function report_php_error($errno, $errstr, $errfile, $errline)
    {
        self::$errorHandler->handle($errno, $errstr, $errfile, $errline);

        return false;
    }

    // @codingStandardsIgnoreEnd
}
