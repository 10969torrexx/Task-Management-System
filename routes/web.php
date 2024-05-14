<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleSigninController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\TodoListsController;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


Route::get('/templates', function() {
    return view('template.tables-basic');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
# handle google
Route::post('auth/google', [GoogleSigninController::class, 'store'])->name('googleSignIn');

Route::middleware(['auth'])->group(function () {
    # tasks management
        Route::get('tasks/index', [TasksController::class, 'index'])->name('tasksIndex');
        Route::post('tasks/store', [TasksController::class, 'store'])->name('tasksStore');
        Route::post('tasks/destroy', [TasksController::class, 'destroy'])->name('tasksDestroy');
        Route::get('tasks/todos', [TasksController::class, 'todos'])->name('todos');
        Route::get('tasks/assign', [TasksController::class, 'assign'])->name('tasksAssign');
        Route::post('tasks/assign-task', [TasksController::class, 'assignTask'])->name('tasksAssignTask');
    # todo lists
        Route::post('todo-lists/store', [TodoListsController::class, 'store'])->name('todoListsStore');
        Route::post('todo-lists/destroy', [TodoListsController::class, 'destroy'])->name('todoListsDestroy');
    # team management
        Route::get('teams/index', [TeamsController::class, 'index'])->name('teamsIndex');
        Route::post('teams/store', [TeamsController::class, 'store'])->name('teamsStore');

    #user access
        Route::get('users/index', [UsersController::class, 'index'])->name('usersIndex');
        Route::get('users/tasks', [UsersController::class, 'tasks'])->name('usersTasks');
});