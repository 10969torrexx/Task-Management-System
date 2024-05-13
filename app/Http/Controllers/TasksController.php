<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TasksController extends Controller
{
    /**
     * TODO: view all task
     */
        public function tasks() {
            // $tasks = Task::get();
            return view('tasks.index');
        }
}
