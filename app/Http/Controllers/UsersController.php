<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tasks;
use App\Models\User;
use App\Models\TodoLists;
class UsersController extends Controller
{
    /**
     * Task management
     */
        public function index() {
            $tasks = Tasks::join('users as member', 'tasks.assigned_to', '=', 'member.id')
                ->where('member.id', Auth::user()->id)
                ->join('users as task_manager', 'tasks.task_manager_id', '=', 'task_manager.id')
                ->select('tasks.*', 'member.name as member_name', 'task_manager.name as taskmanager_name')
                ->get();
            return view('users.index', compact('tasks'));
        }
        public function tasks(Request $request) {
            $tasks = Tasks::where('id', $request->id)->get();
            dd($tasks->toArray());
            return view('users.tasks', compact('tasks'));
        }
    // End of Task management
}
