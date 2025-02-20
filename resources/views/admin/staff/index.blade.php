@extends('layouts.admin')
@section('content')
    <style>

    </style>

    <div class="nk-block nk-block-lg">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Staff </h3>

                </div>
                <div class="nk-block-head-content">
                    @can('staff_add')
                    <button class="btn  btn-warning btn-icon " data-bs-toggle="modal" data-bs-target="#createmodal"><em class="icon ni ni-plus"></em></button>
                    @endcan
                </div>
            </div>
        </div>

        <div class="row g-gs">
            <div class="col-lg-12">
                <div class="card card-bordered preview">
                    <div class="card-inner ">

                        <table class="datatable-init table"     >
                            <thead>
                                <tr>
                                    <th>Profile</th>

                                    <th>Address</th>
                                    @if (Auth::user()->hasPermissionTo('staff_update') || Auth::user()->hasPermissionTo('staff_delete'))
                                        <th></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($staffs as $staff)
                                    <tr class="nk-tb-item">

                                        <td>
                                            <div class="user-card">
                                                <img src="{{ asset($staff->profileImage()) }}" alt="" height="50px"
                                                    width="50px" class="border rounded-circle user-avatar">

                                                <div class="user-info">
                                                    <span class="tb-lead d-block">{{ $staff->username }}
                                                        <span class="dot dot-success d-md-none ms-1"></span>
                                                    </span>
                                                    <span>{{ $staff->email }}</span>
                                                </div>
                                            </div>
                                        </td>


                                        <td>
                                            {{ $staff->address }}
                                        </td>
                                        <td class="nk-tb-col nk-tb-col-tools">
                                            <ul class="nk-tb-actions gx-1">
                                           @can('staff_update')
                                           <li class="nk-tb-action-hidden"><button
                                            class="btn btn-trigger btn-icon" data-bs-toggle="modal"
                                        data-bs-target="#updatemodal" onclick="editdata({{ $staff }})"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Edit"><em
                                                class="icon ni ni-pen"></em></button>
                                    </li>

                                                <li class="nk-tb-action-hidden"><button
                                                    class="btn btn-trigger btn-icon" data-bs-toggle="modal"
                                                data-bs-target="#passwordmodal" onclick="staffpassword({{ $staff->id }})"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Edit"><em
                                                        class="icon ni ni-lock"></em></button>
                                            </li>
                                            @endcan
                                            @can('staff_delete')
                                                <li class="nk-tb-action-hidden"><button
                                                        class="btn btn-trigger btn-icon"  onclick='deletebtnalert(this, {{$staff->id}})'
                                                        data-bs-toggle="tooltip" data-bs-placement="top"0
                                                        title="Delete"><em
                                                            class="icon ni ni-trash"></em></button>
                                                </li>
                                                @endcan
                                                <li>

                                                </li>
                                            </ul>
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
@section('models')
    <div class="modal fade" id="updatemodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Staff Form</h5><a href="#" class="close" data-bs-dismiss="modal"
                        aria-label="Close"><em class="icon ni ni-cross"></em></a>
                </div>
                <div class="modal-body">
                    <form class="form-validate is-alter" id="updateform" action="{{ url('admin/staff/update') }}"
                        method="POST">
                        @csrf
                        <input type="hidden" name="id" value="0" id="id">
                        <div class="form-group"><label class="form-label" for="username">First Name</label>
                            <div class="form-control-wrap"><input type="text" class="form-control" id="editfirstname"
                                    name="firstname" required></div>
                        </div>
                        <div class="form-group"><label class="form-label" for="username">Last Name</label>
                            <div class="form-control-wrap"><input type="text" class="form-control" id="editlastname"
                                    name="lastname" required></div>
                        </div>

                        <div class="form-group"><label class="form-label" for="username">Username</label>
                            <div class="form-control-wrap"><input type="text" class="form-control" id="editusername"
                                    name="username" required></div>
                        </div>
                        <div class="form-group"><label class="form-label" for="email">Email</label>
                            <div class="form-control-wrap"><input type="email" class="form-control" id="editemail"
                                    name="email" required></div>
                        </div>

                        <div class="form-group"><label class="form-label" for="address">Address</label>
                            <div class="form-control-wrap"><input type="text" class="form-control" id="editaddress"
                                    name="address" required></div>
                        </div>
                        <div class="form-group"><label class="form-label" for="address">Role</label>
                            <div class="form-control-wrap">
                                <select name="role" id="editrole" class="form-control">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"> {{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>




                    </form>
                </div>
                <div class="modal-footer bg-light"><span class="sub-text">
                        <div class="form-group">
                            <button type="submit" class="btn  btn-warning" form="updateform">Save
                                Informations</button>
                        </div>
                    </span></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createmodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Staff Form</h5><a href="#" class="close" data-bs-dismiss="modal"
                        aria-label="Close"><em class="icon ni ni-cross"></em></a>
                </div>
                <div class="modal-body">
                    <form class="form-validate is-alter" id="categoryform" action="{{ url('admin/staff/save') }}"
                        method="POST">
                        @csrf
                        <div class="form-group"><label class="form-label" for="username">First Name</label>
                            <div class="form-control-wrap"><input type="text" class="form-control" id="firstname"
                                    name="firstname" required></div>
                        </div>
                        <div class="form-group"><label class="form-label" for="username">Last Name</label>
                            <div class="form-control-wrap"><input type="text" class="form-control" id="lastname"
                                    name="lastname" required></div>
                        </div>

                        <div class="form-group"><label class="form-label" for="username">Username</label>
                            <div class="form-control-wrap"><input type="text" class="form-control" id="username"
                                    name="username" required></div>
                        </div>
                        <div class="form-group"><label class="form-label" for="email">Email</label>
                            <div class="form-control-wrap"><input type="email" class="form-control" id="emaik"
                                    name="email" required></div>
                        </div>
                        <div class="form-group"><label class="form-label" for="password">Password</label>
                            <div class="form-control-wrap"><input type="password" class="form-control" id="password"
                                    name="password" required></div>
                        </div>
                        <div class="form-group"><label class="form-label" for="address">Address</label>
                            <div class="form-control-wrap"><input type="text" class="form-control" id="address"
                                    name="address" required></div>
                        </div>
                        <div class="form-group"><label class="form-label" for="address">Role</label>
                            <div class="form-control-wrap">
                                <select name="role" id="role" class="form-control">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"> {{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>




                    </form>
                </div>
                <div class="modal-footer bg-light"><span class="sub-text">
                        <div class="form-group">
                            <button type="submit" class="btn  btn-warning" form="categoryform">Save
                                Informations</button>
                        </div>
                    </span></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="passwordmodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Update Password</h5><a href="#" class="close"
                        data-bs-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
                </div>
                <div class="modal-body">
                    <form class="form-validate is-alter" id="passwordform"
                        action="{{ url('admin/staff/password/update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="0" id="passwordid">
                        <div class="form-group"><label class="form-label" for="password">New Password</label>
                            <div class="form-control-wrap"><input type="password" class="form-control" id="password"
                                    name="password" required></div>
                        </div>
                        <div class="form-group"><label class="form-label" for="password">Confirm Password</label>
                            <div class="form-control-wrap"><input type="password" class="form-control"
                                    id="password_confirmation" name="password_confirmation" required></div>
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
        let table = $('#blogtable').DataTable({
            searching: true,   // Enables the search box
            ordering: true,    // Enables column sorting


        });
        function deletebtnalert(row_id, id) {
            deleteurl = `{{ url('admin/staff/delete/') }}/${id}`;
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: false,
                showConfirmButton: false, // Disable the default confirm button
                html: `
                    <a href="${deleteurl}" class="swal2-confirm btn btn-danger" style="margin-right: 10px;">
                        Yes, delete it!
                    </a>
<button type="button" id='canceldelete' onclick="clsosebtn()" class="swal2-cancel btn btn-secondary swal2-styled" aria-label="" style="display: inline-block; background-color: #f4bd0e;">Cancel</button>
                `,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                }
            });

        }

        function deleteItem(row_id, id) {


            alert(deleteurl);
            window.location.replace(deleteurl);


        }

        function editdata(staff) {
            console.log(staff)
            document.getElementById('id').value = staff.id;
            document.getElementById('editfirstname').value = staff.FirstName;
            document.getElementById('editlastname').value = staff.LastName;
            document.getElementById('editusername').value = staff.username;
            document.getElementById('editemail').value = staff.email;
            document.getElementById('editaddress').value = staff.address
            document.getElementById('editrole').value = staff.role.name





        }

        function clsosebtn() {
            Swal.close();
        }

        function staffpassword(id) {
            document.getElementById('passwordid').value = id;
        }
    </script>
@endsection
