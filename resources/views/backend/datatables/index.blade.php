@extends('backend.layouts.master')
@section('title', 'Datatable Room')
@section('roomList', 'show')
@section('style-datatable')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Datatable Room Information</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">

                <div class="d-flex">
                    {{-- <button type="button" class="btn btn-primary" id="createButton">
                        Create
                    </button> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">


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
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roomList as $item)
                                            <tr>
                                                <td>{{ $item->room_id }}</td>
                                                <td>{{ $item->room_name }}</td>
                                                <td>{{ $item->room_desc }}</td>
                                                <td>{{ $item->room_status }}</td>
                                                <td>{{ $item->room_active }}</td>
                                                <td>Action</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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


@section('datatable')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection
