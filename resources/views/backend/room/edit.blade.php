@extends('backend.layouts.master')
@section('title', 'Update Room')
@section('roomList', 'show')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Update Room</h1>

        @include('backend.room.modal.form_update_room')


    </div>
    <!-- /.container-fluid -->

@endsection
