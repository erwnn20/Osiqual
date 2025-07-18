<?php

namespace App\Http\Middleware\Company;

use App\Http\Middleware\Template as MiddlewareTemplate;
use App\Models\Company;
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
        $company = Company::findOrFail($request->route('id'));

        $this->condition = $user->role->permission_admin || $user->role->permission_technician;
        $this->code = Response::HTTP_FORBIDDEN;
        $this->message = 'Vous ne pouvez pas voir ce contrat.';
        $this->redirects = ['company.self' => $user->role->permission_client];

        return parent::handle($request, $next);
    }
}
