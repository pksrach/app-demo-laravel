@extends('backend.layouts.master')
@section('title', 'Room Information')
@section('roomList', 'show')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Room Information</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background: #4e73dffa; color: #fff;">
                                <th>Room ID</th>
                                <th>Room Name</th>
                                <th>Room Status</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $page = $_GET['page'] ?? 1;
                            if (!$page) {
                                $page = 1;
                            }
                            $i = config('app.row') * ($page - 1) + 1;
                            ?>
                            @foreach ($rooms as $item)
                                <tr>
                                    {{-- <td>{{ $item->room_id }}</td> --}}
                                    <td>{{ $i++ }}
                                    <td>{{ $item->room_name }}</td>
                                    <td>{{ $item->room_status == 1 ? 'Available' : 'Unavailable' }}</td>
                                    <td>{{ $item->room_desc }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary"><i class="far fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger"><i
                                                class="fas fa-minus-square"></i></button>
                                        <button type="button" class="btn btn-info"><i class="far fa-eye"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $rooms->links('vendor\pagination\bootstrap-5') }}
                </div>
            </div>
        </div>

    </div>
@endsection
