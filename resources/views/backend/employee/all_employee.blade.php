@extends('admin_dashboard')
@section('admin')

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-sm-0">Employee Masterlist</h4>
                    
                    <div class="page-title-right">
                        <div class="d-flex gap-2">
                            <a href="{{ route('employee.add') }}" class="btn btn-primary waves-effect waves-light shadow-sm">
                                <i class="mdi mdi-account-plus me-1"></i> Add Employee
                            </a>
                            <a href="{{ route('employee.print.masterlist') }}" class="btn btn-soft-success waves-effect waves-light shadow-sm">
                                <i class="mdi mdi-printer me-1"></i> Print Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        
                        <div class="table-responsive">
                            <table id="basic-datatable" class="table table-hover align-middle nowrap w-100">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th class="border-0 px-3">#</th>
                                        <th class="border-0">Employee Detail</th>
                                        <th class="border-0">Contact</th>
                                        <th class="border-0">Compensation</th>
                                        <th class="border-0 text-end px-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employee as $key => $item)
                                    <tr>
                                        <td class="px-3 text-muted">{{ $key + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="position-relative">
                                                    <img src="{{ (!empty($item->image)) ? asset($item->image) : url('upload/no_image.jpg') }}" 
                                                         class="rounded-circle border border-2 border-white shadow-sm" 
                                                         style="width: 45px; height: 45px; object-fit: cover;">
                                                    <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle"></span>
                                                </div>
                                                <div class="ms-3">
                                                    <h5 class="m-0 fs-14 text-dark font-bold">{{ $item->name }}</h5>
                                                    <small class="text-muted">{{ $item->designation ?? 'Staff Member'}}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark fs-13">{{ $item->email }}</span>
                                                <small class="text-muted mt-1"><i class="mdi mdi-phone-outline me-1"></i>{{ $item->phone }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold">
                                                ₱{{ number_format($item->salary, 2) }}
                                            </span>
                                        </td>
                                        <td class="text-end px-3">
                                            <div class="d-flex justify-content-end gap-1">
                                                @if(Auth::user()->can('employee.edit'))
                                                <a href="{{ route('employee.edit', $item->id) }}" class="btn btn-soft-blue btn-sm rounded-circle" data-bs-toggle="tooltip" title="Edit Profile">
                                                    <i class="mdi mdi-pencil fs-16"></i>
                                                </a>
                                                @endif

                                                @if(Auth::user()->can('employee.delete'))
                                                <a href="{{ route('employee.delete', $item->id) }}" class="btn btn-soft-danger btn-sm rounded-circle" id="delete" data-bs-toggle="tooltip" title="Remove Employee">
                                                    <i class="mdi mdi-delete fs-16"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> </div> </div> </div></div>
        </div> </div>     

@endsection

@section('jscripts')
    <script>
        $(document).ready(function() {
            // Re-initialize Tooltips for dynamic content
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            $('#basic-datatable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 25, 50],
                language: {
                    search: "",
                    searchPlaceholder: "Search employee records...",
                    lengthMenu: "Display _MENU_"
                },
                columnDefs: [
                    { orderable: false, targets: [1, 4] } 
                ],
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            });
        });
    </script>
@endsection