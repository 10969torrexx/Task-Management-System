<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailOTPs extends Model
{
    use HasFactory;
    protected $fillable = ['otp', 'email'];
    protected $table = 'email_otps';
}
