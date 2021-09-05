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
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use DB;
// use Ixudra\Curl\Facades\Curl;
use Razorpay\Api\Api;
use App\Models\Level;
use Mail;

class PaymentsController extends Controller
{
	public function getOrder(Request $request){
		
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
				
				$coursevalidate = false;				
				$errormsg = '';
				
				// $courses = Courses::select('id', 'chrIndiaFees', 'chrWorldFees', 'moduleTypes', 'level')->where('id', $courseid)->where('is_active', '1')->where('is_delete', '0')->first();
				$courses = Courses::select('id', 'chrIndiaFees', 'chrWorldFees', 'moduleTypes', 'level','varTitle','coursePhoto')->where('id', $courseid)->where('is_active', '1')->where('is_delete', '0')->first();
				
				$moduletypes = $courses->moduleTypes;
				if($moduletypes==1){
					$level = $courses->level;
					// echo $level;
					if($level=="2"){
						$paymenthistorylevelchk = PaymentsHistory::select('id', 'courseid', 'levelname', 'level')->where('userid', $user->id)->where('payment_status', 'S')->where('moduletype', '1')->where('level', '1')->get();
						// echo count($paymenthistorylevelchk);
						if($paymenthistorylevelchk->isEmpty() && count($paymenthistorylevelchk)==0){
							$coursevalidate = true;
							$errormsg = 'If you course buy first time so please first buy Beginner course.';
						}else{
							$coursevalidate = false;
							$errormsg = '';
						}
					}					
										
				}else{
					$coursevalidate = false;
					$errormsg = '';
				}
				
				if($coursevalidate){					
					$response = [
						'status' => false,
						'statusCode' => 200,
						'data'  => [],
						'errormessage' => [],
						'message' => $errormsg
					];
				}else{
					$varname = str_replace(" ","",$user->name);
					$datetime = date('dmYHIs');
					$receipt = strtoupper("ORDER".$user->id."".$varname."".$datetime);
					$varcountrycode = $user->varcountryCode;
					if($varcountrycode=="IN"){
						$currency = "INR";
						$amount = $courses->chrIndiaFees."00"; // 111; 
					}else{
						$currency = "USD";
						$amount = $courses->chrWorldFees."00";  // 111;
					}
					
									
					$moduledetail = ModuleType::select('id', 'name')->where('id', $moduletypes)->where('is_active', '1')->where('is_delete', '0')->first();
					
					$leveldetail = Level::select('id', 'name')->where('id', $courses->level)->where('is_active', '1')->where('is_delete', '0')->first();
					
					$method_request = [
						'receipt' => $receipt,
						'amount' => $amount,
						'currency' => $currency,
					];
					
					$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_URL => "https://api.razorpay.com/v1/orders",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_TIMEOUT => 30000,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS => json_encode($method_request),
						CURLOPT_HTTPHEADER => array(
							// Set Here Your Requesred Headers
							// "Authorization: Basic rzp_test_meTebHlGu9wvXf:sCpbOSMRicQoLwfJOyKAV7kk",
							"Content-Type: application/json",
						),
					));
					curl_setopt($curl, CURLOPT_USERPWD,  env('RAZORPAY_KEY').':'.env('RAZORPAY_SECRET'));
					$output = curl_exec($curl);
					curl_close($curl);

					$curlresponse = json_decode($output);
					
					if(empty($curlresponse->error)){
					    $imageUrl = '';
						if ($courses->coursePhoto !="" && file_exists(public_path('uploads/'.$courses->coursePhoto))){
							$PhotoName = $courses->coursePhoto;							
							$fileurl = ResizeImageUsingImageName($PhotoName,'course',300,200);							
							$imageUrl = $fileurl;
						}
						
						$insertpayment = array(
							'userid' => $user->id,
							'courseid' => $courseid,
							// 'payment_id' => $request->comment,						
							'amount' => substr($amount, 0, -2),
							'receipt' =>$receipt,
							'currency' =>$currency,
							'orderid' =>$curlresponse->id,
						//	'payment_id' =>$curlresponse[''],
							'entity' =>$curlresponse->entity,						
							'amount_paid' =>substr($curlresponse->amount_paid, 0, -2),
							'amount_due' =>substr($curlresponse->amount_due, 0, -2),
							'offer_id' =>$curlresponse->offer_id,
							'status' =>$curlresponse->status,
							'attempts' =>$curlresponse->attempts,
							'notes' => serialize($curlresponse->notes),
							'order_created_at' =>$curlresponse->created_at,
							'moduletype' =>$moduletypes,
							'modulename' =>$moduledetail->name,
							'level' => $courses->level,		
							'levelname'  => $leveldetail->name,
							'imageUrl'  => $imageUrl,
							'courseTitle'  => $courses->varTitle,
						);
						
						$payments = Payments::create($insertpayment);
						$lastInsertedId = $payments->id;
						
						$curlresponse->lastinsertid = $lastInsertedId;
						$response = [
							'status' => true,
							'statusCode' => 200,
							'data'  => $curlresponse,
							'errormessage' => [],
							'message' => ''
						];
						
					}else{
						$response = [
							'status' => false,
							'statusCode' => 200,
							'data'  => [],
							'errormessage' => $curlresponse->error,
							'message' => 'Invalid data',
						];
					}
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
		
		return response()->json($response);	
	}
	
	public function verifyPaymentSignature(Request $request){
		
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];		
		
        $rules = [
            'razorpay_payment_id' => 'required',            
            'razorpay_order_id' => 'required',            
            'razorpay_signature' => 'required',            
        ];
        
        $messages = [
            'razorpay_payment_id.required' => 'Payment Id Required.',            
            'razorpay_order_id.required' => 'Order Id Required.',            
            'razorpay_signature.required' => 'Signature Required.',            
        ];
		
		$validator = Validator::make($request->all(), $rules, $messages);
		
		if(!$validator->fails()) {
						
			$user = Auth::user();
			if(!empty($user)){
			
				// $paymentdetail = Payments::select('id')->where('userid', $user->id)->where('orderid', $request->razorpay_order_id)->first();
				
				$updatepayment = array(						
					'payment_id' => $request->razorpay_payment_id,						
					'signature' => $request->razorpay_signature,					
					// 'razorpay_order_id' =>$request->razorpay_order_id
				);					
				$payments = Payments::where('userid', $user->id)->where('orderid', $request->razorpay_order_id)->update($updatepayment);
				
				$actionstring = $request->razorpay_order_id."|".$request->razorpay_payment_id;
				$newgeneratsig = hash_hmac('sha256', $actionstring, env('RAZORPAY_SECRET'));
				
				$razorpay_signature = $request->razorpay_signature;
				
				if($newgeneratsig == $razorpay_signature){
					$updatepaymentstatus = array(						
						'payment_status' => "S"						
					);
					$paymentstatus = Payments::where('userid', $user->id)->where('orderid', $request->razorpay_order_id)->update($updatepaymentstatus);

					$payments = Payments::select('*')->where('userid', $user->id)->where('orderid', $request->razorpay_order_id)->first();					
					
					$coursedetails = Courses::select('id', 'varTitle', 'courseDuration')->where('id', $payments['courseid'])->where('is_active', '1')->where('is_delete', '0')->first();
					
					$currentdate = date('Y-m-d H:i:s');
					$paymenthistory['userid'] = $payments['userid'];
					$paymenthistory['courseid'] = $payments['courseid'];
					$paymenthistory['orderid'] = $payments['orderid'];
					$paymenthistory['receipt'] = $payments['receipt'];
					$paymenthistory['entity'] = $payments['entity'];
					$paymenthistory['amount'] = $payments['amount'];
					$paymenthistory['amount_paid'] = $payments['amount_paid'];
					$paymenthistory['amount_due'] = $payments['amount_due'];
					$paymenthistory['currency'] = $payments['currency'];
					$paymenthistory['offer_id'] = $payments['offer_id'];
					$paymenthistory['status'] = $payments['status'];
					$paymenthistory['attempts'] = $payments['attempts'];
					$paymenthistory['notes'] = $payments['notes'];
					$paymenthistory['order_created_at'] = $payments['order_created_at'];
					$paymenthistory['payment_id'] = $payments['payment_id'];
					$paymenthistory['signature'] = $payments['signature'];
					// $paymenthistory['razorpay_order_id'] = $payments['razorpay_order_id'];
					$paymenthistory['payment_status'] = $payments['payment_status'];
					$paymenthistory['created_at'] = $payments['created_at'];
					$paymenthistory['updated_at'] = $payments['updated_at'];
					$paymenthistory['moduletype'] = $payments['moduletype'];
					$paymenthistory['modulename'] = $payments['modulename'];
					$paymenthistory['level'] = $payments['level'];
					$paymenthistory['levelname'] = $payments['levelname'];					
					$paymenthistory['package_startdate'] = $currentdate;
					$paymenthistory['package_enddate'] = date('Y-m-d H:i:s', strtotime($currentdate. ' + '.$coursedetails['courseDuration'].' day'));
					$paymenthistory['course_title'] = $coursedetails['varTitle'];
					$paymenthistory['course_duration'] = $coursedetails['courseDuration'];
					PaymentsHistory::create($paymenthistory);
					
					Payments::where('id',  $payments['id'])->delete();	

					$lastInsertedId= $user->id;
					$to_name = $user->name;
					$to_email = $user->email;
					$varTitle = $coursedetails['varTitle'];
					$amount = $payments['amount'];
					$orderid = $payments['orderid'];
					$package_startdate = $paymenthistory['package_startdate'];
					$package_enddate = $paymenthistory['package_enddate'];
					$bodyhtml = 'Thank you for using '.env('MAIL_FROM_NAME').'. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					
					<b>Transaction Details</b><br/><br/><br/>
					<b>Course Name:</b> '.$varTitle.' <br/>
					<b>Amount:</b> '.$amount.' <br/>
					<b>Order ID:</b> '.$orderid.' <br/>
					<b>Package Start Date:</b> '.$package_startdate.' <br/>
					<b>Package End Date:</b> '.$package_enddate.' <br/>';
					$data = array('name'=>$to_name, "body" => $bodyhtml);
					
					Mail::send('emails.payment', $data, function($message) use ($to_name, $to_email) {
					$message->to($to_email, $to_name)->subject(env('MAIL_FROM_NAME').' - Payment success');
						$message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));		
					});
					
				}
				
				/* 				
				$api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
				$attributes  = array('razorpay_signature'  => $request->razorpay_signature,  'razorpay_payment_id'  => $request->razorpay_payment_id ,  'razorpay_order_id' => $request->razorpay_order_id);
				$orderverify  = $api->utility->verifyPaymentSignature($attributes);
				*/				
				
				$response = [
						'status' => true,
						'statusCode' => 200,
						'data'  => [],
						'errormessage' => [],
						'message' => 'success'
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
	
	
	public function getPaymentHistory(Request $request){
		
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];
		
		$user = Auth::user();
		if(!empty($user)){
			// $payments = PaymentsHistory::where('userid', $user->id);
			$paymentshistory = PaymentsHistory::select('payments_history.orderid as orderId','payments_history.receipt','payments_history.amount','payments_history.currency','payments_history.course_title as courseTitle','payments_history.modulename as moduleName','payments_history.package_startdate as packageStartDate','payments_history.package_enddate as packageEndDate','payments_history.created_at as createAt','courses.coursePhotoName as photoName','courses.coursePhoto as imageName')			
			->join('courses', 'courses.id', '=', 'payments_history.courseid')
			->where('payments_history.userid', $user->id)
			->where('payments_history.payment_status', 'S')
			->orderBy('payments_history.created_at', 'desc')
			->get();

			foreach($paymentshistory as $paymentkey => $paymentval){
			$fileurl = "";
			if ($paymentval['imageName']!="" && file_exists(public_path('uploads/'.$paymentval['imageName']))){
					$paymentshistory[$paymentkey]['PhotoName'] = $paymentval['PhotoName'];
					
					$fileurl = ResizeImageUsingImageName($paymentval['imageName'],'course',300,200);
					
					$paymentshistory[$paymentkey]['imageUrl'] = $fileurl;
				}
			}
			
			$response = [
				'status' => true,
				'statusCode' => 200,
				'data'  => $paymentshistory,
				'errormessage' => [],
				'message' => ''
			];
			
		}
		
		return response()->json($response);
	}
	
	public function getMySubscriptions(Request $request){
		
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];
		
		$user = Auth::user();
		if(!empty($user)){
			$currentdate = date('Y-m-d H:i:s');
			$userid = $user->id;
			// $paymentongoing = PaymentsHistory::select('*')->where('userid', $userid)->where('payment_status', 'S')->orderBy('created_at','asc')->where('package_enddate', '>=', $currentdate)->get();
			$paymentongoing = PaymentsHistory::select('payments_history.courseid as courseId','payments_history.orderid as orderId','payments_history.receipt','payments_history.amount','payments_history.currency','payments_history.course_title as courseTitle','payments_history.modulename as moduleName','payments_history.package_startdate as packageStartDate','payments_history.package_enddate as packageEndDate','payments_history.created_at as createAt','courses.coursePhotoName as photoName','courses.coursePhoto as imageName')			
			->join('courses', 'courses.id', '=', 'payments_history.courseid')
			->where('payments_history.package_enddate', '>=', $currentdate)
			->where('payments_history.userid', $userid)
			->where('payments_history.payment_status', 'S')
			->orderBy('payments_history.created_at', 'desc')
			->get();
			
			foreach($paymentongoing as $paymentkey => $paymentval){
			$fileurl = "";
			if ($paymentval['imageName']!="" && file_exists(public_path('uploads/'.$paymentval['imageName']))){
					$paymentongoing[$paymentkey]['PhotoName'] = $paymentval['PhotoName'];
					$fileurl = ResizeImageUsingImageName($paymentval['imageName'],'course',300,200);	$paymentongoing[$paymentkey]['imageUrl'] = $fileurl;
				}
			}

			$paymentonpast = PaymentsHistory::select('payments_history.courseid as courseId','payments_history.orderid as orderId','payments_history.receipt','payments_history.amount','payments_history.currency','payments_history.course_title as courseTitle','payments_history.modulename as moduleName','payments_history.package_startdate as packageStartDate','payments_history.package_enddate as packageEndDate','payments_history.created_at as createAt','courses.coursePhotoName as photoName','courses.coursePhoto as imageName')			
			->join('courses', 'courses.id', '=', 'payments_history.courseid')
			->where('payments_history.package_enddate', '<', $currentdate)
			->where('payments_history.userid', $userid)
			->where('payments_history.payment_status', 'S')
			->orderBy('payments_history.created_at', 'desc')
			->get();
			
			foreach($paymentonpast as $paymentkey => $paymentval){
			$fileurl = "";
			if ($paymentval['imageName']!="" && file_exists(public_path('uploads/'.$paymentval['imageName']))){
					$paymentonpast[$paymentkey]['PhotoName'] = $paymentval['PhotoName'];
					$fileurl = ResizeImageUsingImageName($paymentval['imageName'],'course',300,200);	$paymentonpast[$paymentkey]['imageUrl'] = $fileurl;
				}
			}
			
			$response = [
				'status' => true,
				'statusCode' => 200,
				'data'  => 
					[	
						'onGoingCourse' => $paymentongoing,
						'onPastCourse' => $paymentonpast,
					],
				'errormessage' => [],
				'message' => ''
			];
			
		}
		
		return response()->json($response);
		
		
	}
}