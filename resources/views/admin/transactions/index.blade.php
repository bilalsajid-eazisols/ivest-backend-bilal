@extends('layouts.admin')
@section('content')
    <style>

    </style>

    {{-- @php
        echo "<pre>";
        print_r($transactions);
        echo "</pre>";
        exit();
    @endphp --}}

    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Transactions List </h3>

                    </div>
                    {{-- <div class="nk-block-head-content">
                        @can('category_add')
                           
                            <button class="btn btn-icon btn-warning" data-bs-toggle="modal" data-bs-target="#categorymodel"><em
                                    class="icon ni ni-plus"></em></button>
                        @endcan
                    </div> --}}
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

                                    <th>Profile</th>
                                    
                                    <th>TransactionId</th>
                                    <th>User Wallet</th>
                                    <th>tx_hash</th>
                                    <th>Status</th>
                                    <th>Amount Usdt</th>
                                    <th>Amount IVT</th>
                                    <th>Created_at</th>
                                    {{-- @if (Auth::user()->hasPermissionTo('category_update') || Auth::user()->hasPermissionTo('category_delete'))
                                        <th></th>
                                    @endif --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr class="nk-tb-item">
                                        <td class="nk-tb-col">
                                            {{ $transaction['username'] }}
                                            <br>
                                            {{ $transaction['email'] }}
                                        </td>

                                        <td class="nk-tb-col">
                                            {{ $transaction['transaction_id'] }}
                                        </td>
                                 
                                        <td class="nk-tb-col">
                                            {{ $transaction['user_wallet_address'] }}
                                        </td>
                                    
                                        <td class="nk-tb-col">
                                            {{ $transaction['tx_hash'] }}
                                        </td>
                                    
                                        <td class="nk-tb-col">
                                            {{ $transaction['status'] }}
                                        </td>
                                   
                                        <td class="nk-tb-col">
                                            {{ $transaction['amount_usdt'] }}
                                        </td>
                                    
                                        <td class="nk-tb-col">
                                            {{ $transaction['amount_ivt'] }}
                                        </td>
                                   
                                        <td class="nk-tb-col">
                                            {{ $transaction['created_at'] }}
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
    <style>
        .break-word {
            white-space: normal !important;
            word-wrap: break-word;
            max-width: 200px; /* Adjust width as needed */
        }
    </style>
    
    
@endsection

@section('extra-script')
<script>
   
</script>



@endsection
