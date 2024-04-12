<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatatableController extends Controller
{
    public function index()
    {
        $data['roomList'] = DB::table('rooms')->get();
        return view('backend.datatables.index', $data);
    }
}
