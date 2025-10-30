<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Session::get('login')) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('dashboard');
    }
}
