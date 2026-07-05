@extends('Layouts.app')

@section('title', 'Edit Task')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Edit Task</h2>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">← Back to List</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('tasks.update', $task) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Task Title <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $task->title) }}"
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
                    >{{ old('description', $task->description) }}</textarea>
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
                        <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Task</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-link">Cancel</a>
            </form>
        </div>
    </div>

@endsection
