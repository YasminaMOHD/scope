<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles_Users extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'roles_users';
}
