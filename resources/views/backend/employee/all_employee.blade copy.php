@extends('admin_dashboard')
@section('admin')

<div class="content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">All Employees</h4>
                    <a href="{{ route('employee.add') }}" class="btn btn-primary rounded-pill waves-effect waves-light">
                        <i class="mdi mdi-account-plus me-1"></i> Add Employee
                    </a>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table id="basic-datatable" class="table table-striped table-hover align-middle dt-responsive nowrap w-100">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Salary</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employee as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <img src="{{ asset($item->image) }}" class="rounded-circle" style="width:50px; height:50px; object-fit:cover;">
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>₱{{ number_format($item->salary, 2) }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                @if(Auth::user()->can('employee.edit'))
                                                <a href="{{ route('employee.edit', $item->id) }}" class="btn btn-sm btn-blue" data-bs-toggle="tooltip" title="Edit Employee">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                @endif

                                                @if(Auth::user()->can('employee.delete'))
                                                <a href="{{ route('employee.delete', $item->id) }}" class="btn btn-sm btn-danger" id="delete" data-bs-toggle="tooltip" title="Delete Employee">
                                                    <i class="mdi mdi-delete"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive -->

                    </div> <!-- end card body -->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->

    </div> <!-- container -->
</div>    

@endsection

@section('jscripts')
    <script>
        $(document).ready(function() {
            $('#basic-datatable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search employees..."
                },
                columnDefs: [
                    { orderable: false, targets: [1, 6] } // Disable sorting for Image and Action columns
                ]
            });
        });
    </script>
@endsection