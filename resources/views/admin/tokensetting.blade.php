@extends('layouts.admin')
@section('content')
    <style>

    </style>



    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Token List </h3>

                    </div>
                    <div class="nk-block-head-content">
                        @can('category_add')
                           
                            <button class="btn btn-icon btn-warning" data-bs-toggle="modal" data-bs-target="#categorymodel"><em
                                    class="icon ni ni-plus"></em></button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>  
        <div class="row g-gs">
            <div class="col-lg-12">
                <div class="card card-bordered card-preview">
                    <div class="card-inner">


                        <table class="datatable-init  table">
                            <thead>
                                <tr>

                                    <th>Name</th>
                                    <th>Symbol</th>
                                    <th>Conversion Rate</th>
                                    @if (Auth::user()->hasPermissionTo('category_update') || Auth::user()->hasPermissionTo('category_delete'))
                                        <th></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tokens as $token)
                                {{-- @php
                                echo '<pre>';
                                print_r($token);
                                echo '</pre>';
                                exit();
                                @endphp --}}
                                    <tr class="nk-tb-item">
                                        <td class="nk-tb-col">
                                            {{ $token['name'] }}
                                        </td>
                                        <td class="nk-tb-col">
                                            {{ $token['symbol'] }}
                                        </td>
                                        <td class="nk-tb-col">
                                            {{ $token['token_conversion_rate'] }}
                                        </td>

                                        <td class="nk-tb-col nk-tb-col-tools">
                                            <ul class="nk-tb-actions gx-1">
                                                @can('category_update')
                                                    <li class="nk-tb-action-hidden"><button data-bs-toggle="modal"
                                                            data-bs-target="#categorymodel"
                                                            onclick="editdata({{ $category }})"
                                                            class="btn btn-trigger btn-icon" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Edit"><em
                                                                class="icon ni ni-pen"></em></button>
                                                    </li>
                                                @endcan
                                                @can('category_delete')
                                                    <li class="nk-tb-action-hidden"><button class="btn btn-trigger btn-icon"
                                                            onclick='deletebtnalert(this, {{ $category }})'
                                                            data-bs-toggle="tooltip" data-bs-placement="top"0 title="Delete"><em
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
@endsection
@section('models')
    <div class="modal fade" id="categorymodel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Category</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form class="form-validate is-alter" id="categoryform">
                        <input type="hidden" name="id" value="0" id="id">
            
                        <div class="form-group">
                            <label class="form-label" for="name">Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label class="form-label" for="membershipclub">Membership Club ID</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="membershipclub" name="membershipclub_id">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label class="form-label" for="logo">Logo</label>
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label class="form-label" for="symbol">Symbol (Image)</label>
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="symbol" name="symbol" accept="image/*">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label class="form-label" for="token_conversion_rate">Token Conversion Rate</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="token_conversion_rate" 
                                    name="token_conversion_rate" step="0.01">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label class="form-label" for="transaction_fee">Transaction Fee</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="transaction_fee" 
                                    name="transaction_fee" step="0.01">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label class="form-label" for="metamask_wallet_address">MetaMask Wallet Address</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="metamask_wallet_address" 
                                    name="metamask_wallet_address">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label class="form-label" for="metamask_wallet_private_key">MetaMask Wallet Private Key</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="metamask_wallet_private_key" 
                                    name="metamask_wallet_private_key">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label class="form-label" for="token_contract_address">Token Contract Address</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="token_contract_address" 
                                    name="token_contract_address">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label class="form-label" for="initialsupply">Initial Supply</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="initialsupply" name="initialsupply" step="0.01">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label class="form-label" for="circulation">Circulation</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="circulation" name="circulation" step="0.01">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label class="form-label" for="totalsupply">Total Supply</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="totalsupply" name="totalsupply" step="0.01">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label class="form-label" for="created_at">Created At</label>
                            <div class="form-control-wrap">
                                <input type="datetime-local" class="form-control" id="created_at" name="created_at">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label class="form-label" for="updated_at">Updated At</label>
                            <div class="form-control-wrap">
                                <input type="datetime-local" class="form-control" id="updated_at" name="updated_at">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <span class="sub-text">
                        <div class="form-group">
                            <button type="submit" class="btn btn-warning" form="categoryform">Save Information</button>
                        </div>
                    </span>
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
                url: `{{ url('admin/categories/delete/') }}/${id}`,
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
                        ' Category Contains  Either Move Nenws to another cateogory or delete them . In case the error still Exist Contact Administrator',
                        'error'
                    );
                }
            });


        }
        document.getElementById('categoryform').addEventListener('submit', (e) => {
            e.preventDefault();
            {{--  console.log(this);  --}}
            form = document.getElementById('categoryform');
            const formData = new FormData(form);

            let id = document.getElementById('id').value;
            if (id > 0) {
                fetchurl = `{{ url('admin/categories/update') }}/${id}`
            } else {
                fetchurl = `{{ url('admin/category/save') }}`

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
            document.getElementById('name').value = blogcategory.name;
            if (blogcategory.status == 1) {
                document.getElementById('customCheck1').checked = true;
            }
            document.getElementById('type').value = blogcategory.type;

        }
    </script>
@endsection
