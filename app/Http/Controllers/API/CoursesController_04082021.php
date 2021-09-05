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
		$courses = Courses::select('courses.varTitle as title','courses.id as id','levels.name as levelName','markets.name as marketName','courses.coursePhotoName as PhotoName','courses.coursePhoto as imageName','courses.courseDuration as duration','module_types.name as module',DB::raw("CONCAT('https://picsum.photos/300/200','') AS imageUrl"),DB::raw("GROUP_CONCAT(categories.name) as categoriesName"), DB::raw("(SELECT COUNT(intNumberofRating) FROM reviews
                                WHERE reviews.intCourseId = courses.id) as numberOfReview " ), DB::raw("(SELECT AVG(intNumberofRating) FROM reviews
                                WHERE reviews.intCourseId = courses.id) as averageReview " ) )
		->join('module_types', 'module_types.id', '=', 'courses.moduleTypes')
		->join('levels', 'levels.id', '=', 'courses.level')
		->join('markets', 'markets.id', '=', 'courses.market')
        ->leftjoin("categories",DB::raw("FIND_IN_SET(categories.id,courses.categories)"),">",DB::raw("'0'"))
        ->groupBy("courses.id")
		->where('courses.is_active', '1')
		->where('courses.is_delete', '0')
		->orderBy('courses.intOrder','asc')
		->get();
		
		foreach($courses as $coursekey => $courseval){
			$fileurl = "";
			if ($courseval['imageName']!="" && file_exists(public_path('uploads/'.$courseval['imageName']))){
				$courses[$coursekey]['PhotoName'] = $courseval['PhotoName'];
				// $fileurl = url('uploads/'.$courseval['imageName']);
				$fileurl = ResizeImageUsingImageName($courseval['imageName'],'course',300,200);
				
				$courses[$coursekey]['imageUrl'] = $fileurl;
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
		
			$CourseDetail = Courses::select('courses.varTitle as title','courses.id as id','courses.txtDescription as description','levels.name as levelName','markets.name as marketName','courses.coursePhotoName as PhotoName','courses.coursePhoto as imageName','courses.courseDuration as duration','courses.features','courses.chrWorldFees as worldFees','courses.chrIndiaFees as indiaFees','module_types.name as module',DB::raw("CONCAT('https://picsum.photos/300/200','') AS imageUrl"),DB::raw("GROUP_CONCAT(categories.name) as categoriesName"), DB::raw("(SELECT COUNT(intNumberofRating) FROM reviews
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
			
			// echo "<pre>";
			$CourseDetail['features'] = json_decode($CourseDetail['features']);
			$fileurl = "";
			if ($CourseDetail['imageName']!="" && file_exists(public_path('uploads/'.$CourseDetail['imageName']))){
				$CourseDetail['PhotoName'] = $CourseDetail['PhotoName'];
				// $fileurl = url('uploads/'.$CourseDetail['imageName']);
				$fileurl = ResizeImageUsingImageName($CourseDetail['imageName'],'course',500,400);
				$CourseDetail['imageUrl'] = $fileurl;
			}
			
			$CourseDetail['numberOfVideos'] = 0;
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
				
			}else{
				$CourseDetail['isSubscribed'] = false;
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
				'message' => 'Your course detail not valid!'
			];
		}
		return response()->json($response);
	}	
}
