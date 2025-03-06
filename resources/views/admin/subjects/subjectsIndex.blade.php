@extends('layouts.adminTemplate')

@section('adminContent')
    @include('components.delete-confirmation-modal', ['item' => 'subject'])

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Subjects</h1>
        <a href="{{ route('subjects.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Subject
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

    <!-- Subjects List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Subjects</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Units</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subjects as $subject)
                            <tr>
                                <td>{{ $subject->code }}</td>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->units }}</td>
                                <td>{{ Str::limit($subject->description, 50) }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            @if($subject->students()->exists())
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm" 
                                                        disabled 
                                                        data-toggle="tooltip" 
                                                        data-placement="top" 
                                                        title="Cannot delete subject with enrolled students">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            @else
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm delete-btn" 
                                                        data-toggle="modal" 
                                                        data-target="#deleteConfirmationModal"
                                                        data-form-id="{{ $subject->id }}">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            @endif
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
            $('#dataTable').DataTable();
        });
    </script>

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <!-- Add the delete confirmation handling script -->
    <script>
        $(document).ready(function() {
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
