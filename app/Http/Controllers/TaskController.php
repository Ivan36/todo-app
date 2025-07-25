<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->get();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
       $data = $request->validate([
           'title' => 'required|string|max:255',
           'description' => 'nullable|string'
       ]);
       $data['user_id'] = auth()->id();
        Task::create($data);
        
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Task created successfully']);
        }
        return redirect('/');
    }

    public function update(Request $request, Task $task)
    {
        // Check if user owns this task
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
       $data = $request->validate([
           'title' => 'required|string|max:255',
           'description' => 'nullable|string'
       ]);
        $task->update($data);
        
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Task updated successfully']);
        }
        return redirect('/');
    }

    public function destroy(Task $task)
    {
        // Check if user owns this task
        if ($task->user_id !== auth()->id()) {
            return redirect('/')->with('error', 'Unauthorized');
        }
        
        $task->delete();
        return redirect('/');
    }

    public function toggle(Request $request, Task $task)
    {
        // Check if user owns this task
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Refresh task from database to ensure we have latest state
        $task->refresh();
        
        $currentStatus = $task->is_complete;
        $requestedStatus = $request->boolean('is_complete');
        
        // Debug logging
        Log::info('Toggle Debug', [
            'task_id' => $task->id,
            'current_status_before' => $currentStatus,
            'requested_status' => $requestedStatus,
            'raw_input' => $request->input('is_complete'),
            'user_id' => auth()->id()
        ]);
        
        $task->is_complete = $requestedStatus;
        $task->save();
        
        // Refresh to confirm the save worked
        $task->refresh();
        
        $message = $task->is_complete ? 'Task marked as complete.' : 'Task marked as incomplete.';
        
        return response()->json([
            'success' => true, 
            'message' => $message,
            'is_complete' => $task->is_complete,
            'debug' => [
                'old_status' => $currentStatus,
                'requested_status' => $requestedStatus,
                'final_status' => $task->is_complete
            ]
        ]);
    }
}
