@extends('backend.layouts.master')
@section('title', 'Datatable Room')
@section('roomList', 'show')

@section('style-datatable')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">

            <!-- DataTales Example -->
            <div class="card shadow col-12">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Rooms</h6>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTableRoom" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>RoomId</th>
                                    <th>Image</th>
                                    <th>RoomName</th>
                                    <th>Price</th>
                                    <th>RoomDesc</th>
                                    <th>Status</th>
                                    <th>RoomType</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('datatable')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endsection

@section('myJs')
    <script>
        function previewImg(evt) {
            let img = document.getElementById('img');
            img.src = URL.createObjectURL(evt.target.files[0]);
        }

        $(document).ready(function() {
            $('#dataTableRoom').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('getRoom') }}",
                columns: [{
                        data: 'room_id',
                        name: 'room_id'
                    },
                    {
                        data: 'room_photo',
                        name: 'room_photo',
                    },
                    {
                        data: 'room_name',
                        name: 'room_name'
                    },

                    {
                        data: 'room_price',
                        name: 'room_price'
                    },
                    {
                        data: 'room_desc',
                        name: 'room_desc'
                    },
                    {
                        data: 'room_status',
                        name: 'room_status'
                    },
                    {
                        data: 'room_type',
                        name: 'room_type'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ],

            });
        });
    </script>
@endsection
