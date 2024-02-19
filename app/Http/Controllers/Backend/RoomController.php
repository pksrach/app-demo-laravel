<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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

        $room_type = RoomType::all();
        return view('backend.room.index', $data, compact('room_type'));
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
            $image = $request->file('room_photo');

            // Get the original file name
            $originalFileName = $image->getClientOriginalName();

            // Check if the original image already exists in the public/uploads/rooms directory
            $originalImagePath = public_path('uploads/rooms/' . $originalFileName);
            if (file_exists($originalImagePath)) {
                $originalImage = 'uploads/rooms/' . $originalFileName;
            } else {
                // Store the original image
                $image->move(public_path('uploads/rooms'), $originalFileName);
                $originalImage = 'uploads/rooms/' . $originalFileName;
                // $originalImage = 'uploads/rooms_resize/' . $originalFileName;
            }

            // Check if the resized image already exists in the public/uploads/rooms_resize directory
            $resizedImagePath = public_path('uploads/rooms_resize/' . $originalFileName);
            $resizedImageExists = file_exists($resizedImagePath);

            try {
                if (!$resizedImageExists) {
                    if (!$resizedImageExists) {
                        // before resize image, check if the directory exists
                        if (!file_exists(public_path('uploads/rooms_resize'))) {
                            mkdir(public_path('uploads/rooms_resize'), 0777, true);
                        } else {
                            // Resize and upload the new image
                            $resizedImage = Image::make($originalImage)
                                ->widen(100, function ($constraint) {
                                    $constraint->upsize();
                                })
                                ->encode($image->getClientOriginalExtension());

                            $resizedImage->save($resizedImagePath);
                        }
                    }
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                return redirect('room/create')->with('error', $e->getMessage());
            }

            // Insert the original image path into the database
            $data['room_photo'] = $originalImage;
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
                return redirect('room')->with('success', 'Data Inserted Successfully');
            }
        } catch (Exception $e) {
            return redirect('room')->with('error', $e->getMessage());
        }
    }
}
