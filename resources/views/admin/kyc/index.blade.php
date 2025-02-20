@extends('layouts.admin')
@section('content')
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">KYC </h3>

                </div>
                <div class="nk-block-head-content">
                    @if (Auth::user()->hasPermissionto('staff_add'))
                    {{--  <button class="btn  btn-warning btn-icon " data-bs-toggle="modal" data-bs-target="#createmodal"><em class="icon ni ni-plus"></em></button>  --}}
                    @endif
                </div>
            </div>
        </div>
        <div class="row g-gs">
            <div class="col-lg-12">
                <div class="card card-bordered  card-preview">
                    <div class="card-inner ">

                        <table class="datatable-init table" id="blogtable">
                            <thead>
                                <tr>
                                    <th>
                                        User
                                    </th>
                                    <th>
                                        submitted date
                                    </th>
                                    <th>Status</th>
                                    <th>
                                        Checked By
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kycs as $kyc)
                                <tr>
                                        @php
                                      $id =  $kyc->user->id;
                                        @endphp
                                        <td class="dtr-control" tabindex="0">
                                            <div class="user-card">
                                                <img src="{{$kyc->user->profileImage()}}" alt="" height="50px" width="50px" class="border rounded-circle user-avatar">


                                                <div class="user-info">

                                                    <span class="tb-lead d-block "><strong>
                                                        <a href="{{url("admin/user/$id ")}}">
                                                            {{$kyc->user->FirstName}} {{$kyc->user->LastName}}</a></strong><a href="{{url("admin/user/$id")}}">
                                                        </a>
                                                        <span class="dot dot-success d-md-none ms-1"></span>
                                                        </span>
                                                        <span>{{$kyc->user->email}}</span>
                                                </div>

                                            </div>

                                        </td>

                                    <td>
                                        {{$kyc->getCreatedAtAttribute($kyc->created_at)}}
                                    </td>
                                    <td>

                                        <span class="{{$kyc->status->class??''}}">
                                            {{$kyc->status->name??''}}

                                        </span>
                                    </td>

                                        <td class="dtr-control" tabindex="0">
                                            <div class="user-card">
                                                @if($kyc->approval)
                                                <img src="{{$kyc->approval->profileImage()}}" alt="" height="50px" width="50px" class="border rounded-circle user-avatar">
                                                @endif

                                              @if ($kyc->updated_by)
                                              <div class="user-info">

                                                <span class="tb-lead d-block "><strong>

                                                        {{$kyc->approval->FirstName}} {{$kyc->approval->LastName}}</strong>

                                                    <span class="dot dot-success d-md-none ms-1"></span>
                                                    </span>
                                                    <span>{{$kyc->approval->email}}</span>
                                            </div>
                                              @endif

                                            </div>

                                        </td>


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
@endsection
