@extends('layouts.adminTemplate')

@section('adminContent')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Grades: {{ $student->name }}</h1>
        <a href="{{ route('students.index') }}" class="d-none d-sm-inline-block btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Students
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Grade Legend -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Grading System Legend</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Grade</th>
                                <th>Description</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.0</td>
                                <td>Excellent</td>
                                <td><span class="badge badge-success">PASSED</span></td>
                            </tr>
                            <tr>
                                <td>1.25</td>
                                <td>Very Good</td>
                                <td><span class="badge badge-success">PASSED</span></td>
                            </tr>
                            <tr>
                                <td>1.5</td>
                                <td>Very Good</td>
                                <td><span class="badge badge-success">PASSED</span></td>
                            </tr>
                            <tr>
                                <td>1.75</td>
                                <td>Good</td>
                                <td><span class="badge badge-success">PASSED</span></td>
                            </tr>
                            <tr>
                                <td>2.0</td>
                                <td>Good</td>
                                <td><span class="badge badge-success">PASSED</span></td>
                            </tr>
                            <tr>
                                <td>2.25</td>
                                <td>Satisfactory</td>
                                <td><span class="badge badge-success">PASSED</span></td>
                            </tr>
                            <tr>
                                <td>2.5</td>
                                <td>Satisfactory</td>
                                <td><span class="badge badge-success">PASSED</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Grade</th>
                                <th>Description</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2.75</td>
                                <td>Passing</td>
                                <td><span class="badge badge-warning">PASSED</span></td>
                            </tr>
                            <tr>
                                <td>3.0</td>
                                <td>Passing</td>
                                <td><span class="badge badge-warning">PASSED</span></td>
                            </tr>
                            <tr>
                                <td>3.25 - 4.0</td>
                                <td>Conditional</td>
                                <td><span class="badge badge-danger">FAILED</span></td>
                            </tr>
                            <tr>
                                <td>5.0</td>
                                <td>Failed</td>
                                <td><span class="badge badge-danger">FAILED</span></td>
                            </tr>
                            <tr>
                                <td>INC</td>
                                <td>Incomplete</td>
                                <td><span class="badge badge-secondary">PENDING</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Grades Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Student Grades</h6>
        </div>
        <div class="card-body">
            @if($student->subjects->isEmpty())
                <div class="alert alert-info">
                    This student is not enrolled in any subjects yet.
                </div>
            @else
                <form method="POST" action="{{ route('grades.update', $student) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="table-responsive">
                        <table class="table table-bordered" id="gradesTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Units</th>
                                    <th width="150">Grade</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->subjects as $subject)
                                    <tr>
                                        <td>{{ $subject->code }}</td>
                                        <td>{{ $subject->name }}</td>
                                        <td>{{ $subject->units }}</td>
                                        <td>
                                            <select class="form-control @error('grades.' . $subject->id) is-invalid @enderror"
                                                    name="grades[{{ $subject->id }}]">
                                                <option value="">Select Grade</option>
                                                @foreach(['1.0', '1.25', '1.5', '1.75', '2.0', '2.25', '2.5', '2.75', '3.0', '3.25', '3.5', '4.0', '5.0'] as $grade)
                                                    <option value="{{ $grade }}" 
                                                            {{ old('grades.' . $subject->id, $subject->pivot->grade) == $grade ? 'selected' : '' }}>
                                                        {{ $grade }}
                                                    </option>
                                                @endforeach
                                                <option value="INC" {{ old('grades.' . $subject->id, $subject->pivot->grade) == 'INC' ? 'selected' : '' }}>
                                                    INC
                                                </option>
                                            </select>
                                            @error('grades.' . $subject->id)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            @php
                                                $grade = $subject->pivot->grade;
                                                if ($grade === null || $grade === '') {
                                                    echo '<span class="badge badge-secondary">NOT SET</span>';
                                                } elseif ($grade === 'INC') {
                                                    echo '<span class="badge badge-secondary">PENDING</span>';
                                                } elseif ($grade <= 3.0) {
                                                    echo '<span class="badge badge-success">PASSED</span>';
                                                } else {
                                                    echo '<span class="badge badge-danger">FAILED</span>';
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Save Grades</button>
                        <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection

