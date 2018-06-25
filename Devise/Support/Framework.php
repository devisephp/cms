<?php namespace Devise\Support;

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;

/**
 * Class Framework wraps important components that we
 * use from Laravel's framework. Components like Config,
 * Validator, Request, Response...
 *
 * @package Devise\Support
 */
class Framework
{
  /**
   * Magic method so we can call $this->Config instead of $this->Config()
   *
   * @param $name
   * @return mixed
   */
  public function __get($name)
  {
    $this->$name = $this->resolveProperty($name);

    return $this->$name;
  }

  /**
   * Returns a valid property
   *
   * @param $name
   * @return mixed
   */
  private function resolveProperty($name)
  {
    $name = strtolower($name);

    switch ($name)
    {
      case 'artisan':                 // 'Illuminate\Contracts\Console\Kernel'
        return \Artisan::getFacadeRoot();
        break;

      case 'auth':                    // Illuminate\Auth\Guard
        return \Auth::getFacadeRoot();
        break;

      case 'cache':                  // Illuminate\Cache\CacheManager
        return \Cache::getFacadeRoot();
        break;

      case 'config':                  // Illuminate\Config\Repository
        return \Config::getFacadeRoot();
        break;

      case 'cookie':                  // Illuminate\Support\Facades\Cookie
        return \Cookie::getFacadeRoot();
        break;

      case 'container':               // Illuminate\Container\Container
        return \App::getFacadeRoot();
        break;

      case 'db':                      // Illuminate\Database\DatabaseManager
        return \DB::getFacadeRoot();
        break;

      case 'file':                    // Illuminate\Filesystem\Filesystem
        return \File::getFacadeRoot();
        break;

      case 'event':                   // Illuminate\Config\Repository
        return \Event::getFacadeRoot();
        break;

      case 'exception':               // DeviseException
        return DeviseException::getFacadeRoot();
        break;

      case 'hash':                    // Illuminate\Hashing\BcryptHasher
        return \Hash::getFacadeRoot();
        break;

      case 'lang':                    // Illuminate\Translation\Translator
        return \Lang::getFacadeRoot();
        break;

      case 'mail':                    // Illuminate\Mail\Mailer
        return \Mail::getFacadeRoot();
        break;

      case 'paginator':
        return new DevisePaginator;
        break;

      case 'password':                // Illuminate\Auth\Reminders\PasswordBroker
        return \Password::getFacadeRoot();
        break;

      case 'redirect':                // Illuminate\Routing\Redirector
        return \Redirect::getFacadeRoot();
        break;

      case 'response':                // DeviseResponse
        return DeviseResponse::getFacadeRoot();
        break;

      case 'request':                 // Illuminate\Http\Request
        return \Request::getFacadeRoot();
        break;

      case 'route':                   // Illuminate\Routing\Router
        return \Route::getFacadeRoot();
        break;

      case 'schema':
        return \Schema::getFacadeRoot();
        break;

      case 'session':                 // Illuminate\Session\SessionManager
        return \Session::getFacadeRoot();
        break;

      case 'url':                     // Illuminate\Routing\UrlGenerator
        return \URL::getFacadeRoot();
        break;

      case 'validator':               // Illuminate\Validation\Factory
        return \Validator::getFacadeRoot();
        break;

      case 'view':                    // Illuminate\View\Factory
        return \View::getFacadeRoot();
        break;

      case 'storage':                 // Illuminate\Support\Facades\Storage
        return Storage::getFacadeRoot();
        break;

      case 'mimetypeguesser':
        return MimeTypeGuesser::getInstance();
        break;
    }

    return null;
  }

  public static function storage()
  {
    return Storage::disk(config('devise.media.disk'));
  }
}