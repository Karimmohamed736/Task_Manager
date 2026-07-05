<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Services\TaskService;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = (new TaskService())->getAllTasks(request());
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return (new TaskService())->create(request()->all());
    }

    public function store(StoreTaskRequest $request)
    {
        return (new TaskService())->store($request);
    }

    public function edit(Task $task)
    {
        return (new TaskService())->edit($task);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        return (new TaskService())->update($task, $request);
    }

    public function destroy(Task $task)
    {
        return (new TaskService())->delete($task);
    }

    public function toggleStatus(Task $task)
    {
        return (new TaskService())->toggleTaskStatus($task);
    }

}
