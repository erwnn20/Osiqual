<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Contract;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Ticket;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketStepController;
use App\Http\Controllers\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', fn() => redirect()->route('index'));

Route::prefix('/auth')->name('auth.')->controller(AuthController::class)->group(function () {
    Route::view('/login', 'auth.login')->name('login')->middleware('guest');
    Route::post('/login', 'login')->name('login')->middleware('guest');
    Route::delete('/logout', 'logout')->name('logout')->middleware('auth');
});

Route::prefix('/')->middleware(['auth', 'active'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');

    $statusCallback = function () {
        Route::get('/', 'index')->name('index');

        Route::post('/new', 'create')->name('new');

        Route::get('/edit/{id}', 'edit')->name('edit')->whereUuid('id');
        Route::patch('/edit/{id}', 'update')->name('edit')->whereUuid('id');
        Route::delete('/delete/{id}', 'delete')->name('delete')->whereUuid('id');

        Route::get('/view/{id}', 'view')->name('view')->whereUuid('id');
    };

    Route::prefix('/ticket')->name('ticket.')->controller(TicketController::class)
        ->group(function () use ($statusCallback) {
            Route::get('/', 'index')->name('index')->middleware('ticket.index');

            Route::get('/new', 'new')->name('new')->middleware('ticket.new');
            Route::post('/new', 'create')->name('new')->middleware('ticket.new');
            Route::post('/new/by-client', 'createByClient')->name('new.client')->middleware('ticket.new');

            Route::get('/edit/{id}', 'edit')->name('edit')
                ->middleware('ticket.edit')->whereUuid('id');
            Route::patch('/edit/{id}', 'update')->name('edit')
                ->middleware('ticket.edit')->whereUuid('id');
            Route::patch('/edit/{id}/by-client', 'updateByClient')->name('edit.client')
                ->middleware('ticket.edit')->whereUuid('id');

            Route::get('/view/{id}', 'view')->name('view')
                ->middleware('ticket.view')->whereUuid('id');

            Route::prefix('/{ticket}/step')->name('step.')->whereUuid('ticket')
                ->controller(TicketStepController::class)->middleware(['tech', 'ticket.step.edit'])
                ->group(function () {
                    Route::post('/new', 'create')->name('new');
                    Route::delete('/delete/{id}', 'delete')->name('delete')
                        ->whereUuid('id');
                });

            Route::prefix('/status')->name('status.')->controller(Ticket\StatusController::class)
                ->middleware('admin')->group($statusCallback);

            Route::prefix('/priority')->name('priority.')->controller(Ticket\PriorityController::class)
                ->middleware('admin')->group($statusCallback);

            Route::prefix('/criticality')->name('criticality.')->controller(Ticket\CriticalityController::class)
                ->middleware('admin')->group($statusCallback);
        });

    Route::prefix('/contract')->name('contract.')->controller(ContractController::class)
        ->group(function () use ($statusCallback) {
            Route::get('/', 'index')->name('index')->middleware('contract.index');

            Route::get('/new', 'new')->name('new')->middleware(['admin', 'contract.new']);
            Route::post('/new', 'create')->name('new')->middleware(['admin', 'contract.new']);

            Route::get('/edit/{id}',
                fn(string $id) => redirect()->route('contract.view', ['id' => $id]))
                ->name('edit')->whereUuid('id');

            Route::get('/view/{id}', 'view')->name('view')
                ->middleware('contract.view')->whereUuid('id');

            Route::prefix('/status')->name('status.')->controller(Contract\StatusController::class)
                ->middleware('admin')->group($statusCallback);

            Route::prefix('/type')->name('type.')->controller(Contract\TypeController::class)
                ->middleware('admin')->group($statusCallback);
        });

    Route::prefix('/company')->name('company.')->controller(CompanyController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index')->middleware('company.index');

            Route::get('/new', 'new')->name('new')->middleware(['admin', 'company.new']);
            Route::post('/new', 'create')->name('new')->middleware(['admin', 'company.new']);

            Route::get('/edit/{id}', 'edit')->name('edit')
                ->middleware(['admin', 'company.edit'])->whereUuid('id');
            Route::patch('/edit/{id}', 'update')->name('edit')
                ->middleware(['admin', 'company.edit'])->whereUuid('id');

            Route::get('/view/{id}', 'view')->name('view')
                ->middleware('company.view')->whereUuid('id');

            Route::get('/self', 'self')->name('self');
        });

    Route::prefix('/user')->name('user.')->controller(UserController::class)
        ->group(function () use ($statusCallback) {
            Route::get('/', 'index')->name('index')->middleware('user.index');

            Route::get('/new', 'new')->name('new')->middleware(['admin', 'user.new']);
            Route::post('/new', 'create')->name('new')->middleware(['admin', 'user.new']);

            Route::get('/edit/{id}', 'edit')->name('edit')
                ->middleware(['admin', 'user.edit'])->whereUuid('id');
            Route::patch('/edit/{id}', 'update')->name('edit')
                ->middleware(['admin', 'user.edit'])->whereUuid('id');
            Route::patch('/block/{id}', 'block')->name('block')
                ->middleware(['admin', 'user.edit'])/*->whereUuid('id')*/
            ;
            Route::patch('/unblock/{id}', 'unblock')->name('unblock')
                ->middleware(['admin', 'user.edit'])->whereUuid('id');

            Route::get('/view/{id}', 'view')->name('view')
                ->middleware('user.view')->whereUuid('id');

            Route::prefix('/role')->name('role.')->controller(User\RoleController::class)
                ->middleware('admin')->group($statusCallback);
        });

    Route::get('/profile', [UserController::class, 'self'])->name('user.self');
    Route::patch('/profile', [UserController::class, 'updateSelf'])->name('user.self');
});

//

Route::get('/test', function () {
    return view('test', [
        'opts' => [
            ['type' => 'option', 'value' => 'opt-default', 'label' => 'Default'],
            ['type' => 'opt', 'value' => 'opt-no-label'],
            ['value' => 'opt-no-type-label'],
            [
                'type' => 'group',
                'label' => 'Group Name',
                'value' => [
                    ['value' => 'group-opt-1'],
                    ['value' => 'group-opt-2'],
                ],
            ],
            [
                'type' => 'optgroup',
                'label' => 'Group Name',
                'value' => [
                    ['value' => 'optgroup-opt-1'],
                    ['value' => 'optgroup-opt-2'],
                ],
            ],
        ]
    ]);
})->name('test');
