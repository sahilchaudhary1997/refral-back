<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Payments extends Model
{
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
		'razorpay_order_id',
		'payment_status',
		'moduletype',
		'modulename',		
		'level',		
		'levelname'		
    ];
	
	
}
