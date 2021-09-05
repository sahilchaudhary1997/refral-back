<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Language;
use App\Models\Markets;
use App\Models\Courses;
use App\Models\ModuleType;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\DashboardNotification;

class DashboardController extends Controller
{
   	public function getDashboard(Request $request)
    {    
        $lanshortcode = 'en';
        if(!empty($request->userId) && $request->userId>0){
			// for language begin
			$UserLangDetail = User::select('users.id','users.intLanguageId','users.intMarketId','languages.name','languages.shortcode')							
			->join('languages', 'languages.id', '=', 'users.intLanguageId')
			->where('users.id', $request->userId)
			->first();					
			$lanshortcode = $UserLangDetail['shortcode'];
			// for language end
		}
		
		$moduletypes = ModuleType::select('name', 'id')->where('is_active', '1')->where('is_delete', '0')->orderBy('intOrder','asc')->get();
		$modulesarr = array();
		foreach($moduletypes as $modulekey => $moduleval){
			
			$modulesarr[$modulekey]['id']= $moduleval->id;
			// $modulesarr[$modulekey]['title']= $moduleval->name;
			if($lanshortcode !="en"){					
				$nameresponse = languageTranslateUsingCurl('en',$lanshortcode,$moduleval->name);					
				$modulesarr[$modulekey]['title'] = $nameresponse;
				
			}else{
				$modulesarr[$modulekey]['title']= $moduleval->name;
			}
			
			$coursedetail = Courses::getCourseByModuleId($moduleval->id);
			
			foreach($coursedetail as $coursekey => $courseval){
		
				$fileurl = "";
				if ($courseval->imageName!="" && file_exists(public_path('uploads/'.$courseval->imageName))){
					$coursedetail[$coursekey]->imageName = $courseval->imageName;
					// $fileurl = url('uploads/'.$courseval->imageName);
					$fileurl = ResizeImageUsingImageName($courseval->imageName,'course',300,200);
					
					$coursedetail[$coursekey]->imageUrl = $fileurl;
					
				}else{
					$coursedetail[$coursekey]->imageName = NULL;
					$coursedetail[$coursekey]->imageUrl = NULL;
				}
				
				if($lanshortcode !="en"){					
					$titleresponse = languageTranslateUsingCurl('en',$lanshortcode,$courseval->title);					
					$coursedetail[$coursekey]->title = $titleresponse;	
					$marketresponse = languageTranslateUsingCurl('en',$lanshortcode,$courseval->marketName);					
					$coursedetail[$coursekey]->marketName = $marketresponse;
				}else{
					$coursedetail[$coursekey]->title = $courseval->title;
						$coursedetail[$coursekey]->marketName = $courseval->marketName;
				}
				
				
			}
			$modulesarr[$modulekey]['data'] = $coursedetail;
		}
		
	//	$featuredCourses = Courses::select('varTitle as title', 'id')->where('chrFeatured', 'Y')->where('is_active', '1')->where('is_delete', '0')->orderBy('intOrder','asc')->get();
		
	//	$freeCourses = Courses::select('varTitle as title', 'id')->where('chrFree', 'Y')->where('is_active', '1')->where('is_delete', '0')->orderBy('intOrder','asc')->get();
		
		$dashboardnoti = DashboardNotification::select('title', 'description', 'notifytype', 'notifyvideo', 'created_at')->where('is_active', '1')->where('is_delete', '0')->orderBy('created_at','desc')->first();
		
		$dashboardnotifyarr = array();
		$notifytype = $dashboardnoti->notifytype;
		if($notifytype=="V"){
			// $dashboardnotifyarr['title'] = $dashboardnoti->title;
			// $dashboardnotifyarr['description'] = $dashboardnoti->description;
			$dashboardnotifyarr['type'] = 'V';
			$dashboardnotifyarr['videourl'] = '';
			if ($dashboardnoti->notifyvideo!="" && file_exists(public_path('uploads/'.$dashboardnoti->notifyvideo))){
				$fileurl = url('uploads/'.$dashboardnoti->notifyvideo);
				$dashboardnotifyarr['videourl'] = $fileurl;
			}
			if($lanshortcode !="en"){					
				$dashresponse = languageTranslateUsingCurl('en',$lanshortcode,$dashboardnoti->title);					
				$dashboardnotifyarr['title'] = $dashresponse;	
				$dashboardnotifyarr['description'] = languageTranslateUsingCurl('en',$lanshortcode,$dashboardnoti->description);			
			}else{
				$dashboardnotifyarr['title'] = $dashboardnoti->title;
				$dashboardnotifyarr['description'] = $dashboardnoti->description;
			}
		}
		if($notifytype=="T"){
			// $dashboardnotifyarr['title'] = $dashboardnoti->title;
			// $dashboardnotifyarr['description'] = $dashboardnoti->description;
			$dashboardnotifyarr['type'] = 'T';
			$dashboardnotifyarr['videourl'] = '';
			if($lanshortcode !="en"){					
				$dashdesresponse = languageTranslateUsingCurl('en',$lanshortcode,$dashboardnoti->title);					
				$dashboardnotifyarr['title'] = $dashdesresponse;	
				$dashboardnotifyarr['description'] = languageTranslateUsingCurl('en',$lanshortcode,$dashboardnoti->description);			
			}else{
				$dashboardnotifyarr['title'] = $dashboardnoti->title;
				$dashboardnotifyarr['description'] = $dashboardnoti->description;
			}
		}		
		
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => 
				[	
					'modules' => $modulesarr,
					//'featuredCourses' => $featuredCourses,
					//'freeCourses' => $freeCourses,
					'dashboardNotification' => $dashboardnotifyarr,					
				]
			,
			'errormessage' => [],
            'message' => ''
        ];
		
		return response()->json($response);		
	}	
}