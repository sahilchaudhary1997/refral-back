<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\roles;
use App\color;
use App\category;
use App\Http\Requests\Admin\AddAdminAdvisoryNotificationRequest;
use App\Http\Requests\Admin\UpdateAdminAdvisoryNotificationRequest;
use App\Http\Requests\Admin\ListAdminAdvisoryNotificationRequest;

use Config;
use App\Models\Courses;
use App\Models\AdvisoryNotification;
use App\Models\ModuleType;
use App\Models\Level;
use App\Models\Markets;
use App\Models\DeviceToken;

use App\Models\AdvisoryNotificationReports;
use Excel;
// use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdvisoryNotificationexport;

class AdvisoryNotificationController extends SystemAdminController {

    var $breadcum = ['icon' => 'mdi mdi-account-multiple', 'breadcum' => ['Manage Advisory Notifications']];

    public function __construct() {
        parent::__construct(); 
    }

    public function index(Request $request) {
        $filter = $request->all();
        $breadcum = $this->breadcum;
        $users = AdvisoryNotification::where(function($q)use($filter) {
            if (!empty($filter['search'])) {
                $q->where('script', 'LIKE', '%' . $filter['search'] . '%');
            }
            if (!empty($filter['marketslist'])) {
                $q->where('marketId', $filter['marketslist']);
            }
            if (!empty($filter['advisorycourse'])) {
                $q->where('courseId', $filter['advisorycourse']);
            }

            if (!empty($filter['fromdatelist']) && !empty($filter['todatelist']) ) {
                $from = date('Y-m-d',strtotime($filter['fromdatelist']));
                $to = date('Y-m-d',strtotime($filter['todatelist']));
                $q->whereBetween('tradeDate', [$from, $to]);
            }            
        })
        ->where('userId',NULL)
        ->where('parentId',NULL)
        ->orderBy('id', 'asc')->paginate(Config::get('constants.pageRecords'));
        $markets = Markets::where('is_active', '1')->where('is_delete', '0')->get();
        return view('admin.manage_advisorynotification.list', compact('breadcum', 'users', 'filter','markets'));
    }

    public function create() {
        $breadcum = $this->breadcum;
		$moduletypes = ModuleType::where('is_active', '1')->where('is_delete', '0')->get();
		$leveltypes = Level::where('is_active', '1')->where('is_delete', '0')->get();
		$markets = Markets::where('is_active', '1')->where('is_delete', '0')->get();
        $categorydata = category::where('is_active', '1')->where('is_delete', '0')->get();
        // $categorydata = category::getList();
        return view('admin.manage_advisorynotification.create', compact('breadcum', 'categorydata', 'moduletypes', 'leveltypes','markets'));
    }

    public function store(AddAdminAdvisoryNotificationRequest $request) {
        
        $all = $request->all();
       
		$inserarr = array();
        // $inserarr['userId'] = $request->userId;
        // $inserarr['parentId'] = $request->parentId;
        $inserarr['moduleId'] = $request->moduletype;
        $inserarr['marketId'] = $request->markets;
        $inserarr['courseId'] = $request->advisorycourse;       
        $inserarr['advisorySection'] = $request->section;
        $inserarr['script'] = $request->script;
        $inserarr['expiryDate'] =  date('Y-m-d',strtotime($request->expirydate));
        // $inserarr['tradeDate'] = $request->tradeDate;       
        $inserarr['action_trade'] = $request->tradeaction;
        $inserarr['quantity'] = $request->quantity;
        $inserarr['price'] = $request->price;
        // $inserarr['value'] = $request->value;
        $inserarr['stoploss'] = $request->stoploss;
        $inserarr['target'] = $request->target;
        $inserarr['timeline'] = $request->timeline;
        $inserarr['description'] = $request->description;
        $inserarr['is_active'] = 1;
        $inserarr['is_delete'] = 0;
        // print_r($inserarr);
        $advnoti = new AdvisoryNotification();
        $advnotificationarr = $advnoti->getAdvisorySubscribeUsers($request->moduletype,$request->advisorycourse);
        if(!empty($advnotificationarr)){
            $devicetokensarr = array();
            foreach($advnotificationarr as $userkey => $userval){

                $userdevicestokens = DeviceToken::select('deviceToken')->where('userid',$userval['id'])->where('deviceToken','!=' ,'')->get();
                $insertuserarr = array();
                foreach($userdevicestokens as $usertokenkey => $usertokenval){
                    $devicetokensarr[] = $usertokenval['deviceToken'];
                }
                $insertuserarr = $inserarr;
                $insertuserarr['userId'] = $userval['id'];
                AdvisoryNotification::create($insertuserarr);
            }

            if(!empty($devicetokensarr)){
                $notificationtitle = $request->section;
                $notificationdescription = $request->description;  
                $dataarr = array();
                $dataarr['title'] = $notificationtitle;
                $dataarr['body'] = $notificationdescription;
                $dataarr['type'] = "AdvisoryNotification";            
                $responsenot = SendFirebaseNotification($notificationtitle,$notificationdescription,$devicetokensarr,$dataarr);
            }
        }
       
        $role = AdvisoryNotification::create($inserarr);
        return redirect()->route('adminAdvisoryNotification')->with('success', 'Advisory Notification send successfully.');
    }

    public function changerequest($id) {
        $user = AdvisoryNotification::find($id); 
             
        $breadcum = $this->breadcum;
        $moduleId = $user->moduleId;
		$moduletypes = ModuleType::where('is_active', '1')->where('is_delete', '0')->get();
		$leveltypes = Level::where('is_active', '1')->where('is_delete', '0')->get();
		$markets = Markets::where('is_active', '1')->where('is_delete', '0')->get();
        // $categorydata = category::where('is_active', '1')->where('is_delete', '0')->get();
        $advisorymarketid = $user->marketId;
        $coursesdata = Courses::select('id','varTitle as title')->where('moduleTypes',$moduleId)->where('market',$advisorymarketid)->get();
        
        // $categorydata = category::getList();
        return view('admin.manage_advisorynotification.update', compact('breadcum', 'moduletypes', 'user', 'markets', 'coursesdata'));
    }

    public function update(UpdateAdminAdvisoryNotificationRequest $request) {
        
        $all = $request->all();
			
        $inserarr = array();
        // $inserarr['userId'] = $request->userId;
        $inserarr['parentId'] = $request->uid;
        $inserarr['moduleId'] = $request->moduletype;
        $inserarr['marketId'] = $request->markets;
        $inserarr['courseId'] = $request->advisorycourse;       
        $inserarr['advisorySection'] = $request->section;
        $inserarr['script'] = $request->script;
        $inserarr['expiryDate'] =  date('Y-m-d',strtotime($request->expirydate));
        // $inserarr['tradeDate'] = $request->tradeDate;       
        $inserarr['action_trade'] = $request->tradeaction;
        $inserarr['quantity'] = $request->quantity;
        $inserarr['price'] = $request->price;
        // $inserarr['value'] = $request->value;
        $inserarr['stoploss'] = $request->stoploss;
        $inserarr['target'] = $request->target;
        $inserarr['timeline'] = $request->timeline;
        $inserarr['description'] = $request->description;
        $inserarr['is_active'] = 1;
        $inserarr['is_delete'] = 0;
        
        $updatearr = array();
        $updatearr['isBuySale'] = '1';
		AdvisoryNotification::where('id',$request->uid)->update($updatearr);

        $advnoti = new AdvisoryNotification();
        $advnotificationarr = $advnoti->getAdvisorySubscribeUsers($request->moduletype,$request->advisorycourse);
        if(!empty($advnotificationarr)){
            $devicetokensarr = array();
            foreach($advnotificationarr as $userkey => $userval){

                $userdevicestokens = DeviceToken::select('deviceToken')->where('userid',$userval['id'])->where('deviceToken','!=' ,'')->get();
                $insertuserarr = array();
                foreach($userdevicestokens as $usertokenkey => $usertokenval){
                    $devicetokensarr[] = $usertokenval['deviceToken'];
                }
                $insertuserarr = $inserarr;
                $insertuserarr['userId'] = $userval['id'];
                AdvisoryNotification::create($insertuserarr);
            }

            if(!empty($devicetokensarr)){
                $notificationtitle = $request->section;
                $notificationdescription = $request->description;  
                $dataarr = array();
                $dataarr['title'] = $notificationtitle;
                $dataarr['body'] = $notificationdescription;
                $dataarr['type'] = "AdvisoryNotification";            
                $responsenot = SendFirebaseNotification($notificationtitle,$notificationdescription,$devicetokensarr,$dataarr);
            }
        }
       
        $role = AdvisoryNotification::create($inserarr);
        return redirect()->route('adminAdvisoryNotification')->with('success', 'Advisory Notification send & updated successfully.');
    }

    public function publish(Request $request) {        
        try {
            $record = AdvisoryNotification::find($request->id);
			
            if (!empty($record)) {
                //if ($record->is_active == 1) {
                    AdvisoryNotification::find($record->id)->update(['status' => $request->changeid]);
                //} else {
                 //   Courses::find($record->id)->update(['is_active' => 1]);
                //}
                return 'success';
            }
            return 'Record not found';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // public function delete($id) {

    //     return redirect()->back()->with('success', 'Admin Courses deleted successfully.');
    // }

    public function advisorycoursesbymarketid(Request $request){
        
        $advisorymarketid = $request->id;
        $moduletype = $request->moduletype;
        $coursesdata = Courses::select('id','varTitle as title')->where('market',$advisorymarketid)->where('moduleTypes',$moduletype)->where('is_active', '1')->where('is_delete', '0')->get();
        
        $html = '';
        $functionenable = 'onChange="getreportsdates(this.value)"';
        if($request->hidefunction == "1"){
            $functionenable = '';
        }
        if(!$coursesdata->isEmpty()){
            $html.= '<select name="advisorycourse" id="advisorycourse" '.$functionenable.' class="form-control blackcolor" >';
            $html.= '<option value="">Please select course</option>';
            foreach($coursesdata as $coursekey => $courseval){
                $html.= '<option value="'.$courseval['id'].'">'.$courseval['title'].'</option>';
            }
            $html.= '</select>';
        }

        echo $html;
        exit;
    }
    
    public function advisorycoursesreportgenerate(ListAdminAdvisoryNotificationRequest $request){
                
        $from = date('Y-m-d',strtotime($request->fromdate));
        $to = date('Y-m-d',strtotime($request->todate));
        
        $advtisecount = AdvisoryNotification::select('id','advisorySection','tradeDate','script','action_trade','quantity','price','stoploss','status','target','timeline')->where('userId', NULL)->where('parentId', NULL)->where('courseId', $request->advisorycourse)->where('marketId', $request->markets)->whereBetween('tradeDate', [$from, $to])->count();  

        // Excel::store(new AdvisoryNotificationexport('','',8,11),  'usersReport.xlsx');
        // Excel::store(new AdvisoryNotificationexport('','',8,11),  'reports/REPORT-FORMAT-FOR-MOBILE-APP.xls', 'public_uploads');
        if($advtisecount>0){
            $cousenamear = Courses::select('id','varTitle as title')->where('id',$request->advisorycourse)->first();
            $couseNamewithoutspace = preg_replace("/[^a-zA-Z]+/", "_", $cousenamear->title);
            
            $reportfilename = $couseNamewithoutspace."_".$from."_TO_".$to."_".$request->markets.'.xls';
           
            if($request->reporttype=="2"){                
                return Excel::download(new AdvisoryNotificationexport($request->fromdate,$request->todate,$request->advisorycourse,$request->markets), $reportfilename);
            }else{
                $advtisreportarr = array();
                $advtisreportarr['moduleId'] = '2';
                $advtisreportarr['marketId'] = $request->markets;
                $advtisreportarr['courseId'] = $request->advisorycourse;
                $advtisreportarr['fromDate'] = $from;
                $advtisreportarr['toDate'] = $to;
                $advtisreportarr['reportName'] = $reportfilename;

                AdvisoryNotificationReports::create($advtisreportarr);
                Excel::store(new AdvisoryNotificationexport($request->fromdate,$request->todate,$request->advisorycourse,$request->markets),  'reports/'.$reportfilename, 'public_uploads');
                return redirect()->route('adminAdvisoryNotification')->with('success', 'Advisory Notification report generate successfully.');
            }

            
        }else{
            return redirect()->route('adminAdvisoryNotification')->with('success', 'Advisory Notification report record not found.');
        }
        
        
     
    }

    public function getadvisoryreportdate(Request $request){
        
        $response = [
            'fromdate' => '',
            'todate' => ''
        ];	
        $courseid = $request->courseid;
        $moduleid = $request->moduletype;
        $marketid = $request->markets;
        $advisoryReportDates = AdvisoryNotificationReports::select('fromDate','toDate')->where('marketId',$marketid)->where('courseId',$courseid)->where('moduleId',$moduleid)->first();
        if(!empty($advisoryReportDates)){
            $response['fromdate'] = $advisoryReportDates['fromDate'];
            $response['todate'] = $advisoryReportDates['toDate'];
        }
        
        return response()->json($response);		
        
      //  $coursesdata = Courses::select('id','varTitle as title')->where('market',$advisorymarketid)->where('moduleTypes',$moduletype)->get();
        
        
    }
}
