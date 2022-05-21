<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Roles_Users extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];
    protected $table = 'roles_users';
}
