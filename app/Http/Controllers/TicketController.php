<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketClientRequest;
use App\Http\Requests\TicketRequest;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{
    /**
     * Temps limite de contrat restant pour attribution à un ticket (en minute)
     */
    private static int $attributionTimeLimit = 10;

    public function index(Request $request): View
    {
        $user = $request->user();
        if ($user->role->permission_technician)
            return view('object.index', [
                'cards' => [
                    [
                        'icon' => 'ticket',
                        'value' => $user->tickets()->where('status_id', Ticket\TicketStatus::inProgress()->id)->count(),
                        'title' => 'Vos Tickets en Cours',
                    ],
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
                ],
                'data' => Ticket::orderByDesc('creation_date')->paginate(8),
                'create' => true,
                'edit' => true,

                'icon' => 'ticket',
                'header' => 'Tickets',
                'title' => 'Tous les Tickets',
            ]);
        elseif ($user->role->permission_client) {
            $remaining = $user->company->currentContracts('attributable')
                ->sum(fn(Contract $contract) => $contract->durationRemaining());
            $remainingHours = round($remaining / 60, 1);

            return view('object.index', [
                'cards' => [
                    [
                        'icon' => 'ticket',
                        'value' => $user->tickets()->where('status_id', Ticket\TicketStatus::inProgress()->id)->count(),
                        'title' => 'Vos Tickets en Cours',
                    ],
                    [
                        'icon' => 'ticket',
                        'value' => $user->company->tickets()->where('status_id', Ticket\TicketStatus::inProgress()->id)->count(),
                        'title' => "Tickets en Cours de {$user->company->name}",
                    ],
                    [
                        'icon' => 'file-text',
                        'value' => "$remainingHours h",
                        'title' => 'Temps de Contrat restant',
                    ],
                ],
                'data' => $user->company->tickets()->orderByDesc('creation_date')->paginate(8),
                'create' => true,
                'edit' => false,

                'icon' => 'ticket',
                'header' => 'Tickets',
                'title' => "Tous les Tickets de {$user->company->name}",
            ]);
        }

        abort(Response::HTTP_FORBIDDEN);
    }

    public function new(Request $request): View
    {
        $user = $request->user();

        if ($user->role->permission_technician)
            return view('object.ticket.new', [
                'clients' => self::clients(),
                'technicians' => self::technicians(),
                'statuses' => self::statuses(),
                'priorities' => self::priorities(),
                'criticalities' => self::criticalities(),
            ]);

        elseif ($user->role->permission_client)
            return view('object.ticket.client.new', [
                'contract' => $user->company->currentContract(),
            ]);

        abort(Response::HTTP_FORBIDDEN);
    }

    public function create(TicketRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        $creationDate = $credentials['creation']
            ? Carbon::parse($credentials['creation'])->floorMinute()
            : now()->floorMinute();
        $duration = $credentials['duration'] ?? 0;

        $client = User::find($credentials['client']);

        $companyContracts = $client->company->currentContracts('attributable', $creationDate);
        $contract = $companyContracts->first(fn(Contract $contract) => $contract->durationRemaining() >= max($duration, self::$attributionTimeLimit));

        if ($companyContracts->count() === 0) {
            return back()->withErrors([
                'creation' => "L'entreprise sélectionnée n'a pas ce contrat à cette date.",
            ])->withInput(array_merge(request()->all(), [
                'creation' => $creationDate,
            ]));
        } elseif (!$contract) {
            $timeLimit = self::$attributionTimeLimit;
            return back()->withErrors([
                'duration' =>
                    "Le contrat de l'entreprise sélectionnée ne dispose pas de contrat, à la date choisie, avec un temps restant suffisant."
                    . ($duration < self::$attributionTimeLimit ? " (min: $timeLimit minutes)" : ''),
            ])->withInput(array_merge(request()->all(), [
                'creation' => $creationDate,
            ]));
        }

        $ticket = Ticket::create([
            'technician_id' => $credentials['technician'] ?? null,
            'client_id' => $client->id,
            'title' => $credentials['title'],
            'description' => $credentials['description'] ?? null,
            'duration' => $duration,
            'status_id' => $credentials['status'],
            'priority_id' => $credentials['priority'],
            'criticality_id' => $credentials['criticality'],
            'creation_date' => $creationDate,
            'end_date' => $credentials['end'] ?? null,
        ]);

        return to_route('ticket.edit', ['id' => $ticket->id])
            ->with('success', 'Le ticket a été créé avec succès.');
    }

    public function createByClient(TicketClientRequest $request): RedirectResponse
    {
        $user = $request->user();
        $credentials = $request->validated();

        $creationDate = now()->floorMinute();

        $companyContracts = $user->company->currentContracts('attributable', $creationDate);
        $contract = $companyContracts->first(fn(Contract $contract) => $contract->durationRemaining() >= self::$attributionTimeLimit);

        if ($companyContracts->count() === 0) {
            return back()->withErrors([
                'creation' => "Votre entreprise n'a pas ce contrat pour la période en cours.",
            ])->withInput(array_merge(request()->all(), [
                'creation' => $creationDate,
            ]));
        } elseif (!$contract) {
            $timeLimit = self::$attributionTimeLimit;
            return back()->withErrors([
                'duration' =>
                    "Votre entreprise n'a pas de contrat avec un temps restant suffisant pour la période en cours. (min: $timeLimit minutes)",
            ])->withInput(array_merge(request()->all(), [
                'creation' => $creationDate,
            ]));
        }

        $ticket = Ticket::create([
            'client_id' => $user->id,
            'title' => $credentials['title'],
            'description' => $credentials['description'],
            'status_id' => Ticket\TicketStatus::all()
                ->where('value', 1)->first()->id,
            'priority_id' => Ticket\TicketPriority::all()
                ->where('value', 1)->first()->id,
            'criticality_id' => Ticket\TicketCriticality::all()
                ->where('value', 1)->first()->id,
            'creation_date' => $creationDate,
        ]);

        return to_route('ticket.view', ['id' => $ticket->id])
            ->with('success', 'Le ticket a été créé avec succès.');
    }

    public function edit(Request $request, string $id): View
    {
        $user = $request->user();

        return view('object.ticket.edit', [
            'ticket' => $ticket = Ticket::findOrFail($id),

            'clients' => self::clients($ticket->company),
            'technicians' => self::technicians(),
            'statuses' => self::statuses(),
            'priorities' => self::priorities(),
            'criticalities' => self::criticalities(),
        ]);
    }

    public function update(TicketRequest $request, string $id): RedirectResponse
    {
        $ticket = Ticket::findOrFail($id);
        $credentials = $request->validated();

        $duration = $credentials['duration'] ?? 0;
        $contract = $ticket->contract;

        if ($contract->durationRemaining() < $duration) {
            return back()->withErrors([
                'duration' => "Le contrat de l'entreprise sélectionnée à la date choisie ne dispose pas d'un temps restant suffisant.",
            ])->withInput();
        }

        $ticket->update([
            'technician_id' => $credentials['technician'] ?? null,
            'client_id' => $credentials['client'],
            'title' => $credentials['title'],
            'description' => $credentials['description'] ?? null,
            'duration' => $duration,
            'status_id' => $credentials['status'],
            'priority_id' => $credentials['priority'],
            'criticality_id' => $credentials['criticality'],
            'end_date' => $credentials['end'] ?? null,
        ]);

        return back()->with('success', 'Le ticket a été mis à jour avec succès.');
    }

    public function view(string $id): View
    {
        return view('object.ticket.view', [
            'ticket' => Ticket::findOrFail($id),

            'clients' => self::clients(),
            'technicians' => self::technicians(),
            'statuses' => self::statuses(),
            'priorities' => self::priorities(),
            'criticalities' => self::criticalities(),
        ]);
    }

    //

    private static function clients(?Company $company = null): array
    {
        return User::when($company, fn($query) => $query->where('company_id', $company->id))
            ->whereHas('role', fn($query) => $query->where('permission_client', true))
            ->get()->map(fn($user) => [
                'value' => $user->id,
                'label' => ($user->firstname ? "$user->firstname " : "") . $user->lastname
                    . ' - ' . $user->company->name
            ])->toArray();
    }

    private static function technicians(): array
    {
        return User::whereHas('role', fn($query) => $query->where('permission_technician', true))
            ->get()->map(fn($user) => [
                'value' => $user->id,
                'label' => ($user->firstname ? "$user->firstname " : "") . $user->lastname
            ])->toArray();
    }

    private static function statuses(): array
    {
        return Ticket\TicketStatus::all()->map(fn($status) => [
            'value' => $status->id, 'label' => $status->name
        ])->toArray();
    }

    private static function priorities(): array
    {
        return Ticket\TicketPriority::all()->map(fn($priority) => [
            'value' => $priority->id, 'label' => $priority->name
        ])->toArray();
    }

    private static function criticalities(): array
    {
        return Ticket\TicketCriticality::all()->map(fn($criticality) => [
            'value' => $criticality->id, 'label' => $criticality->name
        ])->toArray();
    }
}
