<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketCriticalityRequest;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CriticalityController extends Controller
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
            'data' => Ticket\TicketCriticality::orderBy('value')->paginate(8),
            'create' => $user->role->permission_admin,
            'edit' => $user->role->permission_admin,

            'icon' => 'ticket',
            'header' => 'Criticité de Ticket',
            'title' => 'Toutes les Criticités',
        ]);
    }

    public function create(TicketCriticalityRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        $status = Ticket\TicketCriticality::create($credentials);

        return back()->with('success', "La criticité de ticket '$status->name' a été créé avec succès.");
    }

    public function edit(Request $request, string $id): View
    {
        $user = $request->user();

        return view('object.status.edit', [
            'status' => $status = Ticket\TicketCriticality::findOrFail($id),
            'linked' => [
                'data' => Ticket::where('criticality_id', $status->id)->paginate(5),
                'title' => 'Tickets liés',
                'error' => 'Aucun Ticket lié',
                'edit' => $user->role->permission_admin,
            ],

            'icon' => 'ticket',
            'header' => 'Criticité de Ticket',
        ]);
    }

    public function update(TicketCriticalityRequest $request, string $id): RedirectResponse
    {
        $status = Ticket\TicketCriticality::findOrFail($id);
        $credentials = $request->validated();

        $status->update($credentials);

        return back()->with('success', "La criticité de ticket '$status->name' a été mis à jour avec succès.");
    }

    public function delete(string $id): RedirectResponse
    {
        $status = Ticket\TicketCriticality::findOrFail($id);
        $name = $status->name;
        $status->delete();

        return back()->with('success', "La criticité de ticket '$name' a été supprimé avec succès.");
    }

    public function view(Request $request, string $id): View
    {
        return view('object.status.view', [
            'status' => $status = Ticket\TicketCriticality::findOrFail($id),
            'linked' => [
                'data' => Ticket::where('criticality_id', $status->id)->paginate(5),
                'title' => 'Tickets liés',
                'error' => 'Aucun Ticket lié',
                'edit' => false,
            ],

            'icon' => 'ticket',
            'header' => 'Criticité de Ticket',
        ]);
    }
}
