<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Language;
use App\Models\Markets;
use App\Models\Courses;
use App\Models\Payments;
use App\Models\PaymentsHistory;
use App\Models\ModuleType;
use App\Models\Level;
use App\Models\CoursesVideos;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;

class CoursesVideosController extends Controller
{
    public function getCourseVideos(Request $request)
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
			$courseid = $request->courseId;
			$user = Auth::user();
			if(!empty($user)){
				
				$currentdate = date('Y-m-d H:i:s');
				
				// $paymenthistorylevelchk = PaymentsHistory::select('id', 'courseid', 'levelname', 'level')->where('userid', $user->id)->where('payment_status', 'S')->get();
				$paymenthis = PaymentsHistory::select('*')->where('userid', $user->id)->where('courseid', $courseid)->where('payment_status', 'S')->orderBy('created_at','asc')->where('package_enddate', '>=', $currentdate)->get();
				$paymenthistorycount = $paymenthis->count();
				if($paymenthistorycount>0){
					$coursevideos = CoursesVideos::select('*','videoname as videourl')->where('is_active', '1')->where('is_delete', '0')->orderBy('videoorder','asc')->orderBy('created_at','asc')->get();
					$coursevideosarr = array();
					// $coursevideos->videourl = '';
					foreach($coursevideos as $coursekey => $courseval){
						// echo $courseval->videoname;
						// echo "\n";
						// $coursevideosarr[$coursekey] = $courseval;
						if($courseval->videoname!="" && file_exists(public_path('uploads/'.$courseval->videoname))){
							$fileurl = url('uploads/'.$courseval->videoname);
							$coursevideos[$coursekey]->videourl = $fileurl;
						}else{
							$coursevideos[$coursekey]->videourl = '';
						}
					}
					
					$response = [
						'status' => true,
						'statusCode' => 200,
						'data'  => $coursevideos,
						'errormessage' => [],
						'message' => ''
					];					
				}else{
					$response = [
						'status' => true,
						'statusCode' => 200,
						'data'  => [],
						'errormessage' => [],
						'message' => ''
					];
				}
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
		/*	
		$moduletypes = ModuleType::select('name', 'id')->where('is_active', '1')->where('is_delete', '0')->orderBy('intorder','asc')->get();
		
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => $moduletypes,
			'errormessage' => [],
            'message' => ''
        ];*/
		
		return response()->json($response);		
	} 		
}
