<?php

namespace App\Models;

use App\Models\Lead;
use App\Models\Agents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agents_lead extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'agents_lead';
    protected $softDelete = true;
    protected $casts = [
        'leads' => 'array',
    ];
    public function agent(){
        return $this->belongsTo(Agents::class,'agent_id','id');
    }

}
