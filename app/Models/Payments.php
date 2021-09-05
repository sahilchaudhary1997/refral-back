<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Payments extends Model
{
    protected $fillable = [        
		'payment_id',      
		'userid',		
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
		'total_amount',
		'discount_total',
		'grand_total',
		'discount',	
    ];
	
	
}
