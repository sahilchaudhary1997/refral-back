<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserChat;
// use App\Models\Reviews;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use admins;
// use App\User;


class UsersChatController extends Controller
{
	
    public function getMessageList(Request $request)
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
			
			$data = $request->all();
			
			$messagearr = $this->get_user_message();
			
			/*
			$userid = $user->id;			
			$adminid = 1;
			
			// $data['to'] = $userid;
			// $data['from'] = $adminid;
			// From - senderId
			// To - receiverId
			
			$data['loginAdminId'] = $adminid;
			$data['ChatUserId'] = $userid;
		
			$chatHistory = UserChat::select('users_chats.id', 'users_chats.senderId','users_chats.receiverId','users_chats.message','users_chats.created_at','users_chats.is_admin')
			->where(function($q) use($data) {
				  $q->where('users_chats.senderId', $data['loginAdminId'])->orWhere('users_chats.receiverId', $data['ChatUserId']);
			})
			->orwhere(function($q1) use($data){
				$q1->where('users_chats.senderId', $data['ChatUserId'] )->where('users_chats.receiverId', $data['loginAdminId']);
			})
			->orderBy('id', 'DESC')
			->get();
			
			foreach($chatHistory as $messagekey => $row)
			{			
				$user_name = '';
				if($row->senderId == $adminid && $row->is_admin == 1)
				{
					$user_namearr = $this->get_user_name($row);
					$user_name = $user_namearr['name'];
					$avatarimg = $user_namearr['avatarimg'];
					//$user_name = 'Admin '; 
					// $user_name = '<b class="text-success">You</b>';
				}
				else
				{	
					$user_namearr = $this->get_user_name($row);
					$user_name = $user_namearr['name'];
					$avatarimg = $user_namearr['avatarimg'];
					// $user_name = 'You';
				}
				
				$messagearr[$messagekey]['_id'] = $row['id'];
				$messagearr[$messagekey]['text'] = $row['message'];
				$messagearr[$messagekey]['createdAt'] = $row['created_at'];
				$messagearr[$messagekey]['user']['_id'] = $row['senderId'];
				$messagearr[$messagekey]['user']['name'] = $user_name;
				$messagearr[$messagekey]['user']['avatar'] = $avatarimg;				
			}
			*/
			
			$response = [
				'status' => true,
				'statusCode' => 200,
				'data'  => $messagearr,
				'errormessage' => [],
				'message' => 'Success'
			];
			
		}else{
			$response = [
				'status' => true,
				'statusCode' => 200,
				'data'  => [],
				'errormessage' => [],
				'message' => 'User details not exists.'
			];
		}		
		
		return response()->json($response);		
	}
	
	
	public function sendMessage(Request $request)
    {		
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'text' => ''
        ];
		
		$rules = [                         
            'text' => 'required',            
        ];
		
		$messages = [
           'text.required' => 'Message required.',            
        ];
		
		$validator = Validator::make($request->all(), $rules, $messages);
		
		if(!$validator->fails()) {
			
			$user = Auth::user();			
			if(!empty($user)){
				
				// $userchats = UserChat::where('senderId', $user->id)->orderBy('created_at', 'desc')->first();
				// if(!empty($userchats)){
				//	$adminid = $userchats['to'];
				// }else{
					$adminid = 1;
				// }
				
				$insertmsg = array(
					'receiverId' => $adminid,
					'senderId' => $user->id,
					'message' => $request->text,					
					'emailSent' => '0',
					'readMsg' => '0'
				);
				$userchatsres = UserChat::create($insertmsg);
				// get message list
				$messagearr = $this->get_user_message();
				/*
				$data = $request->all();
    			$userid = $user->id;
    			$adminid = 1;
    			$data['to'] = $userid;
    			$data['from'] = $adminid;
    			
    			$messages = UserChat::where(function($query) use($data) {
    				$query->where('receiverId', $data['to'] )->where('senderId', $data['from']);
    			})->orWhere(function($query1) use($data){
    				$query1->where('senderId', $data['to'] )->where('receiverId', $data['from']);
    			})->orderBy('id', 'DESC')->get();
    			
    			
    			$messagearr = array();
    			foreach($messages as $messagekey => $messageval){				
    				$messagearr[$messagekey]['_id'] = $messageval['id'];
    				$messagearr[$messagekey]['text'] = $messageval['message'];
    				$messagearr[$messagekey]['createdAt'] = $messageval['created_at'];
    				$messagearr[$messagekey]['user']['_id'] = $messageval['senderId'];
    				$messagearr[$messagekey]['user']['name'] = 'Market Mantra';
    				$messagearr[$messagekey]['user']['avatar'] = '';				
    			}
				*/
				$response = [
					'status' => true,
					'statusCode' => 200,
					'data'  => $messagearr,
					'errormessage' => [],
					'message' => 'Your message successfully submitted.'
				];							
			}else {
				$response = [
					'status' => true,
					'statusCode' => 200,
					'data'  => [],
					'errormessage' => [],
					'message' => 'User details not exists.'
				];
			}
				
		}else{
			$response = [
                'status' => false,
                'statusCode' => 200,
                'data'  => [],
				'errormessage' => $validator->messages(),
                'message' => 'Invalid data',
            ];
		}
		
		return response()->json($response);		
	}
	
	public function get_user_name($records){
		
		$usersdetails = array();
		if($records->is_admin==1){
			$usersdetails['avatarimg'] = '';
			$adminNamedetail = DB::table('admins')->select('name', 'image_id')->where('id', $records->senderId)->first();
			// $adminNamedetail = admins::select('name')->where('id',$records->senderId)->first();
			if (!empty($adminNamedetail->image_id) && $adminNamedetail->image_id!=""){
				$usersdetails['avatarimg'] = ResizeImage($adminNamedetail->image_id,100,100);
			}
			$usersdetails['name'] = $adminNamedetail->name;
		}
		
		if($records->is_admin==0){
			$usersdetails['avatarimg'] = '';
			$adminNamedetail = User::select('name','usersPhoto')->where('id',$records->senderId)->first();
			$userFileName = $adminNamedetail->usersPhoto;
			if ($userFileName!="" && file_exists(public_path('uploads/'.$userFileName))){				
				$usersdetails['avatarimg'] = url('uploads/'.$userFileName);
			}
			$usersdetails['name'] = $adminNamedetail->name;
		}
		
		return $usersdetails;
	}
	
	public function get_user_message(){
		
		$user = Auth::user();
		
		$userid = $user->id;			
		$adminid = 1;
		
		// $data['to'] = $userid;
		// $data['from'] = $adminid;
		// From - senderId
		// To - receiverId
		
		$data['loginAdminId'] = $adminid;
		$data['ChatUserId'] = $userid;
	
		$chatHistory = UserChat::select('users_chats.id', 'users_chats.senderId','users_chats.receiverId','users_chats.message','users_chats.created_at','users_chats.is_admin')
		->where(function($q) use($data) {
			  $q->where('users_chats.senderId', $data['loginAdminId'])->where('users_chats.receiverId', $data['ChatUserId']);
		})
		->orwhere(function($q1) use($data){
			$q1->where('users_chats.senderId', $data['ChatUserId'] )->where('users_chats.receiverId', $data['loginAdminId']);
		})
		->orderBy('id', 'DESC')
		->get();
		
		$messagearr = array();
		if(!$chatHistory->isEmpty()){
			foreach($chatHistory as $messagekey => $row)
			{			
				$user_name = '';
				if($row->senderId == $adminid && $row->is_admin == 1)
				{
					$user_namearr = $this->get_user_name($row);
					$user_name = $user_namearr['name'];
					$avatarimg = $user_namearr['avatarimg'];
					//$user_name = 'Admin '; 
					// $user_name = '<b class="text-success">You</b>';
					$staticrandomID = $row['senderId'].'ABC';
				}
				else
				{	
					$user_namearr = $this->get_user_name($row);
					$user_name = $user_namearr['name'];
					$avatarimg = $user_namearr['avatarimg'];
					// $user_name = 'You';
					$staticrandomID = $row['senderId'];
				}
				
				$messagearr[$messagekey]['_id'] = $row['id'];
				$messagearr[$messagekey]['text'] = $row['message'];
				$messagearr[$messagekey]['createdAt'] = $row['created_at'];
			//	$messagearr[$messagekey]['user']['_id'] = $row['senderId'];
				$messagearr[$messagekey]['user']['_id'] = $staticrandomID;
				$messagearr[$messagekey]['user']['name'] = $user_name;
				$messagearr[$messagekey]['user']['avatar'] = $avatarimg;				
			}
		}		
		
		return $messagearr;
	}
}
