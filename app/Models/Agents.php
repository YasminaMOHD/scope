<?php

namespace App\Models;

use App\Models\User;
use App\Models\Projects;
use App\Models\Agents_lead;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agents extends Model
{
    use HasFactory ,SoftDeletes , Notifiable;
    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function project(){
        return $this->hasMany(Projects::class);
    }
    public function agent_lead(){
        return $this->hasMany(Agents_lead::class);
    }

}
