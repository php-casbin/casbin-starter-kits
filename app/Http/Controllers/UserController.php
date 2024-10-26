<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('User/Index', [
            'list' => User::getList($request),
            'rolesFilter' => Role::getFilter()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'email'],
            'role' => ['required', 'integer', 'exists:roles,id'],
        ])->validateWithBag('createUser');

        $user = User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => 'abc123'
        ]);
        $user->attachRole(Role::query()->find($request->role));

        return to_route('users.index')->with('success', 'User created');
    }

    /**
     * Update the specified resource in storage.
     * @throws ValidationException
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        if ($request->get('password')) {
            Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:6'],
            ])->validateWithBag('updateUser');
        } else {
            Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255', 'min:2'],
                'email' => ['required', 'string', 'email', 'max:255', 'email'],
                'role' => ['required', 'integer', 'exists:roles,id'],
            ])->validateWithBag('updateUser');
        }

        $user = User::query()->find($id);
        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        if ($request->input('role')) {
            $user->detachAllRoles();
            $user->attachRole(Role::query()->find($request->role));
        }
        if ($request->input('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return to_route('users.index')->with('success', 'User updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id): RedirectResponse
    {
        if ($request->user()->id == $id) {
            return to_route('users.index')->with('error', 'You cannot delete yourself');
        }
        User::query()->find($id)->delete();
        return to_route('users.index')->with('success', 'User deleted');
    }
}
