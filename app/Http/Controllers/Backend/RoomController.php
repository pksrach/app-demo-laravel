<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index()
    {
        $data['rooms'] = DB::table('rooms')->get();

        $data['rooms'] = DB::table('rooms')
            ->orderBy('room_id', 'desc')
            ->paginate(config('app.row'));
        // ->get();
        return view('backend.room.index', $data);
    }
}
