@extends('layouts.adminTemplate')

@section('adminContent')
    @include('components.delete-confirmation-modal', ['item' => 'student'])

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Students Management</h1>
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

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Registered Students</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Year Level</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->user->name }}</td>
                                <td>{{ $student->user->email }}</td>
                                <td>{{ $student->age }}</td>
                                <td>{{ $student->year_level }}</td>
                                <td>
                                    <a href="{{ route('enroll.create', $student) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-user-plus"></i>
                                    </a>
                                    <a href="{{ route('grades.edit', $student) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-graduation-cap"></i>
                                    </a>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        @if($student->subjects()->exists())
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm" 
                                                    disabled 
                                                    data-toggle="tooltip" 
                                                    data-placement="top" 
                                                    title="Cannot delete student with enrolled subjects">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm delete-btn" 
                                                    data-toggle="modal" 
                                                    data-target="#deleteConfirmationModal"
                                                    data-form-id="{{ $student->id }}">
                                                <i class="fas fa-trash"></i>
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
@endsection

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[0, "asc"]], // Sort by first column (Name) by default
                "language": {
                    "search": "Search:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "Showing 0 to 0 of 0 entries",
                    "infoFiltered": "(filtered from _MAX_ total entries)",
                    "emptyTable": "No data available in table",
                    "zeroRecords": "No matching records found"
                }
            });
            
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Store the form that triggered the modal
            let formToSubmit = null;

            // When delete button is clicked, store the associated form
            $('.delete-btn').on('click', function() {
                formToSubmit = $(this).closest('form');
            });

            // When confirm delete button in modal is clicked
            $('#confirmDeleteButton').on('click', function() {
                if (formToSubmit) {
                    formToSubmit.submit(); // Submit the stored form
                }
                $('#deleteConfirmationModal').modal('hide');
            });

            // When modal is hidden, clear the stored form
            $('#deleteConfirmationModal').on('hidden.bs.modal', function() {
                formToSubmit = null;
            });
        });
    </script>
@endpush
