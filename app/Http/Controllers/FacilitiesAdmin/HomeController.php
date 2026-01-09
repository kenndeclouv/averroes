<?php

namespace App\Http\Controllers\FacilitiesAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('roles.FacilitiesAdmin.home');
    }
}
