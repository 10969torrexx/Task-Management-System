<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tasks;
use App\Models\User;
use App\Models\TodoLists;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Tasks::where('task_manager_id', Auth::user()->id)->get();
        # get number of todo lists per task
        $todoListCount = [];
        foreach($tasks as $task) {
            $task->todo_lists = TodoLists::where('task_id', $task->id)->count();
            array_push($todoListCount, $task->todo_lists);
        }
        return view('tasks.index', compact('tasks', 'todoListCount'));
    }

    /**
 * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'deadline' => 'required|date'
        ]);

        $tasks = Tasks::create([
            'title' => $request->title,
            'task_manager_id' => Auth::user()->id,
            'deadline' => $request->deadline
        ]);

        return redirect(route('tasksIndex'));
    }

    /**
     * Display the specified resource.
     */
    public function todos(Request $request)
    {
        $tasks = Tasks::where('id', $request->id)->first();
        $todoLists = TodoLists::where('task_id', $request->id)->get();
        return view('tasks.update', compact('tasks', 'todoLists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {   
        $tasks = Tasks::where('id', $request->id)->delete();
        $todoList = TodoLists::where('task_id', $request->id)->delete();
        return response()->json(array(
            'status' => 200,
            'message' => 'Task deleted successfully!'
        ));
    }

    /**
     * show task assigned to user
     */
    public function assign() {
        $tasks = Tasks::where('task_manager_id', Auth::user()->id)->where('status', 0)->get();
        $hasAssigned = Tasks::where('task_manager_id', Auth::user()->id)->where('status', '!=', 0)->get();
        $assignedUsers = [];
        foreach ($hasAssigned as $key => $value) {
            array_push($assignedUsers, $value->assigned_to);
        }
        $members = User::where('role', 0)->whereNotIn('id', $assignedUsers)->get();
        $taskAssigned = Tasks::join('users', 'tasks.assigned_to', '=', 'users.id')
                     ->where('tasks.task_manager_id', Auth::user()->id)
                     ->where('tasks.assigned_to', '!=', 0)
                     ->select('tasks.*', 'users.name as assigned_to_name', 'users.name as user_email')
                     ->get();
        return view('tasks.assign', compact('tasks', 'members', 'taskAssigned'));
    }

    /**
     * assign task to user
     */
    public function assignTask(Request $request) {
        $task = Tasks::where('id', $request->task_id)->update([
            'assigned_to' => $request->assigned_to,
            'status' => 1
        ]);
        return response()->json(array(
            'status' => 200,
            'message' => 'Task assigned successfully!',
            'request' => $request->all()
        ));
    }
}
