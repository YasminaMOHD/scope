<?php

namespace App\Models;

use App\Models\Lead;
use App\Models\Agents;
use App\Models\Landing;
use App\Models\Campagines;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Projects extends Model
{
    use HasFactory;
    protected $softDelete = true;
    protected $guarded=[];

    public function agent(){
        return $this->belongsTo(Agents::class);
    }
    public function lead(){
        return $this->hasMany(Lead::class);
    }
    public function campagine(){
        return $this->hasMany(Campagines::class,'project_id','id');
    }
    public function landing(){
        return $this->hasOne(Landing::class);
    }
}
