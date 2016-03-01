<?php

namespace Devise\Pages\Http\Middleware;

use App;
use DeviseUser;
use Closure;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $name)
    {
    	if (App::runningInConsole()) return $next($request);

		$result = DeviseUser::checkConditions($name, true);

        if ($result !== true)
        {
            if (!$request->ajax())
            {
                return $result;
            }
            else
            {
            	return response('Unauthorized action.', 403);
            }
        }

        return $next($request);
    }
}
