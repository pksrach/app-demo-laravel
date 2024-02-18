<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index()
    {
        $data['rooms'] = DB::table('rooms')->get();

        $data['rooms'] = DB::table('rooms')
            ->join('room_types', 'rooms.room_type_id', '=', 'room_types.room_type_id')
            ->select('rooms.*', 'room_types.room_type_name')
            ->orderBy('room_id', 'desc')
            ->paginate(config('app.row'));
        return view('backend.room.index', $data);
    }

    public function create()
    {
        $room_type = RoomType::all();
        return view('backend.room.create', compact('room_type'));
    }

    public function save(Request $request)
    {
        $request->validate(
            [
                'room_name' => 'required|unique:rooms|max:191',
                'room_status' => 'required',
                'room_type_id' => 'required',
            ],
            [
                'room_name.required' => 'Please input room name',
                'room_type_id.required' => 'Please select room type',
                'room_status.required' => 'Please select room status',
            ]
        );

        $data['room_photo'] = null;
        if ($request->room_photo) {
            $data['room_photo'] = $request->file('room_photo')->store('uploads/rooms', 'custom');
        }

        try {
            $data = array(
                'room_name' => $request->room_name,
                'room_desc' => $request->room_desc,
                'room_status' => $request->room_status,
                'room_photo' => $data['room_photo'],
                'room_type_id' => $request->room_type_id,
            );
            $i = DB::table('rooms')->insert($data);
            if ($i) {
                return redirect('room/create')->with('success', 'Data Inserted Successfully');
            }
        } catch (Exception $e) {
            return redirect('room/create')->with('error', $e->getMessage());
        }
    }
}
