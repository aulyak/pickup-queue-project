<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Closure;

class ApiKeyMiddleware
{
  public function handle($request, Closure $next)
  {
    $key = $request->header('x-api-key');

    if (!$key || $key !== config('app.api_key')) {
      throw new AuthenticationException('Wrong API Key');
    }

    return $next($request);
  }
}