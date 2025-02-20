@extends('layouts.admin')
@section('content')
    <style>
        th {
            text-align: left !important;
        }
    </style>

    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h4 class="title nk-block-title">Roles & Permissions </h4>

            </div>
        </div>
        <div class="row g-gs">
            <div class="col-lg-8">
                <div class="card card-bordered h-100">
                    <div class="card-inner pb-0">
                        <div class="card-head">

                            <h5 class="card-title">Role Form </h5>

                        </div>
                        <form action="{{url('admin/roles/submit')}}" method="post">

                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="" class="form-label">Name</label>
                                        <div class="form-control-warp">
                                            <input type="text" name="name" id="name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        Name
                                                    </th>
                                                    <th>View</th>
                                                    <th>Add</th>
                                                    <th>Update</th>
                                                    <th>Delete</th>
                                                </tr>

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Blogs</td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="blog_view"
                                                            value="blog_view">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="blog_add"
                                                            value="blog_add">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="blog_update"
                                                            value="blog_update">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="blog_delete"
                                                            value="blog_delete">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Categories

                                                    </td>
                                                    <td >
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="category_view" value="category_view">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="category_add" value="category_add">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="category_update" value="category_update">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="category_delete" value="category_delete">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Customers

                                                    </td>
                                                    <td >
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="user_view" value="user_view">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="user_add" value="user_add">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="user_update" value="user_update">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="user_delete" value="user_delete">
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td>
                                                        KYC
                                                    </td>
                                                    <td >
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="kyc_view" value="kyc_view">
                                                    </td>
                                                    <td>
                                                        {{-- <input type="checkbox" class='form-check-input' name="permission[]" id="kyc_add" value="kyc_add"> --}}
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="kyc_update" value="kyc_update">
                                                    </td>
                                                    <td>
                                                        {{-- <input type="checkbox" class='form-check-input' name="permission[]" id="kyc_delete" value="kyc_delete"> --}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        MemberShip Club

                                                    </td>
                                                    <td >
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="membershipclub_view" value="membershipclub_view">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="membershipclub_add" value="membershipclub_add">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="membershipclub_update" value="membershipclub_update">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="membershipclub_delete" value="membershipclub_delete">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Roles & permissions

                                                    </td>
                                                    <td >
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="role_view" value="role_view">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="role_add" value="role_add">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="role_update" value="role_update">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="role_delete" value="role_delete">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Staff
                                                    </td>
                                                    <td >
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="staff_view" value="staff_view">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="staff_add" value="staff_add">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="staff_update" value="staff_update">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="staff_delete" value="staff_delete">
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td>
                                                        Settings
                                                    </td>
                                                    <td >
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="setting_view" value="setting_view">
                                                    </td>
                                                    <td>
                                                        {{--  <input type="checkbox" class='form-check-input' name="permission[]" id="blog_add" value="blog_add">  --}}
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class='form-check-input' name="permission[]" id="setting_update" value="setting_update">
                                                    </td>
                                                    <td>
                                                        {{--  <input type="checkbox" class='form-check-input' name="permission[]" id="blog_delete" value="blog_delete">  --}}
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-12 text-end mt-2">
                                        <input type="hidden" name="id" value="0" id="id">
                                        <a href="{{url('admin/roles')}}" class="btn btn-danger">Back</a>
                                        <button type="submit" class="btn btn-warning">Save Information</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
    </div>
@endsection

@section('extra-script')
    <script>
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
                    // Call the function to delete the item here
                    deleteItem(row_id, id);
                }
            });
        }

        function deleteItem(row_id, id) {
            let tr = row_id.parentElement;

            {{--  tr = tr.parentElement,  --}}
            {{--  tr = tr.getAttribute('id');  --}}
            let table = $('#blogtable').DataTable();
            $.ajax({
                url: `{{ url('blog-categories/delete/') }}/${id}`,
                type: 'GET',
                success: function(response) {

                    Swal.fire(
                        'Deleted!',
                        'Blog Category has been deleted.',
                        'success'
                    );
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000)
                },
                error: function(xhr) {
                    console.log(xhr);
                    Swal.fire(
                        'Error!',
                        'Blog Category Contains Blogs Either Move Blogs to another cateogory or delete them . In case the error still Exist Contact Administrator',
                        'error'
                    );
                }
            });
            // Your delete logic here (e.g., an AJAX request)
            {{--  console.log('Item deleted');
            Swal.fire(
                'Deleted!',
                'Blog Has been  been deleted.',
                'success'
            );  --}}

            ;


            {{--  console.log(tr.remove());  --}}

        }


       @isset($_GET['id'])
       @php
           $id = $_GET['id'];
       @endphp
          let   fetchurl = `{{url("admin/role/$id")}}`;
          fetch(fetchurl)
          .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json(); // Parses the JSON response into a JavaScript object
        })
        .then(data => {
            console.log('data ', data); // Handle the JSON data here

            document.getElementById('id').value = data.id;
            document.getElementById('name').value = data.name;

            permissions = data.permissions;
            for(var i = 0; i < permissions.length  ;i ++){
                const permission = permissions[i];
                console.log(permission.name);

               let chk =   document.getElementById(permission.name);
            console.log(chk);
            chk.checked = true
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
       @endisset
    </script>
@endsection
