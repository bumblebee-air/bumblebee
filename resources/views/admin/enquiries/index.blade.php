@extends('templates.dashboard')
@section('page-styles')
<style>
    h3 {
        margin-top: 0;
        font-weight: bold;
    }

    .main-panel>.content {
        margin-top: 0px;
    }

    .swal2-popup .swal2-styled:focus {
        box-shadow: none !important;
    }
</style>
@endsection
@section('page-content')

<div class="content">
    <div class="container-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose">
                            <div class="card-icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <h4 class="card-title ">General Enquiries</h4>
                        </div>
                        <div class="card-body">
                            <div class="float-right">
                                <a class="btn btn-success btn-sm" href="{{ url('general-enquiry/add') }}">Add New</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th style="width:33%">Customer Name</th>
                                        <th style="width:33%">Phone</th>
                                        <th>Action</th>
                                    </thead>

                                    <tbody>
                                        @if($enquiries && count($enquiries))
                                        @foreach($enquiries as $enquiry)
                                        <tr>
                                            <td>
                                                {{$enquiry->customer_name}}
                                            </td>
                                            <td>
                                                {{$enquiry->customer_phone}}
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn btn-info" href="{{ url('general-enquiry/edit/'.$enquiry->id) }}">Edit</a>
                                                <!--<a class="btn btn-sm btn btn-danger" deleteLink="{{ url('general-enquiry/delete/'.$enquiry->id) }}" href="#" onclick="confirmDelete(this)">Delete</a>-->
                                            </td>

                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="3" class="text-center"><strong>No data found.</strong></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <nav aria-label="pagination" class="float-right">
                                    {{ !empty($enquiries) ? $enquiries->links('vendor.pagination.bootstrap-4') : ''}}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('page-scripts')
<script src="{{asset('js/sweetalert2.js')}}"></script>
<script type="text/javascript">
    function confirmDelete(obj) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4caf50',
            cancelButtonColor: '#f44336',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                var link = $(obj).attr('deleteLink');
                window.location.href = link;
            }
        })
    };
</script>
@endsection