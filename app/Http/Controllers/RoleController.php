<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Role/Index', [
            'list' => Role::getList($request),
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
            'order' => ['required', 'integer', 'min:0', 'max:999'],
            'is_super_admin' => ['required', 'boolean'],
        ])->validateWithBag('createRole');

        Role::query()->create([
            'name' => $request->name,
            'order' => $request->order,
            'is_super_admin' => $request->is_super_admin
        ]);

        return to_route('roles.index')->with('success', 'Role created');
    }

    /**
     * Update the specified resource in storage.
     * @throws ValidationException
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'order' => ['required', 'integer', 'min:0', 'max:999'],
            'is_super_admin' => ['required', 'boolean'],
        ])->validateWithBag('updateRole');

        $role = Role::query()->find($id);
        $role->name = $request->name;
        $role->order = $request->order;
        $role->is_super_admin = $request->is_super_admin;
        $role->save();

        return to_route('roles.index')->with('success', 'Role updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id): RedirectResponse
    {
        if ($request->user()->roles()->contains('id', $id)) {
            return to_route('roles.index')->with('error', 'You cannot delete yourself');
        }

        $role = Role::query()->find($id);
        if ($role->users()->count() > 0) {
            return to_route('roles.index')->with('error', 'You cannot delete a role with users');
        }

        $role->delete();
        return to_route('roles.index')->with('success', 'Role deleted');
    }
}
