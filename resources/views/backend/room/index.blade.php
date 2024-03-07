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
                <div class="d-flex">
                    <button type="button" class="btn btn-primary" id="createButton">
                        <i class="far fa-plus-square"></i>Create
                    </button>
                    <form action="{{ route('room.search') }}"
                        class="ml-auto d-none d-sm-inline-block form-inline my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" name="q_search" value="{{ $q_search ?? '' }}"
                                class="form-control bg-white border-1 small" placeholder="Search for..." aria-label="Search"
                                aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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
                                <th>Room Type</th>
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
                            @forelse ($rooms as $item)
                                <tr>
                                    {{-- <td>{{ $item->room_id }}</td> --}}
                                    <td hidden>{{ $item->room_id }}</td>
                                    <td>{{ $i++ }}</td>
                                    @php
                                        $photo = $item->room_photo
                                            ? 'uploads/rooms_resize/' . $item->room_photo
                                            : 'default.jpg';
                                    @endphp
                                    <td><img src="{{ asset($photo) }}" width="50"></td>
                                    <td>{{ $item->room_name }}</td>
                                    <td>{{ $item->room_status == 1 ? 'Available' : 'Unavailable' }}</td>
                                    <td>{{ $item->room_type_name }}</td>
                                    <td>{{ $item->room_desc }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" id="btnEdit"
                                            onclick="$('#myModal'+{{ $item->room_id }}).modal('show');"><i
                                                class="far fa-edit" id="btnEdit"></i></button>
                                        <a href="{{ route('room.delete', $item->room_id) }}" class="btn btn-danger"
                                            onclick="return confirm('Do you want to delete ?')"><i
                                                class="fas fa-minus-square"></i></a>
                                        <button type="button" class="btn btn-info"><i class="far fa-eye"></i></button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="myModal{{ $item->room_id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content container-fluid">
                                            <div class="row">
                                                <div class="col-12">

                                                    <div class="row">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @include('backend.room.modal.form_update_room')
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center p-5" style="color: gray; font-weight: bold;">
                                        <h2>No data</h2>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- {{ $rooms->links('vendor\pagination\bootstrap-5') }} --}}

                    {{-- {{ $rooms->appends(request()->except('page'))->links('vendor.pagination.bootstrap-5') }} --}}

                    {{ $rooms->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
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
@endsection
@section('myJs')
    <script type="text/javascript">
        document.getElementById('createButton').addEventListener('click', function() {
            $('#myModal').modal('show');
        });
        
        $(document).ready(function() {
            $(".chosen-select").chosen();
        });

        function previewImgForUpdate(event) {
            if (event.target.files && event.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function() {
                    var output = document.getElementById('img2');
                    output.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            } else {
                console.log('No files selected');
            }
        }

        function previewImgForCreate(event) {
            if (event.target.files && event.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function() {
                    var output = document.getElementById('img1');
                    output.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            } else {
                console.log('No files selected');
            }
        }
    </script>
@endsection
