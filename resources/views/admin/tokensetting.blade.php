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
                           
                            <button class="btn btn-icon btn-warning" data-bs-toggle="modal" data-bs-target="#tokenmodel"><em
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
                                                        data-bs-target="#tokenmodel"
                                                        onclick="editdata({{ json_encode($token) }})"
                                                        class="btn btn-trigger btn-icon"
                                                        title="Edit">
                                                        <em class="icon ni ni-pen"></em>
                                                    </button>
                                                    
                                                    </li>
                                                @endcan
                                                @can('category_delete')
                                                <li class="nk-tb-action-hidden">
                                                    <button class="btn btn-trigger btn-icon"
                                                        onclick='deletebtnalert(this, @json($token["id"]))'
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                        <em class="icon ni ni-trash"></em>
                                                    </button>
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
    <div class="modal fade" id="tokenmodel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Token</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form class="form-validate is-alter" id="tokenform">
                        @csrf  <!-- CSRF Token added here -->
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
                            <label class="form-label" for="logo">Logo (Image)</label>
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label class="form-label" for="symbol">Symbol</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="symbol" name="symbol">
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
            
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <span class="sub-text">
                        <div class="form-group">
                            <button type="submit" class="btn btn-warning" form="tokenform">Save Information</button>
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
         
        // For Clear the form on Add button
        $('#tokenmodel').on('show.bs.modal', function () {
            $('#tokenform')[0].reset(); // Clear form fields
            $('#id').val(0);
        });





        // For Add new Token and Update Token
        $('#tokenform').submit(function (e) {
            e.preventDefault();
            
            let formData = new FormData(this);
            let tokenId = $('#id').val();  // Get ID

            let url = tokenId == 0 ? "{{ route('token.store') }}" : "{{ url('/token') }}/" + tokenId;
            let method = tokenId == 0 ? "POST" : "POST"; // Always POST, use `_method` for PUT

            if (tokenId != 0) {
                formData.append('_method', 'PUT'); // Laravel workaround for PUT request
            }

            $.ajax({
                url: url,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    Swal.fire({
                        title: "Processing...",
                        text: "Please wait while we save the data.",
                        icon: "info",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                success: function (response) {
                    Swal.fire({
                        title: "Success!",
                        text: response.success || "Data saved successfully!",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 2000  // Auto-close after 2 seconds
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON?.errors;
                    let errorMsg = "Something went wrong!";
                    
                    if (errors) {
                        errorMsg = "";
                        $.each(errors, function (key, value) {
                            errorMsg += value + "\n";
                        });
                    }

                    Swal.fire({
                        title: "Error!",
                        text: errorMsg,
                        icon: "error"
                    });
                }
            });
        });


        // For Deleting
        function deletebtnalert(element, id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/token/' + id,  // Laravel route
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                        },
                        success: function(response) {
                            Swal.fire(
                                "Deleted!",
                                "Your item has been deleted.",
                                "success"
                            );
                            
                            // Smoothly remove row from table
                            $(element).closest('tr').fadeOut(500, function() {
                                $(this).remove();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                "Error!",
                                "Something went wrong. Please try again.",
                                "error"
                            );
                        }
                    });
                }
            });
        }




        // For Getting the Data on the Edit Button
        function editdata(token) {
            $('#id').val(token.id);
            $('#name').val(token.name);
            $('#symbol').val(token.symbol);
            // $('#logo').val(token.logo);
            $('#membershipclub').val(token.membershipclub_id);
            $('#token_conversion_rate').val(token.token_conversion_rate);
            $('#transaction_fee').val(token.transaction_fee);
            $('#metamask_wallet_address').val(token.metamask_wallet_address);
            $('#metamask_wallet_private_key').val(token.metamask_wallet_private_key);
            $('#token_contract_address').val(token.token_contract_address);
            $('#initialsupply').val(token.initialsupply);
            $('#circulation').val(token.circulation);
            $('#totalsupply').val(token.totalsupply);

            $('#tokenmodel').modal('show');  // Modal Open karein
        }


       
        
    </script>
@endsection


