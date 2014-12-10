<?php namespace Devise\Support;

/**
 * Class DeviseResponse for some reason Illuminate\Support\Facades\Response
 * is not an actual facade but a real class. So we can't use getFacadeAccessor
 * on it. Instead we write a proxy class called DeviseResponse which simply
 * calls static methods on Request object.
 *
 * @package Devise\Support
 */
class DeviseResponse
{
    /**
     * Pretends to be a Facade for Response
     *
     * @return DeviseResponse
     */
    public static function getFacadeRoot()
    {
        return new self;
    }

    /**
     * Registers a macro
     *
     * @param $name
     * @param callable $macro
     */
    public function macro($name, callable $macro)
    {
        return Request::macro($name, $macro);
    }

    /**
     * Checks if macro is registered
     *
     * @param  string    $name
     * @return boolean
     */
    public function hasMacro($name)
    {
        return \Request::hasMacro($name);
    }

    /**
     * Return a new response from the application.
     *
     * @param  string  $content
     * @param  int     $status
     * @param  array   $headers
     * @return \Illuminate\Http\Response
     */
    public function make($content = '', $status = 200, array $headers = array())
    {
        return \Request::make($content, $status, $headers);
    }

    /**
     * Return a new view response from the application.
     *
     * @param  string  $view
     * @param  array   $data
     * @param  int     $status
     * @param  array   $headers
     * @return \Illuminate\Http\Response
     */
    public static function view($view, $data = array(), $status = 200, array $headers = array())
    {
        return \Request::view($view, $data, $status, $headers);
    }

    /**
     * Return a new JSON response from the application.
     *
     * @param  string|array  $data
     * @param  int    $status
     * @param  array  $headers
     * @param  int    $options
     * @return \Illuminate\Http\JsonResponse
     */
    public function json($data = array(), $status = 200, array $headers = array(), $options = 0)
    {
        return \Request::json($data, $status, $headers, $options);
    }

    /**
     * Return a new JSONP response from the application.
     *
     * @param  string  $callback
     * @param  string|array  $data
     * @param  int    $status
     * @param  array  $headers
     * @param  int    $options
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonp($callback, $data = [], $status = 200, array $headers = [], $options = 0)
    {
        return \Request::jsonp($callback, $data, $status, $headers, $options);
    }

    /**
     * Return a new streamed response from the application.
     *
     * @param  \Closure  $callback
     * @param  int      $status
     * @param  array    $headers
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function stream($callback, $status = 200, array $headers = array())
    {
        return \Request::stream($callback, $status, $headers);
    }

    /**
     * Create a new file download response.
     *
     * @param  \SplFileInfo|string  $file
     * @param  string  $name
     * @param  array   $headers
     * @param  null|string  $disposition
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($file, $name = null, array $headers = array(), $disposition = 'attachment')
    {
        return \Request::download($file, $name, $headers, $disposition);
    }
}