<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class PaymentsHistory extends Model
{
    protected $table = 'payments_history';
    protected $fillable = [        
		'payment_id',
        'amount',
		'userid',
		'courseid',
		'receipt',
		'currency',
		'orderid',
		'entity',
		'amount_paid',
		'amount_due',
		'offer_id',
		'status',
		'attempts',
		'notes',
		'order_created_at',
		'signature',
		'payment_status',
		'package_startdate',
		'package_enddate',
		'course_title',
		'course_duration',
		'moduletype',
		'modulename',
		'level',		
		'levelname'
    ];
	
	
}
