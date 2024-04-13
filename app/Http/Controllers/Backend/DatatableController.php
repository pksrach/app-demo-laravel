<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DatatableController extends Controller
{
    public function index()
    {
        $data['roomList'] = DB::table('rooms')->get();
        return view('backend.datatables.index', $data);
    }

    public function getRoom(Request $req)
    {
        if ($req->ajax()) {
            $roomList = DB::table('rooms')
                ->join('room_types', 'rooms.room_type_id', '=', 'room_types.room_type_id')
                ->get(['rooms.*', 'room_types.room_type_name as room_type', 'room_types.price as room_price']);

            return DataTables::of($roomList)
                ->addIndexColumn()
                ->addColumn('room_name', function ($row) {
                    return $row->room_name . ' | ' . $row->room_status;
                })
                ->addColumn('room_photo', function ($row) {
                    $url = asset($row->room_photo ? '/uploads/thumbnail/' . $row->room_photo : 'uploads/no_img.png');
                    return '<img src=' . $url . ' border="0" width="40" class="img-rounded" align="center" />';
                })
                ->addColumn('action', function ($row) {
                    return '<button type="button" room_id="' . $row->room_id . '" class="editRoom btn btn-primary btn-sm">កែប្រែ</button >&nbsp;
                        <button type="button" room_id="' . $row->room_id . '" class="deleteRoom btn btn-danger btn-sm">លុប</button>';
                })
                ->rawColumns(array('room_name', 'room_photo', 'action'))
                ->make(true);
        }

        return view('backend.datatables.getroom');
    }
}
