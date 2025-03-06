@extends('layouts.adminTemplate')

@section('adminContent')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Subject</h1>
        <a href="{{ route('subjects.index') }}" class="d-none d-sm-inline-block btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to List
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Create Subject Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Subject Information</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('subjects.store') }}">
                @csrf

                <div class="form-group">
                    <label for="code">Subject Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                           id="code" name="code" value="{{ old('code') }}" required
                           placeholder="Enter subject code (e.g., IT101)">
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Only letters, numbers, and hyphens are allowed.</small>
                </div>

                <div class="form-group">
                    <label for="name">Subject Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required
                           placeholder="Enter subject name (e.g., Computer Programing 1)">
        
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="units">Units <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('units') is-invalid @enderror" 
                           id="units" name="units" value="{{ old('units') }}" required
                           min="1" max="7" >
                    @error('units')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3"
                              placeholder="Enter subject description (optional)">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save fa-sm text-white-50 mr-1"></i>
                        Save Subject
                    </button>
                    <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times fa-sm text-white-50 mr-1"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
