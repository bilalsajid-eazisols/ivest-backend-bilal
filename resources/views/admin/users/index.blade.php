@extends('layouts.admin')
@section('content')
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Customers </h3>

                </div>
                <div class="nk-block-head-content">
                    @can('user_add')
                    <button class="btn  btn-warning btn-icon " data-bs-toggle="modal" data-bs-target="#createmodal"><em class="icon ni ni-plus"></em></button>
                    @endcan
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
                                    <th>Profile</th>

                                    <th>Email Verified </th>
                                    <th>KYC  </th>

                                    <th> Date Of Birth</th>
                                    <th>Joining Date</th>
                                    <th>Address</th>

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="nk-tb-item">
                                        <td>
                                            <div class="user-card">
                                                <img src="{{asset($user->profileImage())}}" alt="" height="50px" width="50px" class="border rounded-circle user-avatar">
                                                <div class="user-info" >

                                                    <span class="tb-lead d-block "><strong>
                                                        <a  href="{{url("admin/user/$user->id")}}">
                                                        {{ $user->FirstName }} {{ $user->LastName }}</strong>
                                                        </a>
                                                        <span
                                                            class="dot dot-success d-md-none ms-1"></span>
                                                        </span>
                                                        <span>{{ $user->email }}</span>
                                                </div>
                                            </div>

                                        </td>
                                        <td>

                                                @if ($user->email_verified_at)
                                            <span class="badge badge-dim rounded-pill bg-outline-success">Verified</span>

                                            @else
                                            <span class="badge badge-dim rounded-pill  bg-outline-danger">Un Verified</span>


                                            @endif
                                        </td>
                                        <td>

                                                @if ($user->latestKyc && $user->latestKyc->status_id == 2)
                                            <span class="badge badge-dim rounded-pill bg-outline-success">Verified</span>

                                            @else
                                            <span class="badge badge-dim rounded-pill  bg-outline-danger">Un Verified</span>


                                            @endif

                                        </td>
                                        <td>
                                            {{$user->dob??''}}
                                        </td>

                                        <td>
                                            {{$user->getCreatedAtAttribute($user->created_at)}}
                                        </td>
                                        <td>
                                            {{ $user->address }}
                                        </td>
                                        <td class="nk-tb-col nk-tb-col-tools">
                                            <ul class="nk-tb-actions gx-1">
                                                <li class="nk-tb-action-hidden"><a
                                                        class="btn btn-trigger btn-icon"  href="{{url("admin/user/$user->id")}}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="View Details"><em
                                                            class="icon ni ni-eye"></em></a>
                                                </li>
                                           @can('user_update')
                                           <li class="nk-tb-action-hidden"><button
                                            class="btn btn-trigger btn-icon" data-bs-toggle="modal"
                                        data-bs-target="#updatemodal" onclick="editdata({{ $user }})"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Edit"><em
                                                class="icon ni ni-pen"></em></button>
                                    </li>
                                           <li class="nk-tb-action-hidden"><button
                                            class="btn btn-trigger btn-icon" data-bs-toggle="modal"
                                        data-bs-target="#passwordmodal" onclick="staffpassword({{ $user->id }})"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Edit"><em
                                                class="icon ni ni-lock"></em></button>
                                    </li>
                                           @endcan
                                                @can('user_delete')
                                                <li class="nk-tb-action-hidden"><button
                                                    class="btn btn-trigger btn-icon"  onclick='deletebtnalert(this, {{$user->id}})'
                                                    data-bs-toggle="tooltip" data-bs-placement="top"0
                                                    title="Delete"><em
                                                        class="icon ni ni-trash"></em></button>
                                            </li>
                                                @endcan


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
<div class="modal fade" id="updatemodal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Customer Form</h5><a href="#" class="close" data-bs-dismiss="modal"
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
                <h5 class="modal-title"> Customer  Form</h5><a href="#" class="close" data-bs-dismiss="modal"
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
@endsection
@section('extra-script')
    <script>
        {{--  let table = $('#blogtable').DataTable({
            searching: true,   // Enables the search box
            ordering: true,    // Enables column sorting


        });  --}}
        {{--  $('#blogtable').DataTable({
            order: [[5, 'desc']]
        });  --}}
        function deletebtnalert(row_id, id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteItem(row_id, id);
                }
            });
        }

        function deleteItem(row_id, id) {
            let tr = row_id.parentElement;


            $.ajax({
                url: `{{ url('admin/user/delete/') }}/${id}`,
                type: 'GET',
                success: function(response) {

                    Swal.fire(
                        'Deleted!',
                        'User  has been deleted.',
                        'success'
                    );
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000)
                },
                error: function(xhr) {
                    // console.log(xhr);
                    Swal.fire(
                        'Error!',
                        'Something Went Wrong',
                        'error'
                    );
                }
            });




        }



    </script>
    <script>
       $(document).ready(function(){
        let table = $.fn.dataTable.tables();
        let currenttable = $.fn.dataTable.tables()[0];
        let dtInstance = $(currenttable).DataTable();

        // Change the sorting order; for example, sort by the second column in ascending order
        dtInstance.order([[4, 'desc']]).draw();
       })
       function staffpassword(id) {
            document.getElementById('passwordid').value = id;
        }
        function editdata(user) {
            // console.log(staff)
            document.getElementById('id').value = user.id;
            document.getElementById('editfirstname').value = user.FirstName;
            document.getElementById('editlastname').value = user.LastName;
            document.getElementById('editusername').value = user.username;
            document.getElementById('editemail').value = user.email;
            document.getElementById('editaddress').value = user.address
            // document.getElementById('editrole').value = staff.role.name





        }
    </script>
@endsection
