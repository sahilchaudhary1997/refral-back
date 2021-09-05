<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
// use App\Models\Language;
// use App\Models\Markets;
// use App\Models\Courses;
use App\Models\Notifications;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use DB;
class NotificationsController extends Controller
{
    public function getNotificationList(Request $request)
    {
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];		
		
		/*
        $rules = [
            'userId' => 'required',            
        ];
        
        $messages = [
            'userId.required' => 'User Id Required.',            
        ];
		
		$validator = Validator::make($request->all(), $rules, $messages);
		
		if(!$validator->fails()) {
		    
			if(isset($request->userId) && is_numeric($request->userId)){
				$userid = $request->userId;
			}*/
			
			$user = Auth::user();
			
			if(!empty($user)){
				
				$userid = $user->id;
				
				$notificationquery = Notifications::select('id','txtMessage as message',  'intUserId as userId', 'is_read as read','created_at' )
					->where('intUserId', $userid)
					->where('is_active', '1')
					->where('is_delete', '0')
					->orderBy('created_at','desc');
					
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
						'message' => 'Notifications not exists.'
					];
			    } 
			}
		    
		/*}else{
			$response = [
                'status' => false,
                'statusCode' => 200,
                'data'  => [],
				'errormessage' => $validator->messages(),
                'message' => 'Invalid data',
            ];
		}*/
		
		return response()->json($response);		
	}	
	
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
}
