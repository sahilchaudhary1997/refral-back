<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AdvisoryNotification extends Model
{
    protected $table = 'advisory_notification';
    protected $fillable = [
        'userId',
        'parentId',
        'moduleId',
        'marketId',
        'courseId',
        'advisorySection',
        'expiryDate',
        'tradeDate',
        'script',
        'action_trade',
        'quantity',
        'price',
        'value',
        'stoploss',
        'target',
        'timeline',
        'description',        
        'is_active',
        'is_delete',
        'status',
        'isBuySale',
        'created_at',
        'updated_at',
    ];
	
	public function getAdvisorySubscribeUsers($ModuleType ="",$CourserId =""){

        $userresponse = array();
        if($ModuleType !="" && $CourserId !=""){
            $currentdate = date('Y-m-d H:i:s');
            $userresponse = User::select('users.id', 'users.name','payments_history.id as historyId','payments_history.id as paymentId')
             ->join('payments_history', 'payments_history.userid', '=', 'users.id')
             ->join('users_devicetoken', 'users_devicetoken.userid', '=', 'users.id')
             ->groupBy("users.id")
             ->where('payments_history.package_enddate', '>=', $currentdate)
             ->where('payments_history.moduletype', $ModuleType)
             ->where('payments_history.courseid', $CourserId)
             ->where('users.isVerified', '1')
             ->where('payments_history.payment_status', 'S')
             ->get()->toArray();
        }

        return $userresponse;
    }
}
