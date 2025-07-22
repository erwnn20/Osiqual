<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractStatusRequest;
use App\Models\Contract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class StatusController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('object.status.index', [
            'cards' => [
                /*[
                    'icon' => , // icon with lucide
                    'value' => ,
                    'title' => ,
                ],*/
            ],
            'data' => Contract\ContractStatus::orderBy('value')->paginate(8),
            'create' => $user->role->permission_admin,
            'edit' => $user->role->permission_admin,

            'icon' => 'file-text',
            'header' => 'Status de Contrat',
            'title' => 'Tous les Status',
        ]);
    }

    public function create(ContractStatusRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        $status = Contract\ContractStatus::create([
            'name' => $credentials['name'],
            'value' => $credentials['value'],
            'color' => $credentials['color'],
            'conditions' => Contract\ContractStatus::createConditions($credentials),
        ]);

        return back()->with('success', "Le status de contrat '$status->name' a été créé avec succès.");
    }

    public function edit(Request $request, string $id): View
    {
        $user = $request->user();
        $status = Contract\ContractStatus::findOrFail($id);
        $contracts = Contract::all()->filter(fn($contract) => $contract->status->id === $status->id)->values();

        $page = request('page', 1);
        $perPage = 10;

        return view('object.status.edit', [
            'status' => $status,
            'linked' => [
                'data' => new LengthAwarePaginator(
                    $contracts->forPage($page, $perPage),
                    $contracts->count(),
                    $perPage,
                    $page,
                    ['path' => request()->url(), 'query' => request()->query()]
                ),
                'title' => 'Contrats liés',
                'error' => 'Aucun Contrat lié',
                'edit' => $user->role->permission_admin,
            ],

            'icon' => 'file-text',
            'header' => 'Status de Contrat',
        ]);
    }

    public function update(ContractStatusRequest $request, string $id): RedirectResponse
    {
        $status = Contract\ContractStatus::findOrFail($id);
        $credentials = $request->validated();

        $status->update([
            'name' => $credentials['name'],
            'value' => $credentials['value'],
            'color' => $credentials['color'],
            'conditions' => Contract\ContractStatus::createConditions($credentials),
        ]);

        return back()->with('success', "Le status de contrat '$status->name' a été mis à jour avec succès.");
    }

    public function delete(string $id): RedirectResponse
    {
        $status = Contract\ContractStatus::findOrFail($id);
        $name = $status->name;
        $status->delete();

        return back()->with('success', "Le status de contrat '$name' a été supprimé avec succès.");
    }

    public function view(Request $request, string $id): View
    {
        $status = Contract\ContractStatus::findOrFail($id);
        $contracts = Contract::all()->filter(fn($contract) => $contract->status->id === $status->id)->values();

        $page = request('page', 1);
        $perPage = 10;

        return view('object.status.view', [
            'status' => $status,
            'linked' => [
                'data' => new LengthAwarePaginator(
                    $contracts->forPage($page, $perPage),
                    $contracts->count(),
                    $perPage,
                    $page,
                    ['path' => request()->url(), 'query' => request()->query()]
                ),
                'title' => 'Contrats liés',
                'error' => 'Aucun Contrat lié',
                'edit' => false,
            ],

            'icon' => 'file-text',
            'header' => 'Status de Contrat',
        ]);
    }
}
