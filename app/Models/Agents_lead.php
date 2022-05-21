<?php

namespace App\Models;

use App\Models\Lead;
use App\Models\Agents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agents_lead extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];
    protected $table = 'agents_lead';
    protected $casts = [
        'leads' => 'array',
    ];
    public function agent(){
        return $this->belongsTo(Agents::class,'agent_id','id');
    }

}
