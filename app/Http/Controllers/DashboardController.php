<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        if ($user->role->permission_admin)
            return view('dashboard.index', [
                'cards' => [
                    [
                        'icon' => 'ticket',
                        'value' => Ticket::where('status_id', Ticket\TicketStatus::inProgress()->id)->count(),
                        'title' => 'Tickets en Cours',
                    ],
                    [
                        'icon' => 'ticket',
                        'value' => Ticket::where('technician_id', null)->count(),
                        'title' => 'Tickets Non Attribués',
                    ],
                    [
                        'icon' => 'file-text',
                        'value' => Contract::all()
                            ->filter(fn($contract) => $contract->status->id === Contract\ContractStatus::inProgress()->id)
                            ->count(),
                        'title' => 'Contrats en Cours',
                    ],
                    [
                        'icon' => 'building-2',
                        'value' =>  Company::all()->filter(fn(Company $company) => $company->currentContract() === null)->count(),
                        'title' => 'Sociétés sans Contract',
                    ],
                ],
                'tickets' => [
                    'data' => Ticket::orderBy('creation_date', 'desc')->limit(8)->get(),
                    'count' => Ticket::count(),
                    'edit' => true
                ],
                'contracts' => [
                    'data' => Contract::orderBy('start_date', 'desc')->limit(5)->get(),
                    'count' => Contract::count(),
                    'edit' => false
                ],
            ]);
        elseif ($user->role->permission_technician)
            return view('dashboard.index', [
                'cards' => [
                    [
                        'icon' => 'ticket',
                        'value' => Ticket::where('status_id', Ticket\TicketStatus::inProgress()->id)->count(),
                        'title' => 'Tickets en Cours',
                    ],
                    [
                        'icon' => 'ticket',
                        'value' => Ticket::where('technician_id', null)->count(),
                        'title' => 'Tickets Non Attribués',
                    ],
                    [
                        'icon' => 'file-text',
                        'value' => Contract::all()
                            ->filter(fn($contract) => $contract->status->id === Contract\ContractStatus::inProgress()->id)
                            ->count(),
                        'title' => 'Contrats en Cours',
                    ],
                ],
                'tickets' => [
                    'data' => Ticket::orderBy('creation_date', 'desc')->limit(8)->get(),
                    'count' => Ticket::count(),
                    'edit' => true
                ],
                'contracts' => [
                    'data' => Contract::orderBy('start_date', 'desc')->limit(5)->get(),
                    'count' => Contract::count(),
                    'edit' => false
                ],
            ]);
        elseif ($user->role->permission_client) {
            $remaining = $user->company->currentContract()?->durationRemaining() ?? 0;
            $remainingHours = round($remaining / 60, 1);

            return view('dashboard.client', [
                'cards' => [
                    [
                        'icon' => 'ticket',
                        'value' => $user->company->tickets()->where('status_id', Ticket\TicketStatus::inProgress()->id)->count(),
                        'title' => "Tickets en Cours de {$user->company->name}",
                    ],
                    [
                        'icon' => 'ticket',
                        'value' => $user->company->tickets()->count(),
                        'title' => "Total Tickets de {$user->company->name}",
                    ],
                    [
                        'icon' => 'file-text',
                        'value' => "$remainingHours h",
                        'title' => 'Temps de Contrat restant',
                    ],
                ],
                'tickets' => [
                    'data' => $user->company->tickets()->orderBy('creation_date', 'desc')->limit(10)->get(),
                    'count' => $user->company->tickets()->count(),
                    'edit' => true
                ],
                'contract' => $user->company->currentContract(),
            ]);
        }

        abort(Response::HTTP_FORBIDDEN);
    }
}
