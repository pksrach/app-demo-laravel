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
                <button type="button" class="btn btn-primary" id="createButton"><i class="far fa-plus-square"></i>
                    Create</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background: #4e73dffa; color: #fff;">
                                <th>#</th>
                                <th>Room Photo</th>
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
                                    <td>{{ $i++ }}</td>
                                    <td><img src="{{ asset($item->room_photo ?? 'default.jpg') }}" width="50"></td>
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

        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <div class="row">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create Room</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @include('backend.room.modal.form_create_room')
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        document.getElementById('createButton').addEventListener('click', function() {
            $('#myModal').modal('show');
        });
    </script>
@endsection
