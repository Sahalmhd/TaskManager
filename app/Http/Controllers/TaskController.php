<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $tasks = Auth::user()->tasks;

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $view = view('tasks.ajax.create')->render(); // Infinite loop risk
        return response()->json(['view' => $view]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
        ]);

        $task = new Task();
        $task->user_id = Auth::id(); // Assign task to logged-in user
        $task->title = $request->title;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->status = $request->status;
        $task->priority = $request->priority;
        $task->save();

        return response()->json(['message' => 'Task created successfully!']);
    }


    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $view = view('tasks.ajax.edit', compact('task'))->render();
        return response()->json(['view' => $view]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        // Validate input fields
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
        ]);

        // Update task details
        $task->title = $request->title;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->status = $request->status;
        $task->priority = $request->priority;
        $task->save(); // Save updated task

        // Return success response
        return response()->json([
            'message' => 'Task updated successfully!',
            'task' => $task
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
{
    $task->delete();
    return response()->json(['message' => 'Task deleted successfully!']);
}
}
