<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Teams;
use App\Models\Tasks;
use App\Models\User;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Tasks::where('task_manager_id', Auth::user()->id)->get();
        $members = User::join('tasks', 'tasks.id', '=', 'users.id')
            ->select('tasks.title', 'users.*')
            ->where('users.role', 0)
            ->get();
        return view('teams.index', compact('tasks', 'members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $checkIfMemberExists = Teams::where('member_id', $request->member_id)->first();
        if($checkIfMemberExists) {
            $updateTeams = Teams::here('member_id', $request->member_id)->update([
                'task_id' => $request->task_id
            ]);
            return response()->json(array(
                'status' => 200,
                'message' => 'Member updated to task successfully!'
            ));
        }
        $teams = Teams::create([
            'task_manager_id' => Auth::user()->id,
            'task_id' => $request->task_id,
            'member_id' => $request->member_id
        ]);
        if($teams) {
            return response()->json(array(
                'status' => 200,
                'message' => 'Member added to task successfully!'
            ));
        }
        return response()->json(array(
            'status' => 500,
            'message' => 'Failed to add member to task!'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
