
@extends('layouts.admin')
@section('content')
<style>

</style>

<div class="nk-block nk-block-lg">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Blog  List </h3>

            </div>
            <div class="nk-block-head-content">
                @can('blog_add')
                <a href="{{ url('admin/news/create') }}" class="btn  btn-warning btn-icon"><em class="icon ni ni-plus"></em> </a>


                @endcan
            </div>
        </div>
    </div>
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card card-bordered card-preview">
                <div class="card-inner">


                    <table class="datatable-init  table" >
                        <thead>
                            <tr>

                                <th>Title</th>

                                <th>Category</th>
                                <th>Status</th>
                                <th>Author</th>
                                @if (Auth::user()->hasPermissionTo('blog_update') || Auth::user()->hasPermissionTo('blog_delete'))


                                <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($newss as $news)
                            <tr class="nk-tb-item">
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <img src="{{asset($news->thumbnail)}}" alt="" height="50px" width="50px" class="user-avatar bg-dim-primary d-none d-sm-flex">
                                        <div class="user-info"><span class="tb-lead"> {{$news->title}}
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    {{$news->category->name??''}}
                                </td>
                                <td>
                                    @if ($news->status == 2)
                                    <span class="tb-status text-success">Published</span>
                                    @endif
                                    @if ($news->status == 1)
                                    <span class="tb-status text-secondary">Draft</span>
                                    @endif
                                    @if ($news->status == 0)
                                    <span class="tb-status text-danger">Cancelled</span>
                                    @endif
                                </td>
                                <td>
                                    {{$news->author->username}}
                                </td>
                                <td class="nk-tb-col nk-tb-col-tools">
                                    <ul class="nk-tb-actions gx-1">
@can('blog_update')


                                        <li class="nk-tb-action-hidden"><a href="{{url("admin/news/create?id=$news->id")}}"
                                                class="btn btn-trigger btn-icon"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Edit"><em
                                                    class="icon ni ni-pen"></em></a>
                                        </li>
                                        @endcan
                                        @can('blog_delete')
                                        <li class="nk-tb-action-hidden"><button
                                            class="btn btn-trigger btn-icon"  onclick='deletebtnalert(this, {{$news->id}})'
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
@endsection
@section('extra-script')
<script>
    $(document).ready(function() {
        var tableElement = $('#blogtable');

        if ($.fn.DataTable.isDataTable(tableElement)) {
            // If DataTable is already initialized, use the existing instance
            var table = tableElement.DataTable();
            table.ajax.reload(); // Reload data without destroying the table
        } else {
            // Initialize DataTable if it hasn't been initialized yet
            tableElement.DataTable({
                processing: true,
                serverSide: true,
                responsive:true,
                ajax: window.location.href,
                pageLength: 10, // Default page length
                lengthMenu: [10, 25, 50, 100],
                rowId: 'id',
                columns: [
                    // Use this for index column
                    { data: 'title', name: 'title' },
                    {{--  { data: 'excerpt', name: 'excerpt' },  --}}
                    { data: 'newscategory_id', name: 'newscategory_id' },
                    { data: 'created_by', name: 'created_by' },
                    @if (Auth::user()->hasPermissionTo('blog_update') || Auth::user()->hasPermissionTo('blog_delete'))
                    { data: 'action', name: 'action' },
                    @endif

                    // Add other columns as needed
                ]
            });
        }
    });
    function deletebtnalert(row_id,id){
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
                    deleteItem(row_id,id);
                }
            });
        }
        function deleteItem(row_id,id) {
            let tr =row_id.parentElement;

            tr =  tr.parentElement,
            tr = tr.getAttribute('id');
            let table = $('#blogtable').DataTable();
            $.ajax({
                url: `{{url('news/delete')}}/${id}`, // Replace with your delete endpoint
                type: 'GET',
                success: function(response) {
                    // Remove the row from the DataTable
                    {{--  table.row($(tr).parents('tr')).remove().draw();  --}}
                    Swal.fire(
                        'Deleted!',
                        'News has been deleted.',
                        'success'
                    );
                    setTimeout(()=>{
                        window.location.reload()
                    },1000)
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'There was a problem deleting the News.',
                        'error'
                    );
                }
            });

        }


</script>
@endsection
