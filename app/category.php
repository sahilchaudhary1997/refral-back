<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class category extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gender_id','parent_id','name','is_active','is_delete'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
     public static function getList() {
        return Self::all();
    }
    
    public static function getCategory($id)
    {
        return category::find($id);
    }
    
    public static function getParentList()
    {
        return Self::where('parent_id',0)->get();
    }
    public static function getParentCategory($id)
    {
        return Self::where('id',$id)->first();
    }
    
}
