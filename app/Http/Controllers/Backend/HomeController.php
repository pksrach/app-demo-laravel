<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // អាកន្លែង backend.dashboard.index ហ្នឹង គឺជាឈ្មោះ view ដែលនៅក្នុង backend/dashboard folder នៅក្នុង views folder
        return view('backend.dashboard.index');
    }
}
