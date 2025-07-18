<?php

namespace App\Http\Middleware\Contract;

use App\Http\Middleware\Template as MiddlewareTemplate;
use App\Models\Contract;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Edit extends MiddlewareTemplate
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $contract = Contract::findOrFail($request->route('id'));

        $this->condition = true;
        $this->code = Response::HTTP_FORBIDDEN;
        $this->message = 'Vous ne pouvez pas modifier ce contrat.';

        return parent::handle($request, $next);
    }
}
