@extends('Layouts.app')

@section('title', 'All Tasks')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Tasks</h2>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ New Task</a>
    </div>

    {{-- Search bar --}}
    <form method="GET" action="{{ route('tasks.index') }}" class="form-inline mb-4">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            class="form-control mr-2"
            placeholder="Search by title or status..."
            style="width: 300px;"
        >
        <button type="submit" class="btn btn-outline-secondary mr-2">Search</button>

        @if (request('search'))
            <a href="{{ route('tasks.index') }}" class="btn btn-link">Clear</a>
        @endif
    </form>

    @if ($tasks->isEmpty())
        <div class="alert alert-info">
            No tasks found. @if(!request('search'))<a href="{{ route('tasks.create') }}">Create your first task</a>.@endif
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th style="width: 260px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr class="{{ $task->isCompleted() ? 'table-success' : '' }}">
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ Str::limit($task->description, 50) ?: '—' }}</td>
                            <td>{{ $task->created_at->format('d M Y, h:i A') }}</td>
                            <td>
                                @if ($task->isCompleted())
                                    <span class="badge badge-success">Completed</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                {{-- Toggle status --}}
                                <form action="{{ route('tasks.toggleStatus', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                        Mark as {{ $task->isCompleted() ? 'Pending' : 'Completed' }}
                                    </button>
                                </form>

                                {{-- Edit --}}
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>

                                {{-- Delete (triggers modal) --}}
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-danger"
                                    data-toggle="modal"
                                    data-target="#deleteModal{{ $task->id }}"
                                >
                                    Delete
                                </button>

                                {{-- Delete confirmation modal --}}
                                <div class="modal fade" id="deleteModal{{ $task->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirm Deletion</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete
                                                <strong>{{ $task->title }}</strong>? This action cannot be undone.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $tasks->links() }}
        </div>
    @endif

@endsection
