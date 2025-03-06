@extends('layouts.adminTemplate')

@section('adminContent')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Enroll Student: {{ $student->name }}</h1>
        <a href="{{ route('students.index') }}" class="d-none d-sm-inline-block btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Students
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Currently Enrolled Subjects -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Currently Enrolled Subjects</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="enrolledSubjectsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Units</th>
                                    <th>Grade</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->subjects as $subject)
                                    <tr>
                                        <td>{{ $subject->code }}</td>
                                        <td>{{ $subject->name }}</td>
                                        <td>{{ $subject->units }}</td>
                                        <td>
                                            @if($subject->pivot->grade)
                                                <span class="badge badge-info">{{ $subject->pivot->grade }}</span>
                                            @else
                                                <span class="badge badge-secondary">Not Graded</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('enroll.remove', ['student' => $student, 'subject' => $subject]) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                @if($subject->pivot->grade)
                                                    <button type="button" 
                                                            class="btn btn-danger btn-sm" 
                                                            disabled 
                                                            data-toggle="tooltip" 
                                                            data-placement="top" 
                                                            title="Cannot remove subject with existing grade">
                                                        <i class="fas fa-times"></i> Remove
                                                    </button>
                                                @else
                                                    <button type="submit" 
                                                            class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Are you sure you want to unenroll from this subject?')">
                                                        <i class="fas fa-times"></i> Remove
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Subjects -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Available Subjects</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="availableSubjectsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Units</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($availableSubjects as $subject)
                                    <tr>
                                        <td>{{ $subject->code }}</td>
                                        <td>{{ $subject->name }}</td>
                                        <td>{{ $subject->units }}</td>
                                        <td>
                                            <form action="{{ route('enroll.store', $student) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-plus"></i> Add
                                                </button>
                                            </form>
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

@push('styles')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            $('#enrolledSubjectsTable').DataTable({
                "pageLength": 5,
                "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]]
            });
            
            $('#availableSubjectsTable').DataTable({
                "pageLength": 5,
                "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]]
            });
        });
    </script>
@endpush
