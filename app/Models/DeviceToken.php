<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
	 protected $table = 'users_devicetoken';
    protected $fillable = [        
		'userid',
        'deviceToken',           
    ];
}
