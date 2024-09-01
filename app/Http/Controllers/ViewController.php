<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Routing\Controller;

class ViewController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function dashboard()
    {
        return view('administration.home');
    }

    public function customers()
    {
        return view('administration.customers');
    }

    public function login()
    {
        return view('auth.show');
    }

    public function products()
    {
        return view('administration.products');
    }

    public function categories()
    {
        return view('administration.categories');
    }

    public function employees()
    {
        return view('administration.employees');
    }

    public function services()
    {
        return view('administration.services');
    }

    public function sales()
    {
        return view('administration.sales');
    }

    public function calendar()
    {
        return view('administration.calendar');
    }

    public function logout()
    {
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/login');
    }
}
