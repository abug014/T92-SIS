@extends('layouts.adminTemplate')

@section('adminContent')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Subject</h1>
        <a href="{{ route('subjects.index') }}" class="d-none d-sm-inline-block btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to List
        </a>
    </div>

    <!-- Edit Subject Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Subject Information</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('subjects.update', $subject) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="code">Subject Code</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                           id="code" name="code" value="{{ old('code', $subject->code) }}" required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Subject Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $subject->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="units">Units</label>
                    <input type="number" class="form-control @error('units') is-invalid @enderror" 
                           id="units" name="units" value="{{ old('units', $subject->units) }}" required min="1" max="6">
                    @error('units')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description', $subject->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Subject</button>
                <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection