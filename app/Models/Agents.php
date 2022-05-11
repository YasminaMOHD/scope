<?php

namespace App\Models;

use App\Models\User;
use App\Models\Projects;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agents extends Model
{
    use HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function project(){
        return $this->hasMany(Projects::class);
    }
}
