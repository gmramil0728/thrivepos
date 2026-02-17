@extends('admin_dashboard')
@section('admin')

<style>
    /* Full Width Toggle Container */
    .attendance-toggle {
        display: flex;
        background-color: #f1f3f5;
        border-radius: 8px;
        padding: 4px;
        border: 1px solid #dee2e6;
        overflow: hidden;
        width: 100%; /* Spans full width of the cell */
        margin: 0;
    }

    .attendance-toggle input {
        display: none;
    }

    .attendance-toggle label {
        flex: 1;
        padding: 10px 0;
        margin: 0;
        text-align: center;
        cursor: pointer;
        font-weight: 700;
        color: #adb5bd;
        transition: all 0.2s ease-in-out;
        font-size: 13px;
        text-transform: uppercase;
    }

    /* Active Selection Emphasis */
    .attendance-toggle input.present:checked + label {
        background-color: #1abc9c !important;
        color: white !important;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(26, 188, 156, 0.3);
    }

    .attendance-toggle input.leave:checked + label {
        background-color: #f1c40f !important;
        color: #343a40 !important;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(241, 196, 15, 0.3);
    }

    .attendance-toggle input.absent:checked + label {
        background-color: #e74c3c !important;
        color: white !important;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(231, 76, 60, 0.3);
    }

    .bulk-action {
        cursor: pointer;
        color: white !important;
        font-weight: bold;
    }
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('employee.attend.list') }}" class="btn btn-primary rounded-pill">
                            <i class="mdi mdi-view-list me-1"></i> Attendance List
                        </a>
                    </div>
                    <h4 class="page-title">Edit Employee Attendance</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('employee.attend.update') }}" method="post" id="myForm">
                            @csrf
                            <div class="row mb-3">
                                <div class="form-group col-md-4">
                                    <label for="date" class="form-label fw-bold">Attendance Date</label>
                                    <input type="date" name="date" id="date" class="form-control bg-light" 
                                           value="{{ $editData['0']['date'] }}" readonly>
                                    <small class="text-muted italic">Note: Date cannot be changed during edit.</small>
                                </div>
                            </div>

                            <table class="table table-bordered table-striped dt-responsive nowrap w-100">
                                <thead class="table-dark">
                                    <tr>
                                        <th rowspan="2" class="text-center align-middle" width="5%">Sl.</th>
                                        <th rowspan="2" class="text-center align-middle">Employee Name</th>
                                        <th colspan="3" class="text-center align-middle">Attendance Status</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center bulk-action present_all" style="background-color: #16a085;">Present All</th>
                                        <th class="text-center bulk-action leave_all" style="background-color: #f39c12;">Leave All</th>
                                        <th class="text-center bulk-action absent_all" style="background-color: #c0392b;">Absent All</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($editData as $key => $item)
                                    <tr class="align-middle">
                                        <input type="hidden" name="employee_id[]" value="{{$item->employee_id}}">
                                        <td class="text-center">{{$key+1}}</td>
                                        <td class="fw-bold">{{$item['employee']['name'] ?? 'John Doe'}}</td>
                                        <td colspan="3">
                                          <div class="attendance-toggle">
                                             {{-- Changed value to "Present" with capital P --}}
                                             <input class="present" id="present{{$key}}" name="attend_status{{$key}}" value="Present" type="radio" 
                                                 {{ $item->attend_status == 'Present' || $item->attend_status == 'present' ? 'checked' : '' }}>
                                             <label for="present{{$key}}">Present</label>
                                         
                                             <input class="leave" id="leave{{$key}}" name="attend_status{{$key}}" value="Leave" type="radio" 
                                                 {{ $item->attend_status == 'Leave' ? 'checked' : '' }}>
                                             <label for="leave{{$key}}">Leave</label>
                                         
                                             <input class="absent" id="absent{{$key}}" name="attend_status{{$key}}" value="Absent" type="radio" 
                                                 {{ $item->attend_status == 'Absent' ? 'checked' : '' }}>
                                             <label for="absent{{$key}}">Absent</label>
                                         </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-success btn-lg px-4">
                                    <i class="mdi mdi-update me-1"></i> Update Attendance Record
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('jscripts')
<script type="text/javascript">
    $(document).ready(function() {
        // Bulk Actions
        $('.present_all').on('click', function() {
            $('input.present').prop('checked', true);
        });

        $('.leave_all').on('click', function() {
            $('input.leave').prop('checked', true);
        });

        $('.absent_all').on('click', function() {
            $('input.absent').prop('checked', true);
        });
    });

    @if(session('message'))
      Swal.fire({
         icon: '{{ session('alert-type') }}',
         title: '{{ session('alert-type') === 'success' ? 'Success!' : (session('alert-type') === 'error' ? 'Error!' : 'Info') }}',
         text: '{{ session('message') }}',
         toast: true, position: 'top-end',
         showConfirmButton: false, timer: 3000, timerProgressBar: true,
         background: '#1a1d24', color: '#f0f2f7',
      });
   @endif


</script>
@endsection

