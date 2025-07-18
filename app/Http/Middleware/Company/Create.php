<?php

namespace App\Http\Middleware\Company;

use App\Http\Middleware\Template as MiddlewareTemplate;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Create extends MiddlewareTemplate
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->condition = true;
        $this->code = Response::HTTP_FORBIDDEN;
        $this->message = 'Accès création Société refusé.';

        return parent::handle($request, $next);
    }
}
