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
			$userid = $user->id;
			$adminid = 1;
			$data['to'] = $userid;
			$data['from'] = $adminid;
			
			$messages = UserChat::where(function($query) use($data) {
				$query->where('to', $data['to'] )->where('from', $data['from']);
			})->orWhere(function($query1) use($data){
				$query1->where('from', $data['to'] )->where('to', $data['from']);
			})->orderBy('id', 'DESC')->get();
			
			
			$messagearr = array();
			foreach($messages as $messagekey => $messageval){				
				$messagearr[$messagekey]['_id'] = $messageval['id'];
				$messagearr[$messagekey]['text'] = $messageval['message'];
				$messagearr[$messagekey]['createdAt'] = $messageval['created_at'];
				$messagearr[$messagekey]['user']['_id'] = $messageval['from'];
				$messagearr[$messagekey]['user']['name'] = 'Market Mantra';
				$messagearr[$messagekey]['user']['avatar'] = '';	
				// $messagearr[$messagekey]['user']['avatar'] = 'https://picsum.photos/200/300';						
			}
			
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
				
				$userchats = UserChat::where('from', $user->id)->orderBy('created_at', 'desc')->first();
				//if(!empty($userchats)){
				//	$adminid = $userchats['to'];
				//}else{
					$adminid = 1;
				//}
				
				$insertmsg = array(
					'to' => $adminid,
					'from' => $user->id,
					'message' => $request->text,					
					'emailSent' => '0',
					'readMsg' => '0'
				);
				$userchatsres = UserChat::create($insertmsg);
				// get message list
				$data = $request->all();
    			$userid = $user->id;
    			$adminid = 1;
    			$data['to'] = $userid;
    			$data['from'] = $adminid;
    			
    			$messages = UserChat::where(function($query) use($data) {
    				$query->where('to', $data['to'] )->where('from', $data['from']);
    			})->orWhere(function($query1) use($data){
    				$query1->where('from', $data['to'] )->where('to', $data['from']);
    			})->orderBy('id', 'DESC')->get();
    			
    			
    			$messagearr = array();
    			foreach($messages as $messagekey => $messageval){				
    				$messagearr[$messagekey]['_id'] = $messageval['id'];
    				$messagearr[$messagekey]['text'] = $messageval['message'];
    				$messagearr[$messagekey]['createdAt'] = $messageval['created_at'];
    				$messagearr[$messagekey]['user']['_id'] = $messageval['from'];
    				$messagearr[$messagekey]['user']['name'] = 'Market Mantra';
    				$messagearr[$messagekey]['user']['avatar'] = '';				
    			}
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
}
