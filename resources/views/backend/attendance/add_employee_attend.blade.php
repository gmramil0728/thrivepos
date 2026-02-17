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

    /* Selection States with High Emphasis */
    
    /* PRESENT: Emerald Green */
    .attendance-toggle input.present:checked + label {
        background-color: #1abc9c !important;
        color: white !important;
        border-radius: 25px;
        box-shadow: 0 4px 6px rgba(26, 188, 156, 0.3);
    }

    /* LEAVE: Amber/Yellow */
    .attendance-toggle input.leave:checked + label {
        background-color: #f1c40f !important;
        color: #343a40 !important;
        border-radius: 25px;
        box-shadow: 0 4px 6px rgba(241, 196, 15, 0.3);
    }

    /* ABSENT: Crimson Red */
    .attendance-toggle input.absent:checked + label {
        background-color: #e74c3c !important;
        color: white !important;
        border-radius: 25px;
        box-shadow: 0 4px 6px rgba(231, 76, 60, 0.3);
    }

    /* Bulk Action Header Styling */
    .bulk-action {
        cursor: pointer;
        transition: transform 0.1s;
        border: none !important;
        color: white !important;
        font-weight: bold;
    }
    .bulk-action:active { transform: scale(0.95); }
</style>

<div class="content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('employee.attend.list') }}" class="btn btn-blue rounded-pill">
                            <i class="mdi mdi-format-list-bulleted me-1"></i> View Attendance List
                        </a>
                    </div>
                    <h4 class="page-title">Take Daily Attendance</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('employee.attend.store') }}" method="post" id="attendanceForm">
                            @csrf
                            
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label for="date" class="form-label fw-bold text-dark">Attendance Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="mdi mdi-calendar"></i></span>
                                        <input type="date" name="date" id="date" class="form-control" 
                                               value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-9 text-end align-self-end">
                                    <span class="text-muted small italic">* Click color headers to mark all employees at once</span>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-centered table-bordered table-hover mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th rowspan="2" class="text-center align-middle" width="50">#</th>
                                            <th rowspan="2" class="align-middle">Employee Details</th>
                                            <th colspan="3" class="text-center">Select Attendance Status</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center bulk-action present_all" style="background-color: #16a085;">SET ALL PRESENT</th>
                                            <th class="text-center bulk-action leave_all" style="background-color: #f39c12;">SET ALL LEAVE</th>
                                            <th class="text-center bulk-action absent_all" style="background-color: #c0392b;">SET ALL ABSENT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $key => $employee)
                                        <tr>
                                            <input type="hidden" name="employee_id[]" value="{{$employee->id}}">
                                            <td class="text-center fw-bold text-muted">{{ $key+1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-xs me-2">
                                                        <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                            {{ substr($employee->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                    <span class="fw-bold text-dark">{{ $employee->name }}</span>
                                                </div>
                                            </td>
                                            <td colspan="3">
                                                <div class="attendance-toggle">
                                                    <input class="present" id="present{{$key}}" name="attend_status{{$key}}" value="Present" type="radio" checked>
                                                    <label for="present{{$key}}">Present</label>

                                                    <input class="leave" id="leave{{$key}}" name="attend_status{{$key}}" value="Leave" type="radio">
                                                    <label for="leave{{$key}}">Leave</label>

                                                    <input class="absent" id="absent{{$key}}" name="attend_status{{$key}}" value="Absent" type="radio">
                                                    <label for="absent{{$key}}">Absent</label>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                                        <i class="mdi mdi-content-save-check me-1"></i> Save Attendance Records
                                    </button>
                                </div>
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

        // Simple Validation
        $('#attendanceForm').on('submit', function() {
            let date = $('#date').val();
            if (!date) {
                Swal.fire('Error', 'Please select a valid date', 'error');
                return false;
            }
            return true;
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