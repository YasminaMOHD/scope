<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'roles';
    protected $softDelete = true;
    protected $casts = [
        'permissions' => 'array',
    ];
}
