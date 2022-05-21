<?php

namespace App\Models;

use App\Models\User;
use App\Models\Agents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];

    public function agent(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
