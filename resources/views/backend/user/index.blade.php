@extends('backend.layouts.master')
@section('title', 'User Information')
@section('roomList', 'show')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">User Information</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">

                @component('components.alert')
                @endcomponent

                <div class="d-flex">
                    <button type="button" class="btn btn-primary" id="createButton">
                        Create
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
                                <th>Name</th>
                                <th>Username</th>
                                <th>E-Mail</th>
                                <th>Active</th>
                                <th>Language</th>
                                <th>Date Created</th>
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
                            @forelse ($userList as $item)
                                <tr>
                                    {{-- <td>{{ $item->room_id }}</td> --}}
                                    <td hidden>{{ $item->id }}</td>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->user_name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->active == 1 ? 'Available' : 'Unavailable' }}</td>
                                    <td>{{ $item->language }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" id="btnResetPwd"
                                            onclick="$('#myModal'+{{ $item->id }}).modal('show');">
                                            <i class="fa fa-light fa-key" id="btnResetPwd"></i>
                                        </button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="myModal{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content container-fluid">
                                            <div class="row">
                                                <div class="col-12">

                                                    <div class="row">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Reset Password
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @include('backend.user.reset_password')
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
                    {{ $userList->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>

    </div>
@endsection
{{-- @section('myJs')
    <script type="text/javascript">

    </script>
@endsection --}}
