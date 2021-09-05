<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
// use App\Models\Language;
// use App\Models\Markets;
use App\Models\Courses;
use App\Models\Reviews;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use DB;
class ReviewsController extends Controller
{
    public function getReviews(Request $request)
    {
        $response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];		
	
        $rules = [
            'courseId' => 'required',            
        ];
        
        $messages = [
            'courseId.required' => 'Course Id Required.',            
        ];
		
		$validator = Validator::make($request->all(), $rules, $messages);
		
		if(!$validator->fails()) {
		    
			if(isset($request->userId) && is_numeric($request->userId)){
				$userid = $request->userId;
			}else{
				$userid = '0';
			}
			// echo $userid;exit;
		   $courses = Courses::where('id', $request->courseId)->first();
		   if ($courses) {
		      
		        $reviewsaverage  = Reviews::where('IntCourseId', $request->courseId)->where('is_active', '1')->where('is_delete', '0')->avg('intNumberofRating');
		        $reviewscount  = Reviews::select(DB::raw("COUNT(intNumberofRating) as 'Total'"),DB::raw("SUM(intNumberofRating) as 'TotalSum'"))->where('IntCourseId', $request->courseId)->where('is_active', '1')->where('is_delete', '0')->first();
		     
		       /* $reviews = Reviews::select('users.name', 'users.email',  'users.usersPhoto as fileName', 'reviews.txtComment as comment', 'reviews.id','reviews.intNumberofRating as numberOfRating' )->where('reviews.IntCourseId', $request->intCourseId)->where('reviews.chrActive', 'Y')->where('reviews.chrDelete', 'N')->orderBy('reviews.created_at','asc')->leftJoin('users', function($join){
					$join->on('users.id', '=', 'reviews.intUserId');
				})->get();*/
				
				
				$reviewsquery = Reviews::select('users.name',  'users.id as userId', 'users.email',  'users.usersPhoto as fileName', 'reviews.txtComment as comment', 'reviews.id','reviews.intNumberofRating as numberOfRating','reviews.created_at as reviewDate',DB::raw("CONCAT('https://picsum.photos/300/200','') AS imageUrl"),DB::raw('(CASE                        
                        WHEN users.id = '.$userid.' THEN "1" 
                        ELSE "2" 
                        END) AS userorder') )
				->where('reviews.IntCourseId', $request->courseId)
				->where('reviews.is_active', '1')
				->where('reviews.is_delete', '0')
				->orderBy('userorder','asc')
				->orderBy('reviews.created_at','asc')
				->leftJoin('users', function($join){
					$join->on('users.id', '=', 'reviews.intUserId');
				});
				
				if(isset($request->offset) && $request->offset!="" && isset($request->limit) && $request->limit!=""){
					$offset = $request->offset;
					if($offset == 1){
						$offset = 0;
					}else{
						$offset = $request->offset;
					}
					$reviewsquery->offset($offset);
				}
				if(isset($request->limit) && $request->limit!="" && isset($request->offset) && $request->offset!="" ){
					$reviewsquery->limit($request->limit);
				}
				
				$reviews = $reviewsquery->get();
        		foreach($reviews as $reviewkey => $reviewval){
					$fileurl = "";
					if ($reviewval['fileName']!="" && file_exists(public_path('uploads/'.$reviewval['fileName']))){			
						$reviews[$reviewkey]['fileName'] = $reviewval['fileName'];
						// $fileurl = url('uploads/'.$reviewval['fileName']);
						$fileurl = ResizeImageUsingImageName($reviewval['fileName'],'users',300,200);
						$reviews[$reviewkey]['imageUrl'] = $fileurl;						
					}else{
						$reviews[$reviewkey]['fileName'] = NULL;
						$reviews[$reviewkey]['imageUrl'] = NULL;
					}
				}
				// $floatavg = number_format((float)$reviewsaverage, 2, '.', '');
        		$response = [
                    'status' => true,
                    'statusCode' => 200,
                    'data'  => [
                        'reviews'=>$reviews,
                        'averageReview' => (float)$reviewsaverage,
                        'totalReviews' => $reviewscount['Total'],
                       // 'totalReviewSum' => $reviewscount['TotalSum'],
                        ],
        			'errormessage' => [],
                    'message' => ''
                ];
		   }else{
		       	$response = [
                    'status' => true,
                    'statusCode' => 200,
                    'data'  => [],
        			'errormessage' => [],
                    'message' => 'Course not exists.'
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
	
	public function addReview(Request $request)
    {		
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];
		
		$rules = [
            'numberOfRating' => 'required',            
            'userId' => 'required',            
            'courseId' => 'required',            
            'comment' => 'required',            
        ];
		
		$messages = [
            'courseId.required' => 'Course id required.',            
            'numberOfRating.required' => 'Number of rating required.',            
            'userId.required' => 'User id Required.',            
            'comment.required' => 'Comment required.',            
        ];
		
		$validator = Validator::make($request->all(), $rules, $messages);
		
		if(!$validator->fails()) {
			
			if($request->courseId!="" && is_numeric($request->courseId) && $request->numberOfRating!="" && is_numeric($request->numberOfRating) && $request->userId!="" && is_numeric($request->userId) ){
				
				$reviews = Reviews::where('intUserId', $request->userId)->where('intCourseId', $request->courseId)->first();
				if ($reviews) {
					$response = [
						'status' => false,
						'statusCode' => 200,
						'data'  => [],
						'errormessage' => [],
						'message' => 'You have allready submited review'
					];
				}else{
					$insertreview = array(
						'intUserId' => $request->userId,
						'intCourseId' => $request->courseId,
						'txtComment' => $request->comment,
						'intNumberofRating' => $request->numberOfRating,
						'is_active' => '1',
						'is_delete' => '0'
					);
				
					$reviews = Reviews::create($insertreview);
					$response = [
						'status' => true,
						'statusCode' => 200,
						'data'  => [],
						'errormessage' => [],
						'message' => 'Your review successfully submitted.'
					];
				}				
			}else {
				$response = [
					'status' => false,
					'statusCode' => 404,
					'data'  => [],
					'errormessage' => [],
					'message' => 'Invalid data'
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
