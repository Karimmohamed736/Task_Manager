<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

Class TaskService
{

    public function getAllTasks(Request $request){
        return Task::search($request->query('search'))->latest()->paginate(10)->withQueryString();
    }

    public function create(array $data)
    {
        return view('Tasks.create');
    }

    public function store(StoreTaskRequest $request)
    {
        Task::create($request->validated());
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        return view('Tasks.edit', compact('task'));
    }

    public function update(Task $task, UpdateTaskRequest $request)
    {
        $task->update($request->validated());
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function delete(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function toggleTaskStatus(Task $task)
    {
        $task->status = $task->isCompleted() ? 'pending' : 'completed';
        $task->save();
        return redirect()->route('tasks.index')->with('success', 'Task status updated successfully.');
    }

}
