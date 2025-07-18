<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\IsActive;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsClient;
use App\Http\Middleware\IsTechnician;
use App\Http\Middleware\Ticket;
use App\Http\Middleware\Contract;
use App\Http\Middleware\Company;
use App\Http\Middleware\User;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => Authenticate::class,
            'active' => IsActive::class,

            'admin' => IsAdmin::class,
            'tech' => IsTechnician::class,
            'client' => IsClient::class,

            'ticket.index' => Ticket\Index::class,
            'ticket.new' => Ticket\Create::class,
            'ticket.edit' => Ticket\Edit::class,
            'ticket.step.edit' => Ticket\StepEdit::class,
            'ticket.view' => Ticket\View::class,

            'contract.index' => Contract\Index::class,
            'contract.new' => Contract\Create::class,
            'contract.edit' => Contract\Edit::class,
            'contract.view' => Contract\View::class,

            'company.index' => Company\Index::class,
            'company.new' => Company\Create::class,
            'company.edit' => Company\Edit::class,
            'company.view' => Company\View::class,

            'user.index' => User\Index::class,
            'user.new' => User\Create::class,
            'user.edit' => User\Edit::class,
            'user.view' => User\View::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
