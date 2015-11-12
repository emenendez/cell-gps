<?php namespace App\Http\Middleware;

use Closure;

class DisableSessions {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		/**
		 * Disables sessions for any routes using this middleware
		 */
		// config(['session.driver' => 'array']);
		// TODO: Disable sessions
		return $next($request);
	}

}
