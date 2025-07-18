@props([
    'user'
])

@if ($user->role->permission_admin)
    <x-navbar.admin :user="$user" />
@elseif ($user->role->permission_technician)
    <x-navbar.tech :user="$user" />
@elseif ($user->role->permission_client)
    <x-navbar.client :user="$user" />
@endif
