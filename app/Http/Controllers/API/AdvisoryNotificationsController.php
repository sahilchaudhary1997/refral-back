<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
// use App\Models\Language;
// use App\Models\Markets;
// use App\Models\Courses;
use App\Models\AdvisoryNotification;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Image;

class AdvisoryNotificationsController extends Controller
{
    public function getAdvisoryNotificationList(Request $request)
    {
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];

		$user = Auth::user();
		
		if(!empty($user)){
			
			$userid = $user->id;
			
			// $currentdate = date('Y-m-d H:i:s');
            // $advisoryresponse = User::select('payments_history.courseid','courses.varTitle as CourseTitle')
            //  ->join('payments_history', 'payments_history.userid', '=', 'users.id')
			//  ->join('courses', 'courses.id', '=', 'payments_history.courseid')
            //  ->where('payments_history.package_enddate', '>=', $currentdate)
            //  ->where('payments_history.moduletype', '2')
            //  ->where('payments_history.userid', $userid)
            //  ->where('users.isVerified', '1')
            //  ->where('payments_history.payment_status', 'S')
            //  ->get()->toArray();

			$notificationquery = AdvisoryNotification::select('module_types.name as moduleTitle','courses.varTitle as CourseTitle', 'advisory_notification.id','advisory_notification.tradeDate as tradeDate', 'advisory_notification.description as message', 'advisory_notification.userId as userId')
             ->join('markets', 'markets.id', '=', 'advisory_notification.marketId')
			 ->join('module_types', 'module_types.id', '=', 'advisory_notification.moduleId')
			 ->join('courses', 'courses.id', '=', 'advisory_notification.courseId')
             ->where('advisory_notification.moduleId', '2')
             ->where('advisory_notification.userId', $userid)
			 ->orderBy('advisory_notification.created_at','desc');
				
			if(isset($request->offset) && $request->offset!="" && isset($request->limit) && $request->limit!=""){
				$offset = $request->offset;
				if($offset == 1){
					$offset = 0;
				}else{
					$offset = $request->offset;
				}
				$notificationquery->offset($offset);
			}
			if(isset($request->limit) && $request->limit!="" && isset($request->offset) && $request->offset!="" ){
				$notificationquery->limit($request->limit);
			}
			
			$notifications = $notificationquery->get();			
		
			if(!empty($notifications)) {			
				
				$response = [
					'status' => true,
					'statusCode' => 200,
					'data'  => $notifications,
					'errormessage' => [],
					'message' => ''
				];
				
			}else{
				
				$response = [
					'status' => true,
					'statusCode' => 200,
					'data'  => [],
					'errormessage' => [],
					'message' => 'Advisory Notifications not exists.'
				];
			} 		
		}
		
		return response()->json($response);		
	}	
	
	/*
	public function readNotification(Request $request)
    {
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];		
	
        $user = Auth::user();
			
		if(!empty($user)){
		
		    $userid = $user->id;
			$up = Notifications::where('intUserId', $userid)->update([
					'is_read' => '1'					
				  ]);
				
		    if($up){
				
				$response = [
                    'status' => true,
                    'statusCode' => 200,
                    'data'  => [],
        			'errormessage' => [],
                    'message' => 'Your notification has been updated!'
                ];				
		   }
		}
		
		return response()->json($response);
	}
	
	public function getNotificationCount(Request $request)
    {
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];	
		
		$user = Auth::user();
		
		if(!empty($user)){
			
			$userid = $user->id;
			
			$notificationquery = Notifications::select('id','txtMessage as message',  'intUserId as userId', 'is_read as read' )
				->where('intUserId', $userid)
				->where('is_active', '1')
				->where('is_read', '0')
				->where('is_delete', '0')
				->orderBy('created_at','desc');				
			
			$notifications = $notificationquery->get();
			$notificationCount = $notifications->count();
			
			if(!empty($notifications)) {			
				
				$response = [
					'status' => true,
					'statusCode' => 200,
					'data'  => $notificationCount,
					'errormessage' => [],
					'message' => ''
				];
				
		   }else{
			   
				$response = [
					'status' => true,
					'statusCode' => 200,
					'data'  => [],
					'errormessage' => [],
					'message' => 'Notifications not exists.'
				];
			} 
		} 
			
		return response()->json($response);		
	} 
	*/	
}
