<form action="{{ url('users/reset-password') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Input password info</h6>
    </div>
    <div class="card-body">
        <input type="hidden" name="user_id" value="{{ $item->id }}">

        <div class="form-group row">
            <label for="password" class="col-sm-4 col-form-label">New Password <span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="password" id="password" autofocus required>
                @error('password')
                    <div class="text-sm text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="confirmPassword" class="col-sm-4 col-form-label">Confirm New Password <span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="confirmPassword" id="confirmPassword" required>
                @error('confirmPassword')
                    <div class="text-sm text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

    </div>
    <div class="card-head py-3">
        <button type="submit" class="btn btn-primary btn-md">Change</button>
    </div>
</form>
