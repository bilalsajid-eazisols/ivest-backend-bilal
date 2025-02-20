@extends('layouts.admin')
@section('content')

<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h4 class="title nk-block-title">Update Profile</h4>

        </div>
    </div>
    <div class="row g-gs">
        <div class="col-lg-6">
            <div class="card card-bordered card-preview">
                <div class="card-inner ">

                    <form action="{{route('profile.save')}}" method="POST" class="row">
                        @csrf
                        <div class="form-group col-lg-6"><label class="form-label" for="FirstName">First Name</label>
                            <div class="form-control-wrap"><input type="text" class="form-control" id="FirstName" name="FirstName" required
                                value="{{Auth::user()->FirstName}}"
                                >
                            </div>
                        </div>
                        <div class="form-group col-lg-6"><label class="form-label" for="LastName">Last Name</label>
                            <div class="form-control-wrap"><input type="text" class="form-control" id="LastName" name="LastName" required

                                value="{{Auth::user()->LastName}}">
                            </div>
                        </div>
                        <div class="form-group col-lg-6"><label class="form-label" for="username">UserName</label>
                            <div class="form-control-wrap"><input type="text" class="form-control" id="username" name="username" required
                                value="{{Auth::user()->username}}"
                                >
                            </div>
                        </div>
                        <div class="form-group col-lg-6"><label class="form-label" for="dob">Date Of Birth </label>
                            <div class="form-control-wrap"><input type="date" class="form-control" id="dob" name="dob" required
                                value="{{Auth::user()->dob}}"
                                >
                            </div>
                        </div>
                        <div class="form-group col-lg-6"><label class="form-label" for="email">Email </label>
                            <div class="form-control-wrap"><input type="email" class="form-control" id="email" name="email" required readonly
                                value="{{Auth::user()->email}}"
                                >
                            </div>
                        </div>
                        <div class="form-group col-lg-6"><label class="form-label" for="password">Address </label>
                            <div class="form-control-wrap"><input type="text" class="form-control" id="address" name="address" required
                                value="{{Auth::user()->address}}"
                                >
                            </div>
                        </div>

                        <div class="form-group col-lg-12 mb-3 text-end"><button type="submit" class="btn  btn-warning">Save
                                Informations</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
