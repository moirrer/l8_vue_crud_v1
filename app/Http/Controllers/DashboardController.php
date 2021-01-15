<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function users(){
        $data = UsersController::get();
        return Inertia::render('DashboardUsers', ['data' => $data->original["user"]]);
    }

    public function customers(){
        $data = CustomersController::get();
        $users = UsersController::get();
        return Inertia::render('DashboardCustomers', ['data' => $data->original["customer"], 'users' => $users->original["user"]]);
    }

    public function numbers(){
        $data = NumbersController::get();
        $customers = CustomersController::get();
        return Inertia::render('DashboardNumbers', ['data' => $data->original["number"], 'customers' => $customers->original["customer"]]);
    }

    public function numberPreferences(){
        $data = NumberPreferencesController::get();
        $numbers = NumbersController::get();
        return Inertia::render('DashboardNumberPreferences', ['data' => $data->original["number_preference"], 'numbers' => $numbers->original["number"]]);
    }
}
