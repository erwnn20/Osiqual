<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketStatusRequest;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('object.status.index', [
            'cards' => [
                /*[
                    'icon' => 'file-text',
                    'value' => Contract::where('status_id', Contract\ContractStatus::inProgress()->id)->count(),
                    'title' => 'Contrats en Cours',
                ],
                [
                    'icon' => 'building-2',
                    'value' => Company::all()->filter(fn(Company $company) => $company->currentContract() === null)->count(),
                    'title' => 'Sociétés sans Contract',
                ],*/
            ],
            'data' => Ticket\TicketStatus::orderBy('value')->paginate(8),
            'create' => $user->role->permission_admin,
            'edit' => $user->role->permission_admin,

            'icon' => 'ticket',
            'header' => 'Status de Ticket',
            'title' => 'Tous les Status',
        ]);
    }

    public function create(TicketStatusRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        $status = Ticket\TicketStatus::create($credentials);

        return back()->with('success', "Le status de ticket '$status->name' a été créé avec succès.");
    }

    public function edit(Request $request, string $id): View
    {
        $user = $request->user();

        return view('object.status.edit', [
            'status' => $status = Ticket\TicketStatus::findOrFail($id),
            'linked' => [
                'data' => Ticket::where('status_id', $status->id)->paginate(5),
                'title' => 'Tickets liés',
                'error' => 'Aucun Ticket lié',
                'edit' => $user->role->permission_admin,
            ],

            'icon' => 'ticket',
            'header' => 'Status de Ticket',
        ]);
    }

    public function update(TicketStatusRequest $request, string $id): RedirectResponse
    {
        $status = Ticket\TicketStatus::findOrFail($id);
        $credentials = $request->validated();

        $status->update($credentials);

        return back()->with('success', "Le status de ticket '$status->name' a été mis à jour avec succès.");
    }

    public function delete(string $id): RedirectResponse
    {
        $status = Ticket\TicketStatus::findOrFail($id);
        $name = $status->name;
        $status->delete();

        return back()->with('success', "Le status de ticket '$name' a été supprimé avec succès.");
    }

    public function view(Request $request, string $id): View
    {
        return view('object.status.view', [
            'status' => $status = Ticket\TicketStatus::findOrFail($id),
            'linked' => [
                'data' => Ticket::where('status_id', $status->id)->paginate(5),
                'title' => 'Tickets liés',
                'error' => 'Aucun Ticket lié',
                'edit' => false,
            ],

            'icon' => 'ticket',
            'header' => 'Status de Ticket',
        ]);
    }
}
