@extends('layouts.app')

@section('title', 'Create Task')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Create New Task</h2>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">← Back to List</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('tasks.store') }}">
                @csrf

                <div class="form-group">
                    <label for="title">Task Title <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}"
                        placeholder="e.g. Prepare project report"
                    >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Task Description <span class="text-muted">(optional)</span></label>
                    <textarea
                        name="description"
                        id="description"
                        rows="4"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Add any extra details..."
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Task Status <span class="text-danger">*</span></label>
                    <select
                        name="status"
                        id="status"
                        class="form-control @error('status') is-invalid @enderror"
                    >
                        <option value="">-- Select Status --</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Create Task</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-link">Cancel</a>
            </form>
        </div>
    </div>

@endsection
