@extends('admin_dashboard')
@section('admin')

<div class="content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <a href="{{ route('add.advance.salary') }}" class="btn btn-primary rounded-pill waves-effect waves-light">
                                <i class="mdi mdi-plus-circle me-1"></i> Add Advance Salary 
                            </a>  
                        </ol>
                    </div>
                    <h4 class="page-title">Advance Salary Management</h4>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <p class="text-muted font-14 mb-3">
                            List of all employees who have requested advance payments for specific months.
                        </p>

                        <table id="basic-datatable" class="table dt-responsive nowrap w-100 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>Name</th>
                                    <th>Target Month</th>
                                    <th>Basic Salary</th>
                                    <th>Advance Amount</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                @forelse($salary as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td> 
                                        <img src="{{ (!empty($item['employee']['image'])) ? asset($item['employee']['image']) : asset('upload/no_image.jpg') }}" 
                                             class="rounded-circle img-thumbnail shadow-sm" 
                                             style="width:50px; height: 50px; object-fit: cover;"> 
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ $item['employee']['name'] ?? 'Unknown Employee' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-info text-info px-2 py-1">
                                            <i class="mdi mdi-calendar me-1"></i>{{ $item->month ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="fw-semibold">
                                        ₱{{ number_format((float)($item['employee']['salary'] ?? 0), 2) }}
                                    </td>
                                    <td class="text-danger fw-bold">
                                        ₱{{ number_format((float)($item->advance_salary ?? 0), 2) }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('edit.advance.salary',$item->id) }}" 
                                               class="btn btn-sm btn-outline-blue waves-effect waves-light me-1" 
                                               title="Edit">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <a href="{{ route('delete.advance.salary',$item->id) }}" 
                                               class="btn btn-sm btn-outline-danger waves-effect waves-light" 
                                               id="delete" 
                                               title="Delete">
                                                <i class="mdi mdi-trash-can"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="mdi mdi-alert-circle-outline font-24"></i>
                                        <p>No advance salary records found.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div> </div> </div></div>
        </div> </div> <style>
    .bg-soft-info {
        background-color: rgba(59, 175, 218, 0.1);
    }
    .img-thumbnail {
        padding: 0.15rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
    }
    table.dataTable.nowrap th, table.dataTable.nowrap td {
        white-space: normal !important; /* Allows text wrapping if name is too long */
    }
</style>

@endsection

