<form action="{{ url('room/save') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Input room info</h6>
    </div>
    <div class="card-body">

        <div class="form-group row">
            <label for="room_name" class="col-sm-2 col-form-label">RoomName <span class="text-danger">*</span></label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="room_name" id="room_name"
                    value="{{ old('room_name', request()->input('room_name')) }}" autofocus>
                @error('room_name')
                    <div class="text-sm text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="room_desc" class="col-sm-2 col-form-label">RoomDesc</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="room_desc" id="room_desc">{{ old('room_desc', request()->input('room_desc')) }}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="room_status" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                <select class="form-select form-control" id="room_status" name="room_status">
                    <option value="1">Available</option>
                    <option value="0">Unavailable</option>
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
                        <option value="{{ $rt->room_type_id }}">
                            {{ $rt->room_type_name }}
                        </option>
                    @endforeach
                </select>
                @error('room_type_id')
                    <div class="text-sm text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Roitation Utilities -->
    <div class="card" style="min-height: 270px; height: auto;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Attachment</h6>
        </div>
        <div class="card-body text-center">
            <input class="form-control form-control-md" name="room_photo" id="room_photo" type="file"
                accept="image/*" onchange="previewImgForCreate(event)">
        </div>
        <div style="text-align: center;">
            <img src="" alt="" id="img1" width="300">
        </div>
    </div>
    <div class="card-head py-3">
        <button type="submit" class="btn btn-primary btn-md">Save</button>
    </div>
</form>
