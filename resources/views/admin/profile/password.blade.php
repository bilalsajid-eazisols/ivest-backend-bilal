@extends('layouts.admin')
@section('content')
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h4 class="title nk-block-title">Update Password</h4>
                <div class="nk-block-des">
                    <p>Update Your Current Password.</p>
                </div>
            </div>
        </div>
        <div class="row g-gs">
            <div class="col-lg-6">
                <div class="card card-bordered card-preview">
                    <div class="card-inner ">

                        <form action="{{ route('updatepassword') }}" method="POST" class="row">
                            @csrf
                            <div class="form-group col-lg-12"><label class="form-label" for="currentpassword">Current
                                    Password</label>
                                <div class="form-control-wrap">
                                    <a href="#"
                                                class="form-icon form-icon-right passcode-switch lg"
                                                data-target="currentpassword"><em
                                                    class="passcode-icon icon-show icon ni ni-eye"></em><em
                                                    class="passcode-icon icon-hide icon ni ni-eye-off"></em></a>
                                    <input type="password" required class="form-control"
                                        id="currentpassword" name="currentpassword" required>
                                        @error('currentpassword')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-lg-12"><label class="form-label" for="password">New Password</label>
                                <div class="form-control-wrap">
                                    <a href="#"
                                                class="form-icon form-icon-right passcode-switch lg"
                                                data-target="password"><em
                                                    class="passcode-icon icon-show icon ni ni-eye"></em><em
                                                    class="passcode-icon icon-hide icon ni ni-eye-off"></em></a>
                                    <input type="password" required class="form-control"
                                        id="password" name="password" required>
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    </div>
                            </div>
                            <div class="form-group col-lg-12"><label class="form-label" for="confirmpassword">Confirm
                                    Password</label>
                                <div class="form-control-wrap">
                                    <a href="#"
                                                class="form-icon form-icon-right passcode-switch lg"
                                                data-target="confirmpassword"><em
                                                    class="passcode-icon icon-show icon ni ni-eye"></em><em
                                                    class="passcode-icon icon-hide icon ni ni-eye-off"></em></a>
                                    <input type="password" required class="form-control"
                                        id="confirmpassword" name="password_confirmation" required>
                                </div>
                            </div>





                            <div class="form-group col-lg-12 mb-3 text-end"><button type="submit"
                                    class="btn  btn-warning">Save
                                    Informations</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
