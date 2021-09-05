<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserChat extends Model
{
	protected $table = 'users_chats';
    protected $fillable = [
        'to',
        'from',
        'message',
        'globalDate',
        'emailsSent',
        'readMsg',
    ];
}
