<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractCreateRequest;
use App\Http\Requests\ContractUpdateRequest;
use App\Models\Company;
use App\Models\Contract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContractController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        if ($user->role->permission_technician)
            return view('object.index', [
                'cards' => [
                    [
                        'icon' => 'file-text',
                        'value' => Contract::where('status_id', Contract\ContractStatus::inProgress()->id)->count(),
                        'title' => 'Contrats en Cours',
                    ],
                    [
                        'icon' => 'building-2',
                        'value' => Company::all()->filter(fn(Company $company) => $company->currentContract() === null)->count(),
                        'title' => 'Sociétés sans Contract',
                    ],
                ],
                'data' => Contract::paginate(8),
                'create' => $user->role->permission_admin,
                'edit' => $user->role->permission_admin,

                'icon' => 'file-text',
                'header' => 'Contrats',
                'title' => 'Tous les Contrats',
            ]);
        elseif ($user->role->permission_client) {
            $remaining = $user->company->currentContract()?->durationRemaining() ?? 0;
            $remainingHours = round($remaining / 60, 1);

            return view('object.index', [
                'cards' => [
                    [
                        'icon' => 'file-text',
                        'value' => "$remainingHours h",
                        'title' => 'Temps de Contrat restant',
                    ],
                    [
                        'icon' => 'file-text',
                        'value' => !$user->company->currentContract() ? 'Aucun' :
                            ($user->company->currentContract()->type->monthly ? 'Mensuel' : 'Fixe'),
                        'title' => 'Type du Contrat en Cours',
                    ],
                    [
                        'icon' => 'file-text',
                        'value' => $user->company->contracts->count(),
                        'title' => 'Nombre de Contrat Signés',
                    ],
                ],
                'data' => $user->company->contracts()->paginate(8),
                'create' => false,
                'edit' => false,

                'icon' => 'file-text',
                'header' => 'Contrats',
                'title' => "Tous les Contrats de {$user->company->name}",
            ]);
        }

        abort(Response::HTTP_FORBIDDEN);
    }

    public function new(): View
    {
        return view('object.contract.new', [
            'companies' => self::companies(),
            'types' => self::types(),
            'statuses' => self::statuses(),
        ]);
    }

    public function create(ContractCreateRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        $contract = Contract::create([
            'company_id' => Company::findOrFail($credentials['company'])->id,
            'start_date' => $credentials['start'],
            'end_date' => $credentials['end'] ?? null,
            'status_id' => $credentials['status'],
            'type_id' => Contract\ContractType::findOrFail($credentials['type'])->id,
        ]);

        return to_route('contract.edit', ['id' => $contract->id])
            ->with('success', 'Le contrat a été créé avec succès.');
    }

    public function edit(Request $request, string $id): View
    {
        return view('object.contract.edit', [
            'contract' => Contract::findOrFail($id),

            'companies' => self::companies(),
            'types' => self::types(),
            'statuses' => self::statuses(),
        ]);
    }

    public function update(ContractUpdateRequest $request, string $id): RedirectResponse
    {
        $contract = Contract::findOrFail($id);
        $credentials = $request->validated();

        $contract->update([
            'start_date' => $credentials['start'],
            'end_date' => $credentials['end'] ?? null,
            'status_id' => $credentials['status'],
        ]);

        return back()->with('success', 'Le contrat a été mis à jour avec succès.');
    }

    public function view(Request $request, string $id): View
    {
        return view('object.contract.view', [
            'contract' => Contract::findOrFail($id),

            'companies' => self::companies(),
            'types' => self::types(),
            'statuses' => self::statuses(),
        ]);
    }

    //

    private static function companies(): array
    {
        return Company::all()->map(fn($company) => [
            'value' => $company->id, 'label' => $company->name,
        ])->toArray();
    }

    private static function types(): array
    {
        return Contract\ContractType::all()->map(fn($type) => [
            'value' => $type->id, 'label' => $type->name, 'data' => ['monthly' => $type->monthly]
        ])->toArray();
    }

    private static function statuses(): array
    {
        return Contract\ContractStatus::all()->map(fn($status) => [
            'value' => $status->id, 'label' => $status->name
        ])->toArray();
    }
}
