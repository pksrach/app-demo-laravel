@extends('backend.layouts.master')
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
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Room ID</th>
                                <th>Room Name</th>
                                <th>Room Status</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i = 1)
                            @foreach ($rooms as $item)
                                <tr>
                                    {{-- <td>{{ $item->room_id }}</td> --}}
                                    <td>{{ $i++ }}
                                    <td>{{ $item->room_name }}</td>
                                    <td>{{ $item->room_status }}</td>
                                    <td>{{ $item->room_desc }}</td>
                                    <td>Action</td>
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
