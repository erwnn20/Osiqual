<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UserRequest;
use App\Models\Company;
use App\Models\User;
use App\Models\User\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $roles = [
            'admin' => Role::where('permission_admin', true)->first(),
            'tech' => Role::where(['permission_technician' => true, 'permission_admin' => false])->first(),
            'client' => Role::where('permission_client', true)->first(),
        ];

        return view('object.index', [
            'cards' => [
                [
                    'icon' => 'users',
                    'value' => User::where('role_id', $roles['client']->id)->count(),
                    'title' => 'Clients',
                ],
                [
                    'icon' => 'users',
                    'value' => User::where('role_id', $roles['tech']->id)->count(),
                    'title' => 'Techniciens',
                ],
                [
                    'icon' => 'ban',
                    'value' => User::where('active', false)->count(),
                    'title' => 'Utilisateurs Bloqués',
                ],
            ],
            'data' => User::paginate(8),
            'create' => true,
            'edit' => true,

            'icon' => 'users',
            'header' => 'Utilisateurs',
            'title' => 'Tous les Utilisateurs',
        ]);
    }

    public function new(): View
    {
        return view('object.user.new', [
            'roles' => self::roles(),
            'companies' => self::companies(),
        ]);
    }

    public function create(UserRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        $user = User::create([
            'firstname' => $credentials['firstname'],
            'lastname' => $credentials['lastname'],
            'login' => $credentials['login'],
            'email' => $credentials['email'],
            'phone' => $credentials['phone'],
            'company_id' => $credentials['company'],
            'role_id' => $credentials['role'],
            'password' => Hash::make($credentials['password']),
        ]);

        return to_route('user.edit', ['id' => $user->id])
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(Request $request, string $id): View
    {
        return view('object.user.edit', [
            'user' => User::findOrFail($id),

            'roles' => self::roles(),
            'companies' => self::companies(),
        ]);
    }

    public function update(UserRequest $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $credentials = $request->validated();

        $user->update([
            'firstname' => $credentials['firstname'],
            'lastname' => $credentials['lastname'],
            'login' => $credentials['login'],
            'email' => $credentials['email'],
            'phone' => $credentials['phone'],
            'company_id' => $credentials['company'],
            'role_id' => $credentials['role'],
        ]);

        if (!empty($credentials['password']))
            $user->update(['password' => Hash::make($credentials['password'])]);

        return back()->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function view(Request $request, string $id): View
    {
        return view('object.user.view', [
            'user' => User::findOrFail($id),

            'roles' => self::roles(),
            'companies' => self::companies(),
        ]);
    }

    public function self(Request $request): View
    {
        return view('object.user.profile', [
            'user' => $request->user(),

            'roles' => self::roles(),
            'companies' => self::companies(),
        ]);
    }

    public function updateSelf(ProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $credentials = $request->validated();

        $user->update([
            'firstname' => $credentials['firstname'],
            'lastname' => $credentials['lastname'],
            'email' => $credentials['email'],
            'phone' => $credentials['phone'],
        ]);

        if (!empty($credentials['password']))
            $user->update(['password' => Hash::make($credentials['password'])]);

        return back()->with('success', 'Votre profil a été mis à jour avec succès.');
    }

    public function block(string $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->update(['active' => 0]);

        return back()->with('success', "L'utilisateur $user->login a été bloqué avec succès.");
    }

    public function unblock(string $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->update(['active' => 1]);

        return back()->with('success', "L'utilisateur $user->login a été débloqué avec succès.");
    }

    //

    private static function roles(): array
    {
        return Role::all()->map(fn($role) => [
            'value' => $role->id, 'label' => $role->name
        ])->toArray();
    }

    private static function companies(): array
    {
        return Company::all()->map(fn($company) => [
            'value' => $company->id, 'label' => $company->name
        ])->toArray();
    }
}
