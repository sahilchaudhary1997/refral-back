<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class DashboardNotification extends Model
{
    protected $table = 'dashboardnotification';
    protected $fillable = [
        'title',
		'description',
		'notifytype',
        'order',	
        'is_active',
        'is_delete',
	    'notifyvideo'
    ];
	
	
}
