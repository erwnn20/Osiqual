<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class Template
{
    protected bool $condition;
    protected int $code;
    protected string $message;

    /**
     * Liste des redirections possibles.
     *
     * @var array<string, bool> [route => condition]
     */
    protected array $redirects = [];

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->condition) return $next($request);

        foreach ($this->redirects as $route => $condition)
            if ($condition)
                return to_route($route);

        abort($this->code, $this->message);
    }
}
