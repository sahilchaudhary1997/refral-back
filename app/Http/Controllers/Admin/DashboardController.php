<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;
use App\Models\UserChat;
use admins;
use App\Models\DeviceToken;

class DashboardController extends SystemAdminController
{
    var $breadcum = ['icon'=>'mdi mdi-home','breadcum'=>['Dashboard']];
    
    public function __construct()
    {
        parent::__construct();
		// From - senderId
		// To - receiverId
    }
    
    public function index()
    {
        $breadcum = $this->breadcum;		
		
        return view('admin.dashboard.dashboard',compact('breadcum'));
    }
	
	public function FetchMobileUsers(){
		
		$userdetails = DB::table('users')
		->select('users.id','users.email','users.name','users_chats.message','users_chats.created_at')
        ->join('users_chats', function ($join) {
           $join->on('users.id', '=', 'users_chats.senderId')->where('users_chats.is_admin', '=', 0);
			// ->orOn('users.id', '=', 'users_chats.from')->where('users_chats.is_admin', '=', 0);
        })
		//->join('users_chats', function ($join) {
       //     $join->on('users.id', '=', 'users_chats.from')->where('users_chats.is_admin', '=', 0);
      //  })
		->orderby('users_chats.id','desc')
		->groupby('users.id')
        ->get();
		$html ='';
		if(!empty($userdetails)){
			$html .='<div class="table-horizontal-scroll">		
				<table class="table table-bordered">
					<thead>
						<tr>
							<th> Name </th>
							<th> Date & Time </th>
							<th> Action </th>
						</tr>
					</thead>
					<tbody>';
						foreach($userdetails as $user){
						$html .='<tr>

							<td>'.$user->name.'</td>
							<td>'.$user->created_at.'</td>
							<td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$user->id.'" data-tousername="'.$user->name.'">Start Chat</button>
							</td>
						</tr>';
						}
					$html .='</tbody>
				</table>
			</div>';
		}
		
		echo $html;
		exit;
		// $userdetails = User::select('id','email','name')->where('isVerified','=','1')->get();
		/*
		echo "<pre>";
		print_r($userdetails);
		exit;
		*/
	}
	
	public function InsertChatUsers(Request $request){
		$loginuserid = Auth::guard('admin')->user()->id;
		// $data = $request->all();
		// print_r($data);
		// exit;
		if(!empty($request->chat_message) && $request->chat_message!=""){
    		$insertmsg = array(
    			'receiverId' => $request->to_user_id,
    			'senderId' => $loginuserid,
    			'message' => $request->chat_message,					
    			'emailSent' => '0',
    			'readMsg' => '0',
    			'is_admin' => '1'
    		);		
    		$userchatsres = UserChat::create($insertmsg);
    		// chat notification begin
    		$devicetokensarr = array();
    		$userdevicestokens = DeviceToken::select('deviceToken')->where('userid',$request->to_user_id)->where('deviceToken','!=' ,'')->get();
                   
    		foreach($userdevicestokens as $usertokenkey => $usertokenval){
    			$devicetokensarr[] = $usertokenval['deviceToken'];
    		}
    		
    		$dataarr = array();
    		$dataarr['title'] = "Message form Admin";
    		$dataarr['body'] = $request->chat_message;
    		$dataarr['type'] = "Message";
    		if(!empty($devicetokensarr)){			
    			$responsenot = SendFirebaseNotification($dataarr['title'],$dataarr['body'],$devicetokensarr,$dataarr);
    		}
		    // chat notiticatin end
		}
		echo $this->fetchUserChatHistory($loginuserid,$request->to_user_id);
		exit;
	}
	
	public function fetchUserChatHistory($loginAdminId,$ChatUserId){
		
		$data = array();
		$data['loginAdminId'] = $loginAdminId;
		$data['ChatUserId'] = $ChatUserId;
		
		$chatHistory = UserChat::select('users_chats.id', 'users_chats.senderId','users_chats.receiverId','users_chats.message','users_chats.created_at','users_chats.is_admin')
		->where(function($q) use($data) {
			  $q->where('users_chats.senderId', $data['loginAdminId'])->where('users_chats.receiverId', $data['ChatUserId']);
		})
		->orwhere(function($q1) use($data){
			$q1->where('users_chats.senderId', $data['ChatUserId'] )->where('users_chats.receiverId', $data['loginAdminId']);
		})
		->orderBy('id', 'DESC')
		->get();
				
		$output = '<ul class="list-unstyled">';
		foreach($chatHistory as $row)
		{			
			$user_name = '';
			if($row->senderId == $loginAdminId && $row->is_admin == 1)
			{
				$user_name = '<b class="text-success">You</b>';
			}
			else
			{	
				$user_name = '<b class="text-danger">'.$this->get_user_name($row).'</b>';
			}
			
			$output .= '
			<li style="border-bottom:1px dotted #ccc">
			<p>'.$user_name.' - '.$row->message.'
			<div align="right">
			- <small><em>'.$row->created_at.'</em></small>
			</div>
			</p>
			</li>';
		}
		
		$output .= '</ul>';
		
		return $output;		
	}
	
	public function get_user_name($records){
		
		$UserName = '';
		if($records->is_admin==1){
			$adminNamedetail = admins::select('name')->where('id',$records->senderId)->first();
			$UserName = $adminNamedetail->name;
		}
		
		if($records->is_admin==0){
			$adminNamedetail = User::select('name')->where('id',$records->senderId)->first();
			$UserName = $adminNamedetail->name;
		}
		
		return $UserName;
	}
	
	public function fetchUserChatHistoryData(Request $request){
		
		$loginuserid = Auth::guard('admin')->user()->id;		
		$chatresponse = $this->fetchUserChatHistory($loginuserid,$request->to_user_id);
		echo $chatresponse;
		exit;
	}
}
