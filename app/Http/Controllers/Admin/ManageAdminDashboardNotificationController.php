<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\roles;
use App\color;
use App\category;
use App\Http\Requests\Admin\AddAdminDashboardNotificationRequest;
use App\Http\Requests\Admin\UpdateAdminDashboardNotificationRequest;
use Config;
use App\Models\DashboardNotification;
use App\Models\ModuleType;
use App\Models\Level;
use App\Models\Markets;

class ManageAdminDashboardNotificationController extends SystemAdminController {

    var $breadcum = ['icon' => 'mdi mdi-account-multiple', 'breadcum' => ['Manage Dashboard Notification']];

    public function __construct() {
        parent::__construct(); 
    }

    public function index(Request $request) {
        $filter = $request->all();
        $breadcum = $this->breadcum;
        $users = DashboardNotification::where(function($q)use($filter) {
                if (!empty($filter['search'])) {
                    $q->where('name', 'LIKE', '%' . $filter['search'] . '%');
                }
            })
            ->orderBy('id', 'asc')->paginate(Config::get('constants.pageRecords'));
        return view('admin.manage_dashboardnotification.list', compact('breadcum', 'users', 'filter'));
    }

    public function create() {
        $breadcum = $this->breadcum;
		// $categorydata = category::getList();
        return view('admin.manage_dashboardnotification.create', compact('breadcum'));
    }

    public function store(AddAdminDashboardNotificationRequest $request) {
        $all = $request->all();
		
		$inserarr = array();
		$inserarr['title'] = $request->title;
		$inserarr['notifytype'] = $request->notifytype;
	
		$inserarr['description'] = $request->description;
		if ( $request->hasFile('notifyvideo')){
			if ($request->file('notifyvideo')->isValid()){
				$FileFullName = $request->file('notifyvideo')->getClientOriginalName();
				$extension = $request->file('notifyvideo')->extension();
				$FileName = str_replace(".".$extension,"",$FileFullName);
				$FileInsertname = time().'.'.$request->file('notifyvideo')->getClientOriginalName();
				$request->file('notifyvideo')->move('uploads' , $FileInsertname);
				$inserarr['notifyvideo'] = $FileInsertname;
				// $inserarr['coursePhoto'] = $FileInsertname;				
			}
		}		
        $inserarr['is_active'] = 1;
        $inserarr['is_delete'] = 0;
        $role = DashboardNotification::create($inserarr);
        return redirect()->route('adminDashboardNotification')->with('success', 'New admin Dashboard Notification added successfully.');
    }

    public function edit($id) {
        $user = DashboardNotification::find($id);
		
        $breadcum = $this->breadcum;
		
        // $categorydata = category::getList();
        return view('admin.manage_dashboardnotification.update', compact('breadcum', 'user'));
    }

    public function update(UpdateAdminDashboardNotificationRequest $request) {
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
		DashboardNotification::where('id',$request->uid)->update($updatearr);

        // DashboardNotification::find($all['uid'])->update($all);
        return redirect()->route('adminDashboardNotification')->with('success', 'Dashboard Notification updated successfully.');
    }

    public function publish(Request $request) {
        try {
            $record = DashboardNotification::find($request->id);
			// echo $record->is_active;exit;
            if (!empty($record)) {
                if ($record->is_active == 1) {
                    DashboardNotification::find($record->id)->update(['is_active' => 0]);
                } else {
                    DashboardNotification::find($record->id)->update(['is_active' => 1]);
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
        DashboardNotification::destroy($id);
        return redirect()->back()->with('success', 'Admin Dashboard Notification deleted successfully.');
    }

}
