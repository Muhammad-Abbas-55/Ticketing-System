<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTickets = Ticket::count();
        $totalUsers = User::count();
        $totalRoles = Role::count();
        $totalPermissions = Permission::count();
        $totalLabels = Label::count();
        $totalCategories = Category::count();

        return view('dashboard', compact('totalTickets','totalLabels','totalUsers','totalRoles','totalCategories','totalPermissions'));
    }
}
