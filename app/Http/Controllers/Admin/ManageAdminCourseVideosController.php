<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\roles;
use App\color;
use App\category;
use App\Http\Requests\Admin\AddAdminCourseVideosRequest;
use App\Http\Requests\Admin\UpdateAdminCourseVideosRequest;
use Config;
use App\Models\DashboardNotification;
use App\Models\ModuleType;
use App\Models\Level;
use App\Models\Markets;
use App\Models\CoursesVideos;
use App\Models\Courses;

class ManageAdminCourseVideosController extends SystemAdminController {

    var $breadcum = ['icon' => 'mdi mdi-account-multiple', 'breadcum' => ['Manage Course Videos']];

    public function __construct() {        
		
		parent::__construct();
    }

    public function index(Request $request) {
        $filter = $request->all();
       
        $breadcum = $this->breadcum;

        $Coursefirstdata = Courses::where('is_active','1')->where('is_delete','0')->first();
        $coursefirstid = $Coursefirstdata->id;

        $users = CoursesVideos::where(function($q)use($filter) {
			if (!empty($filter['search'])) {
				$q->where('title', 'LIKE', '%' . $filter['search'] . '%');
			}
            if (!empty($filter['course'])) {
                $q->where('courseid', $filter['course'] );
            }else{
                $Coursefirstdata = Courses::where('is_active','1')->where('is_delete','0')->first();
                $coursefirstid = $Coursefirstdata->id;
                $q->where('courseid', $coursefirstid );
            }
		})
            ->orderBy('id', 'asc')->paginate(Config::get('constants.pageRecords'));
        $Coursesdata = Courses::getAllCourseList();
            
        return view('admin.manage_coursevideos.list', compact('breadcum', 'users', 'filter','Coursesdata','coursefirstid'));
    }

    public function create() {
        $breadcum = $this->breadcum;
		$Coursesdata = Courses::getAllCourseList();
        return view('admin.manage_coursevideos.create', compact('breadcum','Coursesdata'));
    }

    public function store(AddAdminCourseVideosRequest $request) {
        $all = $request->all();
		
        $coursevideos = CoursesVideos::where('courseid',$request->course)->count();
        $videocount = $coursevideos + 1;       
		$inserarr = array();
		$inserarr['courseid'] = $request->course;
		$inserarr['title'] = $request->title;
        $inserarr['videotype'] = $request->videotype;
        $inserarr['description'] = $request->description;
        $inserarr['videoorder'] = $videocount;
        // $inserarr['videoname'] = $request->coursevideo;
     	if ( $request->hasFile('coursevideo')){
			if ($request->file('coursevideo')->isValid()){
				$FileFullName = $request->file('coursevideo')->getClientOriginalName();
				$extension = $request->file('coursevideo')->extension();
				$FileName = str_replace(".".$extension,"",$FileFullName);
				$FileInsertname = time().'.'.$request->file('coursevideo')->getClientOriginalName();
				$request->file('coursevideo')->move('uploads' , $FileInsertname);
				$inserarr['videoname'] = $FileInsertname;
				// $inserarr['coursePhoto'] = $FileInsertname;				
			}
		}		
        $inserarr['is_active'] = 1;
        $inserarr['is_delete'] = 0;
        $videosres = CoursesVideos::create($inserarr);
        return redirect()->route('adminCourseVideos')->with('success', 'New course video added successfully.');
    }

    public function edit($id) {
        $user = CoursesVideos::find($id);		
        $breadcum = $this->breadcum;
        $Coursesdata = Courses::getAllCourseList();
        // $categorydata = category::getList();
        return view('admin.manage_coursevideos.update', compact('breadcum', 'user','Coursesdata'));
    }

    public function update(UpdateAdminCourseVideosRequest $request) {
        $all = $request->all();
		
        //echo "<pre>";
        //print_r($all);
        //exit;
        if( ($request->hidvideo != "") || ($request->hasFile('coursevideo') )){
           
            $updatearr = array();
            $updatearr['courseid'] = $request->course;
            $updatearr['title'] = $request->title;
            $updatearr['videotype'] = $request->videotype;
            $updatearr['description'] = $request->description;
            // $updatearr['videoorder'] = $videocount;
            // $updatearr['videoname'] = $request->coursevideo;
            if ( $request->hasFile('coursevideo')){
                if ($request->file('coursevideo')->isValid()){
                    $FileFullName = $request->file('coursevideo')->getClientOriginalName();
                    $extension = $request->file('coursevideo')->extension();
                    $FileName = str_replace(".".$extension,"",$FileFullName);
                    $FileInsertname = time().'.'.$request->file('coursevideo')->getClientOriginalName();
                    $request->file('coursevideo')->move('uploads' , $FileInsertname);
                    $updatearr['videoname'] = $FileInsertname;
                }
            }		
            $updatearr['is_active'] = 1;
            $updatearr['is_delete'] = 0;

            CoursesVideos::where('id',$request->uid)->update($updatearr);
            // CoursesVideos::find($all['uid'])->update($all);
            return redirect()->route('adminCourseVideos')->with('success', 'Course video updated successfully.');
        }else{
            return redirect()->back()->with('error','A course video is required.');
        }
    }

    public function publish(Request $request) {
        try {
            $record = CoursesVideos::find($request->id);
			// echo $record->is_active;exit;
            if (!empty($record)) {
                if ($record->is_active == 1) {
                    CoursesVideos::find($record->id)->update(['is_active' => 0]);
                } else {
                    CoursesVideos::find($record->id)->update(['is_active' => 1]);
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
        CoursesVideos::destroy($id);
        return redirect()->back()->with('success', 'Course video deleted successfully.');
    }

}
