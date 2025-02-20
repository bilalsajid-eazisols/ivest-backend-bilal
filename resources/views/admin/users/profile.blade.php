@extends('layouts.admin')
@section('content')
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between g-3">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Profile / <strong class="text-primary small">{{ $user->FirstName }}
                        {{ $user->LastName }}</strong></h3>
                <div class="nk-block-des text-soft">
                    <ul class="list-inline">
                        <li>User ID: <span class="text-base">{{ $user->id }}</span></li>
                        <li>Joining Date: <span class="text-base">{{ $user->created_at }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="nk-block-head-content"><a href="{{ url($previousUrl) }}"
                    class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em
                        class="icon ni ni-arrow-left"></em><span>Back</span></a><a href="{{url( $previousUrl) }}"
                    class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em
                        class="icon ni ni-arrow-left"></em></a></div>
        </div>
    </div>
    <div class="nk-block">
        <div class="row gy-5">
            <div class="col-lg-5">
                {{--  {{)}}  --}}
                {{--  dd();  --}}
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h5 class="nk-block-title title">Uploaded Documents</h5>
                        <p>Here is user uploaded documents.</p>
                    </div>
                </div>
                @if (count($user->kycdocuments) > 0)
                    <div class="card card-bordered">

                        <ul class="data-list is-compact">
                            {{--  {{$user->passport()}}  --}}
                            @foreach ($user->kycdocuments as $kycdocument)
                                @if ($kycdocument->type != 'profile')
                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label text-capitalize">
                                                {{ $kycdocument->type }}{{ $kycdocument->subtype }}</div>
                                            <div class="data-value ">
                                                <a href="{{ asset($kycdocument->path) }}" target="_blank"
                                                    rel="noopener noreferrer">
                                                    <em class="icon ni ni-download"></em>
                                                    Download
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach

                        </ul>
                    </div>
                    @else
                    <div class="card card-bordered">
                        <ul class="data-list is-compact">
                            <li class="data-item">
                                No Documents Uploaded Yet

                            </li>
                    </ul>
                    </div>

                @endif

                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h5 class="nk-block-title title">Application Info</h5>
                    </div>
                </div>
                @if ($user->latestKyc != null)
                <div class="card card-bordered">
                    <ul class="data-list is-compact">

                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">Status</div>
                                <div class="data-value">

                                    <span
                                        class="{{$user->latestKyc?->status?->class}}">{{$user->latestKyc?->status?->name}}</span>
                                     @can('kyc_update')
                                     @if ($user->latestKyc->status_id == 1)
                                     <button type="button" onclick="statusupdate(2)" data-bs-toggle="modal"
                                     data-bs-target="#approvalmodal"  class="btn  p-0 my-0  "><em class="icon ni ni-check text-success"></em></button>
                                     <button type="button" onclick="statusupdate(3)" data-bs-toggle="modal"
                                     data-bs-target="#approvalmodal" class="btn n p-0 my-0 "><em class="icon ni ni-cross  text-danger"></em></button>
                                     @endif
                                     @endcan
                                </div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">Last Checked</div>
                                <div class="data-value">
                                    <div class="user-card">
                                        <div class="user-avatar  bg-orange-dim" style="background-image: url({{$user->latestKyc?->approval?->profileImage()}})
                                           ; background-position: center center; background-size: cover;
                                            height:50px; width:50px
                                            ">

                                        </div>
                                        <div class="user-name"><span class="tb-lead">{{$user->latestKyc?->approval?->email}}</span></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">Last Checked At</div>
                                <div class="data-value">{{$user->latestKyc?->updated_at}}</div>
                            </div>
                        </li>
                    </ul>
                </div>
                @else
                <div class="card card-bordered">
                    <ul class="data-list is-compact">
                        <li class="data-item">
                            No Documents Uploaded Yet

                        </li>
                </ul>
                </div>
                @endif


            </div>
            <div class="col-lg-7">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h5 class="nk-block-title title">Applicant Information</h5>
                        <p>Basic info, like name, phone, address, country etc.</p>
                    </div>
                </div>
                <div class="card card-bordered">
                    <ul class="data-list is-compact">
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">Profile Picture</div>
                                <div class="data-value">
                                    <div class="user-avatar xl" >
                                        <div class="rounded rounded-circle" style="background-image: url('{{ asset($user->profileImage()) }}'); background-position: center center; background-size: cover; max-height: 100px; max-width: 100px;
                                            min-height: 100px; min-width: 100px;
                                            "></div>

                                        {{--  <img src="" class="rounded rounded-circle avatar"
                                            alt="">  --}}

                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">User Name</div>
                                <div class="data-value">{{ $user->username }}</div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">First Name</div>
                                <div class="data-value">{{ $user?->FirstName }}</div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">Last Name</div>
                                <div class="data-value">{{ $user->LastName }}</div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">Email Address</div>
                                <div class="data-value">{{ $user->email }}</div>
                            </div>
                        </li>

                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">Date of Birth</div>
                                <div class="data-value">{{ $user->dob }}</div>
                            </div>
                        </li>

                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">Country of Residence</div>
                                <div class="data-value">{{ $user->country }}</div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">City</div>
                                <div class="data-value">{{ $user->city }}</div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">Full Address</div>
                                <div class="data-value">{{ $user->address }}</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('models')
<div class="modal fade" id="approvalmodal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Kyc Status Update</h5><a href="#" class="close"
                    data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
            </div>
            <div class="modal-body">
                <form class="form-validate is-alter" id="passwordform"
                    action="{{ url("admin/kyc/$user->id/update") }}" method="POST">
                    @csrf
                    <input type="hidden" name="statusid" value="0" id="statusid">
                    <div class="form-group"><label class="form-label" for="password">Reason</label>
                        <div class="form-control-wrap"><input type="text" class="form-control" id="reason"
                                name="reason" required></div>
                    </div>











                </form>
            </div>
            <div class="modal-footer bg-light"><span class="sub-text">
                    <div class="form-group">
                        <button type="submit" class="btn  btn-warning" form="passwordform">Save
                            Informations</button>
                    </div>
                </span></div>
        </div>
    </div>
</div>
@endsection
@section('extra-script')
<script>
function  statusupdate(status){
        document.getElementById('statusid').value = status;
    }
</script>
@endsection
