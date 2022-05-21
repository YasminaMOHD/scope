<?php

namespace App\Models;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];

    public function lead(){
        return $this->hasMany(Lead::class);
    }
}
