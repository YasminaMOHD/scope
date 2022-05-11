<?php

namespace App\Models;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;
    protected $softDelete = true;
    protected $guarded=[];

    public function lead(){
        return $this->hasMany(Lead::class);
    }
}
