<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Affiche la liste paginée des sociétés avec des statistiques.
     *
     * @param Request $request La requête HTTP.
     * @return View La vue affichant la liste des sociétés.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('object.index', [
            'cards' => [
                [
                    'icon' => 'building-2',
                    'value' => Company::all()
                        ->filter(fn(Company $company) => $company->currentContracts('attributable')->count() > 0)
                        ->count(),
                    'title' => 'Sociétés avec Contract',
                ],
                [
                    'icon' => 'building-2',
                    'value' => Company::count(),
                    'title' => 'Total Sociétés',
                ],
            ],
            'data' => Company::paginate(8),
            'create' => $user->role->permission_admin,
            'edit' => $user->role->permission_admin,

            'icon' => 'building-2',
            'header' => 'Sociétés',
            'title' => 'Toutes les Sociétés',
        ]);
    }

    /**
     * Affiche le formulaire pour créer une nouvelle société.
     *
     * @return View La vue du formulaire de création.
     */
    public function new(): View
    {
        return view('object.company.new', [
            'countries' => self::countries(),
        ]);
    }

    /**
     * Crée une nouvelle société à partir des données validées.
     *
     * @param CompanyRequest $request La requête validée.
     * @return RedirectResponse Redirige vers la page d'édition avec un message de succès.
     */
    public function create(CompanyRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        $company = Company::create([
            'name' => $credentials['name'],
            'address' => $credentials['address'],
            'zipcode' => $credentials['zipcode'],
            'city' => $credentials['city'],
            'country' => $credentials['country'],
            'siret' => $credentials['siret'],
        ]);

        return to_route('company.edit', ['id' => $company->id])
            ->with('success', 'La société a été créée avec succès.');
    }

    /**
     * Affiche le formulaire d'édition pour une société existante.
     *
     * @param Request $request La requête HTTP.
     * @param string $id L'identifiant de la société.
     * @return View La vue du formulaire d'édition.
     */
    public function edit(Request $request, string $id): View
    {
        return view('object.company.edit', [
            'company' => Company::findOrFail($id),
            'countries' => self::countries(),
        ]);
    }

    /**
     * Met à jour une société existante avec les données validées.
     *
     * @param CompanyRequest $request La requête validée.
     * @param string $id L'identifiant de la société.
     * @return RedirectResponse Redirige avec un message de succès.
     */
    public function update(CompanyRequest $request, string $id): RedirectResponse
    {
        $company = Company::findOrFail($id);
        $credentials = $request->validated();

        $company->update([
            'name' => $credentials['name'],
            'address' => $credentials['address'],
            'zipcode' => $credentials['zipcode'],
            'city' => $credentials['city'],
            'country' => $credentials['country'],
            'siret' => $credentials['siret'],
        ]);

        return back()->with('success', 'La société a été mise à jour avec succès.');
    }

    /**
     * Affiche les détails d'une société spécifique.
     *
     * @param Request $request La requête HTTP.
     * @param string $id L'identifiant de la société.
     * @return View La vue des détails de la société.
     */
    public function view(Request $request, string $id): View
    {
        return view('object.company.view', [
            'company' => Company::findOrFail($id),
            'countries' => self::countries(),
        ]);
    }

    /**
     * Affiche les informations de la société de l'utilisateur connecté.
     *
     * @param Request $request La requête HTTP.
     * @return View La vue des informations de la société de l'utilisateur.
     */
    public function self(Request $request): View
    {
        return view('object.company.view', [
            'company' => $request->user()->company,
            'countries' => self::countries(),
        ]);
    }

    //

    /**
     * Récupère la liste des pays formatée pour les formulaires.
     *
     * @return array Liste des pays avec ISO Alpha2 et label traduit.
     */
    private static function countries(): array
    {
        return collect(countries())->map(function ($data, $countryIso) {
            $country = country($countryIso);
            $translations = $country->getTranslations();

            return [
                'value' => $country->getIsoAlpha2(),
                'label' => ($translations['fra'] ?? $translations['eng'])['common'],
            ];
        })->toArray();
    }
}
