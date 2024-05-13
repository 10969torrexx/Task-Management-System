<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoLists extends Model
{
    use HasFactory;
    protected $fillable = [
        'task_id',
        'name',
        'user_id',
        'accomplished_flg',
    ];
}
