<?php

namespace App\Http\Middleware\User;

use App\Http\Middleware\Template as MiddlewareTemplate;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Index extends MiddlewareTemplate
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $this->condition = true;
        $this->code = Response::HTTP_FORBIDDEN;
        $this->message = 'Accès indexation Sociétés refusé.';
        $this->redirects = ['user.self' => !$user->role->permission_admin];

        return parent::handle($request, $next);
    }
}
