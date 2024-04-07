<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($req, $next) {
            app()->setLocale(Auth::user()->language);
            return $next($req);
        });
    }

    public function index()
    {
        $data['q_search'] = "";
        $data['rooms'] = DB::table('rooms')->get();

        $data['rooms'] = DB::table('rooms')
            ->join('room_types', 'rooms.room_type_id', '=', 'room_types.room_type_id')
            ->select('rooms.*', 'room_types.room_type_name')
            ->where('room_active', '1')
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

    public function edit($id)
    {
        $data['room'] = DB::table('rooms')
            ->where('room_id', $id)
            ->where('room_active', '1')
            ->first();

        $room_type = RoomType::all();
        return view('backend.room.edit', $data, compact('room_type'));
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
                return redirect('room')->with('error', $e->getMessage());
            }

            // Insert the original image path into the database
            $data['room_photo'] = $originalFileName;
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


    public function delete($id)
    {
        $i = DB::table('rooms')
            ->where('room_id', $id)
            ->update(['room_active' => '0']);
        return redirect('room')->with('success', 'Data Deleted Successfully');
    }

    public function update(Request $req)
    {
        $req->validate(
            [
                'room_name' => 'required|max:191',
                'room_status' => 'required',
                'room_type_id' => 'required',
            ],
            [
                'room_name.required' => 'Please input room name',
                'room_type_id.required' => 'Please select room type',
                'room_status.required' => 'Please select room status',
            ]
        );

        $data = array(
            'room_name' => $req->room_name,
            'room_desc' => $req->room_desc,
            'room_status' => $req->room_status,
            'room_type_id' => $req->room_type_id,
        );

        if ($req->room_photo) {
            $image = $req->file('room_photo');
            $originalFileName = $image->getClientOriginalName();
            $originalImagePath = public_path('uploads/rooms/' . $originalFileName);
            if (file_exists($originalImagePath)) {
                $originalImage = 'uploads/rooms/' . $originalFileName;
            } else {
                $image->move(public_path('uploads/rooms'), $originalFileName);
                $originalImage = 'uploads/rooms/' . $originalFileName;
            }

            $resizedImagePath = public_path('uploads/rooms_resize/' . $originalFileName);
            $resizedImageExists = file_exists($resizedImagePath);

            try {
                if (!$resizedImageExists) {
                    if (!file_exists(public_path('uploads/rooms_resize'))) {
                        mkdir(public_path('uploads/rooms_resize'), 0777, true);
                    }

                    $resizedImage = Image::make($originalImage)
                        ->widen(100, function ($constraint) {
                            $constraint->upsize();
                        })
                        ->encode($image->getClientOriginalExtension());

                    $resizedImage->save($resizedImagePath);
                }

                $data['room_photo'] = $originalFileName;
            } catch (Exception $e) {
                Log::error($e->getMessage());
                return redirect('room')->with('error', $e->getMessage());
            }
        }

        $i = DB::table('rooms')
            ->where('room_id', $req->room_id)
            ->where('room_active', '1')
            ->update($data);

        if ($i) {
            return redirect('room')->with('success', 'Data Updated Successfully');
        } else {
            return redirect('room')->with('error', 'Data Updated Failed');
        }
    }


    public function search(Request $req)
    {
        $q_search = $req->q_search;
        // $data['rooms'] = DB::table('rooms')->get();
        $data['rooms'] = DB::table('rooms')
            ->join('room_types', 'rooms.room_type_id', '=', 'room_types.room_type_id')
            ->select('rooms.*', 'room_types.room_type_name')
            ->where('room_active', '1')
            ->where(function ($query) use ($q_search) {
                $query = $query->orWhere('room_name', 'like', "%{$q_search}%")
                    ->orWhere('room_desc', 'like', "%{$q_search}%");
            })
            ->orderBy('room_id', 'desc')
            ->paginate(config('app.row'));

        $data['q_search'] = $q_search;

        $room_type = RoomType::all();
        return view('backend.room.index', $data, compact('room_type'));
    }
}
