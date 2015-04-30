<?php namespace Devise\Support\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

	/**
	 * Routes that we should ignore
	 *
	 * @var array
	 */
	protected $ignore = [];

	/**
	 * Routes that we should ignore for devise
	 *
	 * @var array
	 */
	protected $ignoreDevise = [
		'api/notifications/zencoder'
	];

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($this->shouldIgnore($request))
		{
			return $this->addCookieToResponse($request, $next($request));
		}

		return parent::handle($request, $next);
	}

	/**
	 * Let's us ignore this request for CsrfToken validation
	 *
	 * @param  [type] $request
	 * @return [type]
	 */
	protected function shouldIgnore($request)
	{
		$ignore = array_merge($this->ignore, $this->ignoreDevise);

		foreach ($ignore as $url)
		{
			if ($request->is($url)) return true;
		}

		return false;
	}
}
