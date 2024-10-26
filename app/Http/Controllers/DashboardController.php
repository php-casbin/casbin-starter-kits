<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Dashboard', [
            'overviewData' => [
                'userCount' => User::query()->count(),
                'roleCount' => Role::query()->count(),
                'permissionCount' => MenuItem::query()->where('type', 2)->count(),
                'activeUserCount' => rand(0, 3)
            ],
            'notifications' => [
                [
                    'id' => 1,
                    'type' => 'alert',
                    'message' => Str::markdown('User `45575` has been **banned**.')
                ],
                [
                    'id' => 2,
                    'type' => 'info',
                    'message' => Str::markdown('Role `Admin` has been **created**.')

                ],
                [
                    'id' => 3,
                    'type' => 'info',
                    'message' => Str::markdown('Permission `users.reset` has been **created**.')

                ],
                [
                    'id' => 4,
                    'type' => 'warning',
                    'message' => Str::markdown('Permission `users.edit` has been **removed** from your roles.')
                ]
            ]
        ]);
    }
}
