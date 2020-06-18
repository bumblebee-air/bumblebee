@extends('templates.dashboard')

@section('page-styles')
    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}"/>
@endsection
@section('page-content')
    <div class="content">
        <div class="container-fluid">
            <h2>Suppliers</h2>
            <div class="row">
                <div class="col">
                    <a href="{{url('suppliers/import')}}" class="btn btn-primary">Import suppliers</a>
                </div>
                <div class="col">
                    <div style="text-align: right">
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                            Delete Suppliers
                        </button>
                    </div>
                    <!-- Delete modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Delete all suppliers</h5>
                                </div>
                                <div class="modal-body">
                                    <form action="{{url('suppliers/delete-all')}}" method="post">
                                        {{csrf_field()}}
                                        <input type="hidden" name="do_delete" value="1"/>
                                        <h3>Are you sure you want to delete all the suppliers?</h3>
                                        <div style="text-align: center;">
                                            <button class="btn btn-danger" type="submit">Yes</button>
                                            <button type="button" class="btn btn-info ml-2" data-dismiss="modal">No</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col">
                    <div class="material-datatables">
                        <table id="users-table" class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suppliers as $supplier)
                                    <tr>
                                        <td>{{$supplier->name}}</td>
                                        <td>{{$supplier->phone}}</td>
                                        <td>{{$supplier->email}}</td>
                                        <td class="text-right">
                                            <a href="#" class="btn btn-link btn-info btn-just-icon"><i class="fas fa-pen"></i></a>
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

@section('page-scripts')
    <script src="{{asset('js/datatables.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#users-table').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records",
                }
            });
        });
    </script>
@endsection