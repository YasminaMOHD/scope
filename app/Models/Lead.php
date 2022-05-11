<?php

namespace App\Models;

use App\Models\Status;
use App\Models\Projects;
use App\Models\Campagines;
use App\Models\Description;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    use HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $guarded=[];


    public function project(){
        return $this->belongsTo(Projects::class,'project_id','id');
    }
    public function status(){
        return $this->belongsTo(Status::Class);
    }
    public function Campagines(){
        return $this->belongsTo(Campagines::Class,'campagine_id','id');
    }
    public function desc(){
        return $this->hasMany(Description::Class);
    }
}
