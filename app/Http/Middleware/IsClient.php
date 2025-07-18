<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsClient extends Template
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $this->condition = $user->role->permission_client;
        $this->code = Response::HTTP_FORBIDDEN;
        $this->message = 'Accès Client requis.';

        return parent::handle($request, $next);
    }
}
