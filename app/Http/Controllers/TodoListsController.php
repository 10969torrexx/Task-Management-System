<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;
use App\Models\Users;
use App\Models\TodoLists;
use Illuminate\Support\Facades\Auth;

class TodoListsController extends Controller
{
     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $todoLists = TodoLists::create([
            'task_id' => $request->task_id,
            'name' => $request->name,
            'user_id' => 0,
            'accomplished_flg' => 0
        ]);

        return redirect()->back();
    }
}
