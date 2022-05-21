<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Agents;
use App\Models\Description;
use App\Models\Roles_Users;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     *
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function agent(){
      return  $this->hasOne(Agents::class);
    }
    public function discription(){
      return  $this->hasMany(Description::class);
    }
    public function roles(){
        return $this->belongsToMany(Roles_Users::class);
    }

    public function hasAbility($ability){
        $role = Role::whereRaw('name = ?',[$this->user_type])->get();
        if($role){
            foreach($role as $r){
                if(in_array($ability, $r->permissions)){
                    return true;
                }
            }
            return false;
        }
    }
}
