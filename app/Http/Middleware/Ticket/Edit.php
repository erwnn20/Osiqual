<?php

namespace App\Http\Middleware\Ticket;

use App\Http\Middleware\Template as MiddlewareTemplate;
use App\Models\Ticket;
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
        $ticket = Ticket::findOrFail($request->route('id'));

        $this->condition = $user->role->permission_technician
            || $ticket->client->is($user)
            || $ticket->company->id === $user->company->id;
        $this->code = Response::HTTP_FORBIDDEN;
        $this->message = 'Vous ne pouvez pas modifier ce ticket.';

        return parent::handle($request, $next);
    }
}
