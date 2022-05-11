<?php

namespace App\Models;

use App\Models\Lead;
use App\Models\Projects;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campagines extends Model
{
    use HasFactory;
    protected $softDelete = true;
    protected $guarded=[];

    public function lead(){
        return $this->hasMany(Lead::class);
    }
    public function project(){
        return $this->hasMany(Projects::class,'project_id','id');
    }
}
