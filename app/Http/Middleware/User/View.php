<?php

namespace App\Http\Middleware\User;

use App\Http\Middleware\Template as MiddlewareTemplate;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class View extends MiddlewareTemplate
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $userModel = User::findOrFail($request->route('id'));

        $this->condition = true;
        $this->code = Response::HTTP_FORBIDDEN;
        $this->message = 'Vous ne pouvez pas voir ce contrat.';
        $this->redirects = ['user.self' => !$user->role->permission_admin];

        return parent::handle($request, $next);
    }
}
