<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\roles;
use App\color;
use App\category;
use App\Http\Requests\Admin\AddAdminNotificationsRequest;
use App\Http\Requests\Admin\UpdateAdminNotificationsRequest;
use Config;
use App\Models\DashboardNotification;
use App\Models\ModuleType;
use App\Models\Level;
use App\Models\Markets;
use App\Models\Notifications;
use App\User;
use App\Models\DeviceToken;

class ManageAdminNotificationsController extends SystemAdminController {

    var $breadcum = ['icon' => 'mdi mdi-account-multiple', 'breadcum' => ['Manage Notifications']];

    public function __construct() {
        parent::__construct(); 
    }

    public function index(Request $request) {
        $filter = $request->all();
        $breadcum = $this->breadcum;
        $users = Notifications::where(function($q)use($filter) {
                if (!empty($filter['search'])) {
                    $q->where('name', 'LIKE', '%' . $filter['search'] . '%');
                }
            })
            ->orderBy('id', 'asc')->paginate(Config::get('constants.pageRecords'));
        return view('admin.manage_notifications.list', compact('breadcum', 'users', 'filter'));
    }

    public function create() {
        $breadcum = $this->breadcum;
		// $categorydata = category::getList();
        return view('admin.manage_notifications.create', compact('breadcum'));
    }

    public function store(AddAdminNotificationsRequest $request) {
        $all = $request->all();
		
		$inserarr = array();
        $notifytype = $request->notifytype;
        if($notifytype=='P'){

            $currentdate = date('Y-m-d H:i:s');
            $usersres = User::select('users.id', 'users.name','payments_history.id as paymentId')
            // ->join('module_types', 'module_types.id', '=', 'courses.moduleTypes')
             ->join('payments_history', 'payments_history.userid', '=', 'users.id')
             ->join('users_devicetoken', 'users_devicetoken.userid', '=', 'users.id')
            // ->join('markets', 'markets.id', '=', 'courses.market')
            // ->leftjoin("categories",DB::raw("FIND_IN_SET(categories.id,courses.categories)"),">",DB::raw("'0'"))           
            ->groupBy("users.id")
            // ->where('courses.is_active', '1')
            // ->where('courses.is_delete', '0')
            ->where('payments_history.package_enddate', '>=', $currentdate)
            ->where('users.isVerified', '1')
            
            ->get();
        }
        if($notifytype=='A'){
            $usersres = User::select('users.id', 'users.name', 'users.id' )
            ->join('users_devicetoken', 'users_devicetoken.userid', '=', 'users.id')
            ->where('users.isVerified', '1')		
            ->groupBy("users.id")
            ->get();
        }

        $devicetokensarr = array();

        if(!empty($usersres)){
            foreach($usersres as $userkey => $userval){
                
                $userdevicestokens = DeviceToken::select('deviceToken')->where('userid',$userval->id)->where('deviceToken','!=' ,'')->get();
               
                foreach($userdevicestokens as $usertokenkey => $usertokenval){
                    $devicetokensarr[] = $usertokenval['deviceToken'];
                }
                
                $inserarr['title'] = $request->title;            
                $inserarr['txtMessage'] = $request->description;
                $inserarr['intUserId'] = $userval->id;
                $inserarr['is_read'] = 0;
                $inserarr['is_active'] = 1;
                $inserarr['is_delete'] = 0;

                $insertnot = Notifications::create($inserarr);
            }          

            $notificationtitle = $request->title;
            $notificationdescription = $request->description;  
            $dataarr = array();
            $dataarr['title'] = $notificationtitle;
            $dataarr['body'] = $notificationdescription;
                        
            $responsenot = SendFirebaseNotification($notificationtitle,$notificationdescription,$devicetokensarr,$dataarr);
            
        }

        return redirect()->route('adminNotificationsCreate')->with('success', 'Notifications send successfully.');
    }

    public function edit($id) {
        $user = Notifications::find($id);
		
        $breadcum = $this->breadcum;
		
        // $categorydata = category::getList();
        return view('admin.manage_notifications.update', compact('breadcum', 'user'));
    }

    public function update(UpdateAdminNotificationsRequest $request) {
        $all = $request->all();
		
		$updatearr = array();
		$updatearr['title'] = $request->title;
		$updatearr['notifytype'] = $request->notifytype;
	
		$updatearr['description'] = $request->description;
		if ( $request->hasFile('notifyvideo')){
			if ($request->file('notifyvideo')->isValid()){
				$FileFullName = $request->file('notifyvideo')->getClientOriginalName();
				$extension = $request->file('notifyvideo')->extension();
				$FileName = str_replace(".".$extension,"",$FileFullName);
				$FileInsertname = time().'.'.$request->file('notifyvideo')->getClientOriginalName();
				$request->file('notifyvideo')->move('uploads' , $FileInsertname);
				$updatearr['notifyvideo'] = $FileInsertname;
			}
		}		
			
        $updatearr['is_active'] = 1;
        $updatearr['is_delete'] = 0;
		Notifications::where('id',$request->uid)->update($updatearr);

        // DashboardNotification::find($all['uid'])->update($all);
        return redirect()->route('adminNotifications')->with('success', 'Notifications updated successfully.');
    }

    public function publish(Request $request) {
        try {
            $record = Notifications::find($request->id);
			// echo $record->is_active;exit;
            if (!empty($record)) {
                if ($record->is_active == 1) {
                    Notifications::find($record->id)->update(['is_active' => 0]);
                } else {
                    Notifications::find($record->id)->update(['is_active' => 1]);
                }
                return 'success';
            }
            return 'Record not found';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id) {
//        if($id == 1 || $id == 2){
//            return redirect()->back()->with('error','You can not delete admin location city');
//        }
        Notifications::destroy($id);
        return redirect()->back()->with('success', 'Notification deleted successfully.');
    }

}
