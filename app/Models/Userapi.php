<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userapi extends Model
{
    use HasFactory;
    protected $table = 'apiusers'; 
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'avatar',
    ];
}
