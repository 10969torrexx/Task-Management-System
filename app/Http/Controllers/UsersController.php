<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tasks;
use App\Models\User;
use App\Models\TodoLists;
use Illuminate\Support\Facades\Session;
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
            $tasks = Tasks::where('id', $request->id)->first();
            $todoLists = TodoLists::where('task_id', $tasks->id)->get();
            return view('users.tasks', compact('tasks', 'todoLists'));
        }

        public function updateTasksStatus(Request $request) {
            $tasks = Tasks::where('id', $request->id)->update([
                'status' => $request->status
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Task status updated',
                'request' => $request->all()
            ]);
        }

        public function updateTodoStatus(Request $request) {
            $todoLists = TodoLists::where('id', $request->id)->update([
                'accomplished_flg' => $request->accomplished_flg
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Todo List updated!',
                'request' => $request->all()
            ]);
        }
    // End of Task management

        public function register(Request $request) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z]).+$/'],
            ]);
            
            Session::put('googleUser', $request->all());
            return redirect()->route('emailOtpIndex', ['email' => $request->email]);
        }

        public function login(Request $request) {
            $request->validate([
                'email' => ['required'],
                'password' => ['required']
            ]);
            $user = User::where('email', $request->email)->first();
            if ($user && password_verify($request->password, $user->password)) {
                Auth::login($user);
                return response()->json([
                    'status' => 200,
                    'message' => 'Login successful',
                    'account' => $user
                ]);
            }
            return response()->json([
                'status' => 300,
                'message' => 'Invalid email or password'
            ]);
        }
}
