<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $fillable = [ 
		'title',
		'txtMessage',
        'intUserId',
        'is_read',        
		'is_active',
        'is_delete',        
    ];
}
