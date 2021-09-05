<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserChat extends Model
{
	protected $table = 'users_chats';
    protected $fillable = [
        'receiverId', // To
        'senderId', // From
        'message',
        'globalDate',
        'emailsSent',
        'readMsg',
		'is_admin',
    ];
	/*
	public function getFrontUserData() {
        return $this->belongsTo('App\Models\User', 'to', 'id');
    }

    public function getTrainerstUserData() {
        return $this->belongsTo('App\Models\User', 'from', 'id');
    }*/
	
	
}
