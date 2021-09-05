<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Language;
use App\Models\Markets;
use App\Models\Courses;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\PaymentsHistory;
use App\Models\CoursesVideos;

class CoursesController extends Controller
{
    public function getCourses(Request $request)
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
			$marketarr = explode(',', $UserLangDetail['intMarketId']);			
		}
		
		$coursesdata =  Courses::select('courses.chrIndiaFees', 'courses.chrWorldFees','courses.varTitle as title','courses.id as id','levels.name as levelName','markets.name as marketName','courses.coursePhotoName as PhotoName','courses.coursePhoto as imageName','courses.courseDuration as duration','module_types.name as module',DB::raw("CONCAT('https://picsum.photos/300/200','') AS imageUrl"),DB::raw("GROUP_CONCAT(categories.name) as categoriesName"), DB::raw("(SELECT COUNT(intNumberofRating) FROM reviews
                                WHERE reviews.intCourseId = courses.id) as numberOfReview " ), DB::raw("(SELECT AVG(intNumberofRating) FROM reviews
                                WHERE reviews.intCourseId = courses.id) as averageReview " ) )
		->join('module_types', 'module_types.id', '=', 'courses.moduleTypes')
		->join('levels', 'levels.id', '=', 'courses.level')
		->join('markets', 'markets.id', '=', 'courses.market')
        ->leftjoin("categories",DB::raw("FIND_IN_SET(categories.id,courses.categories)"),">",DB::raw("'0'"))
        ->groupBy("courses.id")
		->where('courses.is_active', '1')
		->where('courses.is_delete', '0')
		->orderBy('courses.intOrder','asc');
		if(!empty($marketarr)){
			$coursesdata->whereIn('courses.market', $marketarr);
		}
		
		$courses = $coursesdata->get();
		
		
		foreach($courses as $coursekey => $courseval){
			$fileurl = "";
			if ($courseval['imageName']!="" && file_exists(public_path('uploads/'.$courseval['imageName']))){
				$courses[$coursekey]['PhotoName'] = $courseval['PhotoName'];
				// $fileurl = url('uploads/'.$courseval['imageName']);
				$fileurl = ResizeImageUsingImageName($courseval['imageName'],'course',300,200);
				
				$courses[$coursekey]['imageUrl'] = $fileurl;
			}
			
			if(!empty($request->userId) && $request->userId>0){

				$userid = $request->userId;
				$currentdate = date('Y-m-d H:i:s');
				$id = $courseval['id'];
				$paymenthis = PaymentsHistory::select('*')->where('userid', $userid)->where('courseid', $id)->where('payment_status', 'S')->orderBy('created_at','asc')->where('package_enddate', '>=', $currentdate)->get();
			
				$subscribecount = $paymenthis->count();
				if($subscribecount>0){
					$courses[$coursekey]['isSubscribed'] = true;
				}else{
					$courses[$coursekey]['isSubscribed'] = false;
				}
				
			}else{
				$courses[$coursekey]['isSubscribed'] = false;
			}
			
			if($lanshortcode !="en"){
				$courses[$coursekey]['title'] = languageTranslateUsingCurl('en',$lanshortcode, $courseval['title']);			
			}
		}
		// $courses = Courses::select('varTitle as title', 'id' )->where('chrActive', 'Y')->where('chrDelete', 'N')->orderBy('intOrder','asc')->get();
		
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => $courses,
			'errormessage' => [],
            'message' => ''
        ];
		
		return response()->json($response);		
	}	
	
	public function getCourseDetails(Request $request, $id){
		
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];
		
		if($id!="" && is_numeric($id) ){			
		
			$CourseDetail = Courses::select('courses.varTitle as title','courses.id as id','courses.txtDescription as description','courses.moduleTypes','levels.name as levelName','markets.name as marketName','courses.coursePhotoName as PhotoName','courses.coursePhoto as imageName','courses.courseDuration as duration','courses.features','courses.chrWorldFees as worldFees','courses.chrIndiaFees as indiaFees','module_types.name as module',DB::raw("CONCAT('https://picsum.photos/300/200','') AS imageUrl"),DB::raw("GROUP_CONCAT(categories.name) as categoriesName"), DB::raw("(SELECT COUNT(intNumberofRating) FROM reviews
                                WHERE reviews.intCourseId = courses.id) as numberOfReview " ), DB::raw("(SELECT AVG(intNumberofRating) FROM reviews
                                WHERE reviews.intCourseId = courses.id) as averageReview " ) )
			->join('module_types', 'module_types.id', '=', 'courses.moduleTypes')
			->join('levels', 'levels.id', '=', 'courses.level')
			->join('markets', 'markets.id', '=', 'courses.market')
			->leftjoin("categories",DB::raw("FIND_IN_SET(categories.id,courses.categories)"),">",DB::raw("'0'"))
			->groupBy("courses.id")
			->where('courses.is_active', '1')
			->where('courses.is_delete', '0')
			->where('courses.id', $id)
			->orderBy('courses.intOrder','asc')
			->first();
			
			if(!empty($CourseDetail)){
			 	// echo "<pre>";
			 	// print_r($CourseDetail);
				// exit;
				$CourseDetail['features'] = json_decode($CourseDetail['features']);
				$fileurl = "";
				if ($CourseDetail['imageName']!="" && file_exists(public_path('uploads/'.$CourseDetail['imageName']))){
					$CourseDetail['PhotoName'] = $CourseDetail['PhotoName'];
					// $fileurl = url('uploads/'.$CourseDetail['imageName']);
					$fileurl = ResizeImageUsingImageName($CourseDetail['imageName'],'course',500,400);
					$CourseDetail['imageUrl'] = $fileurl;
				}
				
				$CourseDetail['numberOfVideos'] = 0;

				$moduletypes = $CourseDetail['moduleTypes'];
				if($moduletypes==2){
					$CourseDetail['isTrialAvailable'] = true;				
				}
                
                $lanshortcode = 'en';
                
				if(!empty($request->userId)){
					$userid = $request->userId;
					$currentdate = date('Y-m-d H:i:s');
					$paymenthis = PaymentsHistory::select('*')->where('userid', $userid)->where('courseid', $id)->where('payment_status', 'S')->orderBy('created_at','asc')->where('package_enddate', '>=', $currentdate)->get();
					// $paymenthis = PaymentsHistory::select('*')->where('userid', $userid)->where('courseid', $id)->where('payment_status', 'S')->orderBy('created_at','asc')->where('package_enddate', '>=', '2021-07-14 18:09:15')->get();
					$subscribecount = $paymenthis->count();
					if($subscribecount>0){
						$coursevideos = CoursesVideos::select('*','videoname as videourl')->where('is_active', '1')->where('is_delete', '0')->orderBy('videoorder','asc')->orderBy('created_at','asc')->get();
						$videoscount = $coursevideos->count();
						$CourseDetail['numberOfVideos'] = $videoscount;
						
						$CourseDetail['isSubscribed'] = true;
					}else{
						$CourseDetail['isSubscribed'] = false;
					}
                    
                    // for language begin
					$UserLangDetail = User::select('users.id','users.intLanguageId','users.intMarketId','languages.name','languages.shortcode')							
							->join('languages', 'languages.id', '=', 'users.intLanguageId')
							->where('users.id', $userid)
							->first();
					// print_r($UserLangDetail);
					$lanshortcode = $UserLangDetail['shortcode'];
					// $lanshortcode = 'es';
					// for language end
					
					if($moduletypes==2 && $request->userId>0){
						$userDetails = User::where('id',$request->userId)->first();
						// $CourseDetail['isTrialAvailable'] = true;						
						if(!empty($userDetails)){							
							if($userDetails->isTrial==1){
								$CourseDetail['isTrialAvailable'] = false;
							}
						}
					}
					
				}else{
					$CourseDetail['isSubscribed'] = false;
				}
				
				if($lanshortcode !="en"){					
					$titleresponse = languageTranslateUsingCurl('en',$lanshortcode,$CourseDetail['title']);					
					$CourseDetail['title'] = $titleresponse;

					$descriptionresponse = languageTranslateUsingCurl('en',$lanshortcode,$CourseDetail['description']);
					$CourseDetail['description'] = $descriptionresponse;
				}
				
				
			/* $CourseDetail = Courses::select('varTitle as title', 'id','txtDescription as description','chrWorldFees as worldFees','chrIndiaFees as indiaFees')->where('id', $id)->where('is_active', '1')->where('is_delete', '0')->orderBy('intOrder','asc')->first(); */
				$response = [
					'status' => true,
					'statusCode' => 200,
					'data'  => $CourseDetail,				
					'errormessage' => [],
					'message' => ''
				];

			}else{
				$response = [
					'status' => false,
					'statusCode' => 404,
					'data'  => [],
					'errormessage' => [],
					'message' => 'Your course detail not found'
				];
			}

		}else{
			$response = [
				'status' => false,
				'statusCode' => 404,
				'data'  => [],
				'errormessage' => [],
				'message' => 'Your course detail not valid!'
			];
		}
		return response()->json($response);
	}
	
	public function getCoursesbyMarket(Request $request)
    {
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];

		$lanshortcode = 'en';

		if(!empty($request->userId) && $request->userId>0){
			$userId = $request->userId;
			$UserDetail = User::select('users.id','users.intLanguageId','users.intMarketId','languages.name','languages.shortcode')
			->join('languages', 'languages.id', '=', 'users.intLanguageId')
			->where('users.id', $userId)
			->first();

			// for language begin
			$UserLangDetail = User::select('users.id','users.intLanguageId','users.intMarketId','languages.name','languages.shortcode')	
					->join('languages', 'languages.id', '=', 'users.intLanguageId')
					->where('users.id', $userId)
					->first();
			$lanshortcode = $UserLangDetail['shortcode'];			
			// for language end
			
			$marketarr = explode(',', $UserDetail['intMarketId']);
			
		}else{
			$allmarketdetail = Markets::select('id')->where('is_active','1')->where('is_delete','0')->get()->toArray();
			$marketarr = array();
			foreach($allmarketdetail as $markey => $marval)
			{
				$marketarr[] = $marval['id'];
			}			
		}

		$modulesdataarr = array();
		foreach($marketarr as $marketkey => $marketval){			
			$marketDetail = Markets::select('id','name')->where('is_active','1')->where('is_delete','0')->where('id',$marketval)->first();
			$modulesdataarr[$marketkey]['id'] = $marketDetail['id'];
			if($lanshortcode !="en"){					
				$marekttitleresponse = languageTranslateUsingCurl('en',$lanshortcode,$marketDetail['name']);			
			}else{
				$marekttitleresponse = $marketDetail['name'];
			}

			$modulesdataarr[$marketkey]['name'] = $marekttitleresponse;
			
			$coursesdetails = Courses::select('courses.varTitle as title','courses.id as id','courses.courseDuration as duration','courses.chrWorldFees as worldFees','courses.chrIndiaFees as indiaFees','courses.market','module_types.name as module')
			->join('markets', 'markets.id', '=', 'courses.market')
			->join('module_types', 'module_types.id', '=', 'courses.moduleTypes')
			
			->groupBy("courses.id")
			->where('courses.is_active', '1')
			->where('courses.is_delete', '0')
			->where('courses.market', $marketDetail['id'])
			->orderBy('courses.intOrder','asc')
			->get();

		
			$coursesarr = array();
			foreach($coursesdetails as $coursesdetkey => $coursesdetval){

				$coursesarr[$coursesdetkey]['isSubscribed'] = false;
				if(!empty($request->userId) && $request->userId>0){
					$currentdate = date('Y-m-d H:i:s');
					$paymenthis = PaymentsHistory::select('*')->where('userid',$request->userId)->where('courseid', $coursesdetval['id'])->where('payment_status', 'S')->orderBy('created_at','asc')->where('package_enddate', '>=', $currentdate)->get();	
					$subscribecount = $paymenthis->count();
					if($subscribecount>0){
						$coursesarr[$coursesdetkey]['isSubscribed'] = true;
					}else{
						$coursesarr[$coursesdetkey]['isSubscribed'] = false;
					}
				}

				$marketid = $coursesdetval['market'];
				if($marketid=="11"){
					$currency = "INR";
					$amount = $coursesdetval['indiaFees'];						
				}else{
					$currency = "USD";	
					$amount = $coursesdetval['worldFees'];
				}

				if($lanshortcode !="en"){					
					$coursetitleresponse = languageTranslateUsingCurl('en',$lanshortcode,$coursesdetval['title']);			
				}else{
					$coursetitleresponse = $coursesdetval['title'];
				}
				$coursesarr[$coursesdetkey]['module'] = $coursesdetval['module'];

				$coursesarr[$coursesdetkey]['amount'] = $amount;
				$coursesarr[$coursesdetkey]['currency'] = $currency;
				$coursesarr[$coursesdetkey]['title'] = $coursetitleresponse;
				$coursesarr[$coursesdetkey]['id'] = $coursesdetval['id'];
				$coursesarr[$coursesdetkey]['duration'] = $coursesdetval['duration'];
			}
			$modulesdataarr[$marketkey]['data'] = $coursesarr;			
		}

		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => $modulesdataarr,
			'errormessage' => [],
            'message' => ''
        ];	

		return response()->json($response);
	}
	
	public function getOfflineCourses(Request $request)
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
			$marketarr = explode(',', $UserLangDetail['intMarketId']);			
		}
		
		$coursesdata =  Courses::select('courses.offlineCourseFee','courses.offlineRegisterLink','courses.chrIndiaFees', 'courses.chrWorldFees','courses.varTitle as title','courses.id as id','levels.name as levelName','markets.name as marketName','courses.coursePhotoName as PhotoName','courses.coursePhoto as imageName','courses.courseDuration as duration','module_types.name as module',DB::raw("CONCAT('https://picsum.photos/300/200','') AS imageUrl"),DB::raw("GROUP_CONCAT(categories.name) as categoriesName"), DB::raw("(SELECT COUNT(intNumberofRating) FROM reviews
                                WHERE reviews.intCourseId = courses.id) as numberOfReview " ), DB::raw("(SELECT AVG(intNumberofRating) FROM reviews
                                WHERE reviews.intCourseId = courses.id) as averageReview " ) )
		->join('module_types', 'module_types.id', '=', 'courses.moduleTypes')
		->join('levels', 'levels.id', '=', 'courses.level')
		->join('markets', 'markets.id', '=', 'courses.market')
        ->leftjoin("categories",DB::raw("FIND_IN_SET(categories.id,courses.categories)"),">",DB::raw("'0'"))
        ->groupBy("courses.id")
		->where('courses.moduleTypes', '1')
		->where('courses.is_active', '1')
		->where('courses.is_delete', '0')
		->orderBy('courses.intOrder','asc');
		if(!empty($marketarr)){
			$coursesdata->whereIn('courses.market', $marketarr);
		}
		
		$courses = $coursesdata->get();
		
		
		foreach($courses as $coursekey => $courseval){
			$fileurl = "";
			if ($courseval['imageName']!="" && file_exists(public_path('uploads/'.$courseval['imageName']))){
				$courses[$coursekey]['PhotoName'] = $courseval['PhotoName'];
				// $fileurl = url('uploads/'.$courseval['imageName']);
				$fileurl = ResizeImageUsingImageName($courseval['imageName'],'course',300,200);
				
				$courses[$coursekey]['imageUrl'] = $fileurl;
			}
			
			if(!empty($request->userId) && $request->userId>0){

				$userid = $request->userId;
				$currentdate = date('Y-m-d H:i:s');
				$id = $courseval['id'];
				$paymenthis = PaymentsHistory::select('*')->where('userid', $userid)->where('courseid', $id)->where('payment_status', 'S')->orderBy('created_at','asc')->where('package_enddate', '>=', $currentdate)->get();
			
				$subscribecount = $paymenthis->count();
				if($subscribecount>0){
					$courses[$coursekey]['isSubscribed'] = true;
				}else{
					$courses[$coursekey]['isSubscribed'] = false;
				}
				
			}else{
				$courses[$coursekey]['isSubscribed'] = false;
			}
			
			if($lanshortcode !="en"){
				$courses[$coursekey]['title'] = languageTranslateUsingCurl('en',$lanshortcode, $courseval['title']);			
			}
		}		
		
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => $courses,
			'errormessage' => [],
            'message' => ''
        ];
		
		return response()->json($response);		
	}
}
