@extends('backend.layouts.master')
@section('title', 'Room Information')
@section('roomList', 'show')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Create Room</h1>

        <form action="{{ url('room/save') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <!-- Overflow Hidden -->
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Input room info</h6>
                        </div>
                        <div class="card-body">

                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> {{ session('success') }}
                                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong> {{ session('error') }}
                                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Required:
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="form-group row">
                                <label for="room_name" class="col-sm-2 col-form-label">RoomName <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="room_name" id="room_name" autofocus>
                                    @error('room_name')
                                        <div class="text-sm text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="room_desc" class="col-sm-2 col-form-label">RoomDesc</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="room_desc" id="room_desc"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="room_status" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select class="form-select form-control" id="room_status" name="room_status">
                                        <option value="1">Aailable</option>
                                        <option value="0">Unavilable</option>
                                    </select>
                                    @error('room_status')
                                        <div class="text-sm text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="room_type_id" class="col-sm-2 col-form-label">RoomType</label>
                                <div class="col-sm-10">
                                    <select class="form-select form-control" id="room_type_id" name="room_type_id">
                                        <option value="">---Choose RoomType---</option>
                                        @foreach ($room_type as $rt)
                                            <option value="{{ $rt->room_type_id }}">{{ $rt->room_type_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('room_type_id')
                                        <div class="text-sm text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Roitation Utilities -->
                    <div class="card" style="min-height: 335px;height: auto;">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Attachment</h6>
                        </div>
                        <div class="card-body text-center">

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <div>
                                        <input class="form-control form-control-lg" name="room_photo" id="room_photo"
                                            type="file">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-11"></div>
                <div class="col-sm-1">

                    <button class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Save</span>
                    </button>

                </div>
            </div>
        </form>


    </div>
    <!-- /.container-fluid -->

@endsection
