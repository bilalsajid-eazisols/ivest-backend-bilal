@extends('layouts.admin')
@section('content')
    <style>

    </style>
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Membership Clubs </h3>

                </div>
                <div class="nk-block-head-content">
                    @can('membershipclub_add')
                        <a href="{{ route('membershipclubs.create') }}?step=1" class="btn  btn-warning btn-icon"><em
                                class="icon ni ni-plus"></em> </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="row g-gs">
            <div class="col-lg-12">
                <div class="card card-bordered preview">
                    <div class="card-inner ">

                        <table class="datatable-init table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Total Members </th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    @if (Auth::user()->hasPermissionTo('membershipclub_update') || Auth::user()->hasPermissionTo('membershipclub_delete'))
                                        <th></th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($membershipclubs as $membershipclub)
                                    <tr class="nk-tb-item">
                                        <td>
                                            <a>{{ $membershipclub->title }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ url("admin/users?id=$membershipclub->id") }}">
                                                {{ $membershipclub->totalclubmembers ?? 0 }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $membershipclub->rating ?? 0 }}
                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                            {{ $membershipclub->created_at }}
                                        </td>
                                        <td class="nk-tb-col nk-tb-col-tools">
                                            <ul class="nk-tb-actions gx-1">
                                                @can('membershipclub_update')
                                                    <li class="nk-tb-action-hidden"><a
                                                            href="{{ route('membershipclubs.create') }}?step=1&id={{ $membershipclub->id }}"
                                                            class="btn btn-trigger btn-icon" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Edit"><em
                                                                class="icon ni ni-pen"></em></a>
                                                    </li>
                                                @endcan
                                                @can('membershipclub_delete')
                                                    <li class="nk-tb-action-hidden"><button class="btn btn-trigger btn-icon"
                                                            onclick="deletebtnalert({{ $membershipclub->id }},{{ $membershipclub->id }})"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><em
                                                                class="icon ni ni-trash"></em></button>
                                                    </li>
                                                @endcan
                                                @can('membershipclub_update')
                                                    <li>

                                                        <div class="drodown"><a href="#"
                                                                class="dropdown-toggle btn btn-icon btn-trigger"
                                                                data-bs-toggle="dropdown"><em
                                                                    class="icon ni ni-more-h"></em></a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <ul class="link-list-opt no-bdr">
                                                                    <ul class="link-list-opt">
                                                                        <li><a
                                                                                href="{{ route('membershipclubs.create') }}?step=1&id={{ $membershipclub->id }}"><span>Basic
                                                                                    Info</span></a></li>
                                                                        <li><a
                                                                                href="{{ route('membershipclubs.create') }}?step=2&id={{ $membershipclub->id }}"><span>Futher
                                                                                    Details</span></a></li>
                                                                        <li><a
                                                                                href="{{ route('membershipclubs.create') }}?step=3&id={{ $membershipclub->id }}"></em><span>Token
                                                                                    Details</span></a></li>
                                                                        <li><a
                                                                                href="{{ route('membershipclubs.create') }}?step=4&id={{ $membershipclub->id }}"></em><span>Blogs
                                                                                    & News</span></a>
                                                                        </li>
                                                                        <li><a
                                                                                href="{{ route('membershipclubs.create') }}?step=5&id={{ $membershipclub->id }}"></em><span>Libarary</span></a>
                                                                        </li>
                                                                    </ul>
                                                                </ul>
                                                            </div>
                                                        </div>
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

@section('extra-script')
    <script>
        let table = $('#blogtable').DataTable({
            searching: true, // Enables the search box
            ordering: true, // Enables column sorting


        });

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
                url: `{{ url('admin/membershipclubs/delete') }}/${id}`,
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
