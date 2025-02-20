@extends('layouts.admin')
@section('content')
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">USA (United States of America ) Citizen </h3>

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
                                    <th>Email</th>
                                    <th>Submitted At</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($uscitzens as $uscitizen)
                                    <tr class="nk-tb-item">


                                      <td>
                                        {{$uscitizen->email}}
                                      </td>
                                      <td>
                                        {{$uscitizen->getCreatedAtAttribute($uscitizen->created_at)}}
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



    </script>
    <script>
       $(document).ready(function(){
        let table = $.fn.dataTable.tables();
        let currenttable = $.fn.dataTable.tables()[0];
        let dtInstance = $(currenttable).DataTable();

        // Change the sorting order; for example, sort by the second column in ascending order
        dtInstance.order([[4, 'desc']]).draw();
       })
    </script>
@endsection
