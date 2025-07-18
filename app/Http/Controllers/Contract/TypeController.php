<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractTypeRequest;
use App\Models\Contract;
use App\Models\Contract\ContractType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('object.status.index', [
            'cards' => [
                /*[
                    'icon' => 'file-text',
                    'value' => Contract::where('status_id', Contract\ContractType::inProgress()->id)->count(),
                    'title' => 'Contrats en Cours',
                ],
                [
                    'icon' => 'building-2',
                    'value' => Company::all()->filter(fn(Company $company) => $company->currentContract() === null)->count(),
                    'title' => 'Sociétés sans Contract',
                ],*/
            ],
            'data' => Contract\ContractType::orderBy('value')->paginate(8),
            'create' => $user->role->permission_admin,
            'edit' => $user->role->permission_admin,

            'icon' => 'file-text',
            'header' => 'Type de Contrat',
            'title' => 'Tous les Types',
        ]);
    }

    public function create(ContractTypeRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $duration = $credentials['duration'] * 60;
        $monthly = $credentials['monthly'] ?? false;

        if (ContractType::where('name', ContractType::generateName($duration, $monthly))->exists()) {
            return back()
                ->withErrors([
                    'error' => 'Cette configuration type de existe déja.',
                    'duration' => 'Configuration déja existante.',
                    'monthly' => 'Configuration déja existante.',
                ])
                ->withInput();
        }

        $status = Contract\ContractType::create([
            'duration' => $duration,
            'monthly' => $monthly,
        ]);

        return back()->with('success', "Le type de contrat '$status->name' a été créé avec succès.");
    }

    public function edit(Request $request, string $id): View
    {
        $user = $request->user();

        return view('object.status.edit', [
            'status' => $status = Contract\ContractType::findOrFail($id),
            'linked' => [
                'data' => Contract::where('type_id', $status->id)->paginate(5),
                'title' => 'Contrats liés',
                'error' => 'Aucun Contrat lié',
                'edit' => $user->role->permission_admin,
            ],

            'icon' => 'file-text',
            'header' => 'Type de Contrat',
        ]);
    }

    public function update(ContractTypeRequest $request, string $id): RedirectResponse
    {
        $status = Contract\ContractType::findOrFail($id);

        $credentials = $request->validated();
        $duration = $credentials['duration'] * 60;
        $monthly = $credentials['monthly'] ?? false;

        if ($status->contracts()->exists()) {
            return back()
                ->withErrors([
                    'error' => 'Ce type de contrat est utilisé dans un ou plusieurs contrats et ne peut pas être modifié.'
                ])
                ->withInput([]);
        }

        if (ContractType::where('name', ContractType::generateName($duration, $monthly))->exists()) {
            return back()
                ->withErrors([
                    'error' => 'Cette configuration type de existe déja.',
                    'duration' => 'Configuration déja existante.',
                    'monthly' => 'Configuration déja existante.',
                ])
                ->withInput();
        }

        $status->update([
            'duration' => $duration,
            'monthly' => $monthly,
        ]);

        return back()
            ->with('success', "Le type de contrat '$status->name' a été mis à jour avec succès.");
    }

    public function delete(string $id): RedirectResponse
    {
        $status = Contract\ContractType::findOrFail($id);
        $name = $status->name;
        $status->delete();

        return back()->with('success', "Le type de contrat '$name' a été supprimé avec succès.");
    }

    public function view(Request $request, string $id): View
    {
        return view('object.status.view', [
            'status' => $status = Contract\ContractType::findOrFail($id),
            'linked' => [
                'data' => Contract::where('type_id', $status->id)->paginate(5),
                'title' => 'Contrats liés',
                'error' => 'Aucun Contrat lié',
                'edit' => false,
            ],

            'icon' => 'file-text',
            'header' => 'Type de Contrat',
        ]);
    }
}
