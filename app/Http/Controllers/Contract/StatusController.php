<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractStatusRequest;
use App\Models\Contract;
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

        $conditions = [
            'duration' => [
                'condition' =>
                    ($credentials['duration-condition'] ?? '') .
                    ($credentials['duration-condition-equal'] ?? ''),
                'logic' => $credentials['duration-logic'] ?? null,
                'value' => $credentials['duration-value'] ?? null
            ],
            'start_date' => [
                'condition' =>
                    ($credentials['start-condition'] ?? '') .
                    ($credentials['start-condition-equal'] ?? ''),
                'value' => $credentials['start-value'] ?? null,
            ],
            'end_date' => [
                'condition' =>
                    ($credentials['end-condition'] ?? '') .
                    ($credentials['end-condition-equal'] ?? ''),
                'value' => $credentials['end-value'] ?? null,
            ],
        ];

        $status = Contract\ContractStatus::create([
            'name' => $credentials['name'],
            'value' => $credentials['value'],
            'color' => $credentials['color'],
            'conditions' => array_filter($conditions,
                fn ($condition) => !empty($condition['condition'])),
        ]);

        return back()->with('success', "Le status de contrat '$status->name' a été créé avec succès.");
    }

    public function edit(Request $request, string $id): View
    {
        $user = $request->user();

        return view('object.status.edit', [
            'status' => $status = Contract\ContractStatus::findOrFail($id),
            'linked' => [
                'data' => Contract::where('status_id', $status->id)->paginate(5),
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

        $conditions = [
            'duration' => [
                'condition' =>
                    ($credentials['duration-condition'] ?? '') .
                    ($credentials['duration-condition-equal'] ?? ''),
                'logic' => $credentials['duration-logic'] ?? null,
                'value' => $credentials['duration-value'] ?? null
            ],
            'start_date' => [
                'condition' =>
                    ($credentials['start-condition'] ?? '') .
                    ($credentials['start-condition-equal'] ?? ''),
                'value' => $credentials['start-value'] ?? null,
            ],
            'end_date' => [
                'condition' =>
                    ($credentials['end-condition'] ?? '') .
                    ($credentials['end-condition-equal'] ?? ''),
                'value' => $credentials['end-value'] ?? null,
            ],
        ];

        $status->update([
            'name' => $credentials['name'],
            'value' => $credentials['value'],
            'color' => $credentials['color'],
            'conditions' => array_filter($conditions,
                fn ($condition) => !empty($condition['condition'])),
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
        return view('object.status.view', [
            'status' => $status = Contract\ContractStatus::findOrFail($id),
            'linked' => [
                'data' => Contract::where('status_id', $status->id)->paginate(5),
                'title' => 'Contrats liés',
                'error' => 'Aucun Contrat lié',
                'edit' => false,
            ],

            'icon' => 'file-text',
            'header' => 'Status de Contrat',
        ]);
    }
}
