<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsActive extends Template
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $this->condition = $user->active;
        $this->code = Response::HTTP_FORBIDDEN;
        $this->message = 'Compte Bloqué.';

        return parent::handle($request, $next);
    }
}
