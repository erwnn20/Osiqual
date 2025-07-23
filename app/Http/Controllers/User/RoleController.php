<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRoleRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
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
            'data' => User\Role::paginate(8),
            'create' => $user->role->permission_admin,
            'edit' => $user->role->permission_admin,

            'icon' => 'users',
            'header' => 'Rôle Utilisateur',
            'title' => 'Tous les Rôles',
        ]);
    }

    public function create(UserRoleRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $admin = $credentials['admin'] ?? false;
        $tech = $credentials['tech'] ?? false;
        $client = $credentials['client'] ?? false;

        $status = User\Role::create([
            'name' => $credentials['name'],
            'permission_admin' => $admin,
            'permission_technician' => $tech,
            'permission_client' => $client,
        ]);

        return back()->with('success', "Le rôle d'utilisateur '$status->name' a été créé avec succès.");
    }

    public function edit(Request $request, string $id): View
    {
        $user = $request->user();

        return view('object.status.edit', [
            'status' => $status = User\Role::findOrFail($id),
            'linked' => [
                'data' => User::where('role_id', $status->id)->paginate(5),
                'title' => 'Utilisateurs liés',
                'error' => 'Aucun Utilisateur lié',
                'edit' => $user->role->permission_admin,
            ],

            'icon' => 'users',
            'header' => 'Rôle Utilisateur',
        ]);
    }

    public function update(UserRoleRequest $request, string $id): RedirectResponse
    {
        $status = User\Role::findOrFail($id);

        $credentials = $request->validated();
        $admin = $credentials['admin'] ?? false;
        $tech = $credentials['tech'] ?? false;
        $client = $credentials['client'] ?? false;

        $status->update([
            'name' => $credentials['name'],
            'permission_admin' => $admin,
            'permission_technician' => $tech,
            'permission_client' => $client,
        ]);

        return back()->with('success', "Le rôle d'utilisateur '$status->name' a été mis à jour avec succès.");
    }

    public function delete(string $id): RedirectResponse
    {
        $status = User\Role::findOrFail($id);
        $name = $status->name;
        $status->delete();

        return back()->with('success', "Le rôle d'utilisateur '$name' a été supprimé avec succès.");
    }

    public function view(Request $request, string $id): View
    {
        return view('object.status.view', [
            'status' => $status = User\Role::findOrFail($id),
            'linked' => [
                'data' => User::where('role_id', $status->id)->paginate(5),
                'title' => 'Utilisateurs liés',
                'error' => 'Aucun Utilisateur lié',
                'edit' => false,
            ],

            'icon' => 'users',
            'header' => 'Rôle Utilisateur',
        ]);
    }
}
