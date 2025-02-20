@extends('layouts.admin')
@section('content')
    <style>

    </style>

    <div class="nk-block nk-block-lg">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Member List  </h3>

                </div>
                <div class="nk-block-head-content">
                  
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
                                    <th>Member</th>


                                    <th> Date Of Birth</th>
                                    <th>Joind Since</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                    <tr>
                                        <td>
                                            <div class="user-card">
                                                <img src="{{asset($member->user->profileImage())}}" alt="" height="50px" width="50px" class="border rounded-circle user-avatar">
                                                {{--  <div class="user-avatar bg-primary"><span>AB</span></div>  --}}

                                                <div class="user-info">
                                                    <span class="tb-lead d-block">{{ $member->user->username }}
                                                        <span
                                                            class="dot dot-success d-md-none ms-1"></span>
                                                        </span>
                                                        <span>{{ $member->user->email }}</span>
                                                </div>
                                            </div>

                                        </td>

                                        <td>
                                            {{$member->user->dob??''}}
                                        </td>


                                        <td>
                                            {{  $member->getCreatedAtAttribute( $member->created_at)  }}
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
    <div class="modal fade" id="categorymodel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Blog Category </h5><a href="#" class="close" data-bs-dismiss="modal"
                        aria-label="Close"><em class="icon ni ni-cross"></em></a>
                </div>
                <div class="modal-body">
                    <form class="form-validate is-alter" id="categoryform">
                        <input type="hidden" name="id" value="0" id="id">
                        <div class="form-group"><label class="form-label" for="full-name">Name</label>
                            <div class="form-control-wrap"><input type="text" class="form-control" id="name"
                                    name="name" required></div>
                        </div>
                        <div class="form-group">


                            <div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input"
                                    value="1" name="is_active" id="customCheck1"><label class="custom-control-label"
                                    for="customCheck1">Is Active ?</label>
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
        document.getElementById('categoryform').addEventListener('submit', (e) => {
            e.preventDefault();
            {{--  console.log(this);  --}}
            form = document.getElementById('categoryform');
            const formData = new FormData(form);

            let id = document.getElementById('id').value;
            if (id > 0) {
                fetchurl = `{{ url('admin/blog-categories/update/') }}/${id}`
            } else {
                fetchurl = `{{ url('admin/blog-category/save') }}`

            }
            fetch(fetchurl, {
                    method: 'POST',
                    body: formData, // The FormData object
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')
                        .value, // CSRF token for Laravel
                        'accept': 'application/json'
                    }

                }).then(response => {
                    if (!response.ok) {
                        console.log(response);
                    }
                    return response.json(); // Parse the JSON response
                })
                .then(data => {
                    console.log('Success:', data);
                    Swal.fire(
                        'Success !',
                        data,
                        'success'
                    ).then((result) => {
                        window.location.reload();
                    });


                })
                .catch(error => {
                    console.log(error);
                    Swal.fire(
                        'Error !',
                        error.message,
                        'error'
                    );
                });


        })

        function editdata(blogcategory) {
            document.getElementById('id').value = blogcategory.id;
            document.getElementById('name').value = blogcategory.display;
            if (blogcategory.is_active == 1) {
                document.getElementById('customCheck1').checked = true;
            }

        }
    </script>
@endsection
