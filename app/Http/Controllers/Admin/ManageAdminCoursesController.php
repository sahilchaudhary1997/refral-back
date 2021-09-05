<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\roles;
use App\color;
use App\category;
use App\Http\Requests\Admin\AddAdminCoursesRequest;
use App\Http\Requests\Admin\UpdateAdminCoursesRequest;
use Config;
use App\Models\Courses;
use App\Models\ModuleType;
use App\Models\Level;
use App\Models\Markets;

class ManageAdminCoursesController extends SystemAdminController {

    var $breadcum = ['icon' => 'mdi mdi-account-multiple', 'breadcum' => ['Manage Courses']];

    public function __construct() {
        parent::__construct(); 
    }

    public function index(Request $request) {
        $filter = $request->all();
        $breadcum = $this->breadcum;
		$markets = Markets::where('is_active', '1')->where('is_delete', '0')->get();
        $moduletypes = ModuleType::where('is_active', '1')->where('is_delete', '0')->get();
        $leveltypes = Level::where('is_active', '1')->where('is_delete', '0')->get();
        $users = Courses::where(function($q)use($filter) {
							if (!empty($filter['modulelist'])) {
								$q->where('moduleTypes', $filter['modulelist']);
							}
							if (!empty($filter['levellist'])) {
								$q->where('level',$filter['levellist']);
							}
							if (!empty($filter['marketslist'])) {
								$q->where('market', $filter['marketslist']);
							}
                            if (!empty($filter['search'])) {
                                $q->where('varTitle', 'LIKE', '%' . $filter['search'] . '%');
                            }
                        })
                        ->orderBy('id', 'asc')->paginate(Config::get('constants.pageRecords'));
        return view('admin.manage_courses.list', compact('breadcum', 'users', 'filter','markets','moduletypes','leveltypes'));
    }

    public function create() {
        $breadcum = $this->breadcum;
		$moduletypes = ModuleType::where('is_active', '1')->where('is_delete', '0')->get();
		$leveltypes = Level::where('is_active', '1')->where('is_delete', '0')->get();
		$markets = Markets::where('is_active', '1')->where('is_delete', '0')->get();
        $categorydata = category::where('is_active', '1')->where('is_delete', '0')->get();
        // $categorydata = category::getList();
        return view('admin.manage_courses.create', compact('breadcum', 'categorydata', 'moduletypes', 'leveltypes','markets'));
    }

    public function store(AddAdminCoursesRequest $request) {
        $all = $request->all();
		
		$inserarr = array();
		$inserarr['varTitle'] = $request->title;
		$inserarr['moduleTypes'] = $request->moduletype;
		$inserarr['level'] = $request->leveltype;
		$inserarr['market'] = $request->markets;
		if(!empty($request->category)){
			$inserarr['categories'] = implode(',',$request->category);			
		}
		$inserarr['chrIndiaFees'] = $request->indiafees;
		$inserarr['chrWorldFees'] = $request->worldfees;
		$inserarr['courseDuration'] = $request->courseduration;
		$inserarr['txtDescription'] = $request->description;
		if ( $request->hasFile('coursephoto')){
			if ($request->file('coursephoto')->isValid()){
				$FileFullName = $request->file('coursephoto')->getClientOriginalName();
				$extension = $request->file('coursephoto')->extension();
				$FileName = str_replace(".".$extension,"",$FileFullName);
				$FileInsertname = time().'.'.$request->file('coursephoto')->getClientOriginalName();
				$request->file('coursephoto')->move('uploads' , $FileInsertname);
				$inserarr['coursePhotoName'] = $FileName;
				$inserarr['coursePhoto'] = $FileInsertname;				
			}
		}		
        $inserarr['is_active'] = 1;
        $inserarr['is_delete'] = 0;
		if($inserarr['market']=="11"){
            $inserarr['offlineCourseFee'] = $request->offlinefees;
            $inserarr['offlineRegisterLink'] = $request->registerlink;
        }else{  
            $inserarr['offlineCourseFee'] = '';
            $inserarr['offlineRegisterLink'] = '';
        }
        $role = Courses::create($inserarr);
        return redirect()->route('adminCourses')->with('success', 'New admin Courses added successfully.');
    }

    public function edit($id) {
        $user = Courses::find($id);
		
        $breadcum = $this->breadcum;
		$moduletypes = ModuleType::where('is_active', '1')->where('is_delete', '0')->get();
		$leveltypes = Level::where('is_active', '1')->where('is_delete', '0')->get();
		$markets = Markets::where('is_active', '1')->where('is_delete', '0')->get();
        $categorydata = category::where('is_active', '1')->where('is_delete', '0')->get();
        // $categorydata = category::getList();
        return view('admin.manage_courses.update', compact('breadcum', 'user','categorydata', 'moduletypes', 'leveltypes','markets'));
    }

    public function update(UpdateAdminCoursesRequest $request) {
        $all = $request->all();
		
		$updatearr = array();
		$updatearr['varTitle'] = $request->title;
		$updatearr['moduleTypes'] = $request->moduletype;
		$updatearr['level'] = $request->leveltype;
		$updatearr['market'] = $request->markets;
		if(!empty($request->category)){
			$updatearr['categories'] = implode(',',$request->category);
		}
		$updatearr['chrIndiaFees'] = $request->indiafees;
		$updatearr['chrWorldFees'] = $request->worldfees;
		$updatearr['courseDuration'] = $request->courseduration;
		$updatearr['txtDescription'] = $request->description;
		if ($request->hasFile('coursephoto')){
			if ($request->file('coursephoto')->isValid()){
				$FileFullName = $request->file('coursephoto')->getClientOriginalName();
				$extension = $request->file('coursephoto')->extension();
				$FileName = str_replace(".".$extension,"",$FileFullName);
				$FileInsertname = time().'.'.$request->file('coursephoto')->getClientOriginalName();
				$request->file('coursephoto')->move('uploads' , $FileInsertname);
				$updatearr['coursePhotoName'] = $FileName;
				$updatearr['coursePhoto'] = $FileInsertname;				
			}
		}		
        $updatearr['is_active'] = 1;
        $updatearr['is_delete'] = 0;
		if($updatearr['market']=="11"){
            $updatearr['offlineCourseFee'] = $request->offlinefees;
            $updatearr['offlineRegisterLink'] = $request->registerlink;
        }else{  
            $updatearr['offlineCourseFee'] = '';
            $updatearr['offlineRegisterLink'] = '';
        }
		Courses::where('id',$request->uid)->update($updatearr);

        // Courses::find($all['uid'])->update($all);
        return redirect()->route('adminCourses')->with('success', 'Courses updated successfully.');
    }

    public function publish(Request $request) {
        try {
            $record = Courses::find($request->id);
			// echo $record->is_active;exit;
            if (!empty($record)) {
                if ($record->is_active == 1) {
                    Courses::find($record->id)->update(['is_active' => 0]);
                } else {
                    Courses::find($record->id)->update(['is_active' => 1]);
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
        Courses::destroy($id);
        return redirect()->back()->with('success', 'Admin Courses deleted successfully.');
    }
	
	public function getCoursesDetails(Request $request){
        
        $marketId = $request->id;        
        $coursesdata = Courses::select('id','varTitle as title')->where('market',$marketId)->where('is_active', '1')->where('is_delete', '0')->get();
        
        $html = '';        
        $functionenable = '';
      
        if(!$coursesdata->isEmpty()){
            $html.= '<select name="course" id="course" '.$functionenable.' class="form-control blackcolor" >';
            $html.= '<option value="">Please select course</option>';
            foreach($coursesdata as $coursekey => $courseval){
                $html.= '<option value="'.$courseval['id'].'">'.$courseval['title'].'</option>';
            }
            $html.= '</select>';
        }

        echo $html;
        exit;
    }

}
