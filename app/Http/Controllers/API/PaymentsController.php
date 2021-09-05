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
use App\general_settings as GeneralSettings;
use App\Models\AdvisoryNotificationReports;

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
				
				$courses = Courses::select('id', 'chrIndiaFees', 'chrWorldFees', 'moduleTypes', 'level','varTitle','coursePhoto', 'courseDuration')->where('id', $courseid)->where('is_active', '1')->where('is_delete', '0')->first();
				
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
						
						$moduledetail = ModuleType::select('id', 'name')->where('id', $moduletypes)->where('is_active', '1')->where('is_delete', '0')->first();
					
						$leveldetail = Level::select('id', 'name')->where('id', $courses->level)->where('is_active', '1')->where('is_delete', '0')->first();
					
						$imageUrl = '';
						if ($courses->coursePhoto !="" && file_exists(public_path('uploads/'.$courses->coursePhoto))){
							$PhotoName = $courses->coursePhoto;							
							$fileurl = ResizeImageUsingImageName($PhotoName,'course',300,200);							
							$imageUrl = $fileurl;
						}						
			
						$insertpayment = array(
							'userid' => $user->id,
							// 'courseid' => $courseid,
							'total_amount' => substr($amount, 0, -2),
							// 'amount' => substr($amount, 0, -2),
							'discount_total' => 'NULL',
							'grand_total' => substr($amount, 0, -2),
							'receipt' =>$receipt,
							'currency' =>$currency,
							'orderid' =>$curlresponse->id,						
							'entity' =>$curlresponse->entity,						
							'amount_paid' =>substr($curlresponse->amount_paid, 0, -2),
							'amount_due' =>substr($curlresponse->amount_due, 0, -2),
							'offer_id' =>$curlresponse->offer_id,
							'status' =>$curlresponse->status,
							'attempts' =>$curlresponse->attempts,
							'notes' => serialize($curlresponse->notes),
							'order_created_at' =>$curlresponse->created_at,
							// 'moduletype' =>$moduletypes,
							// 'modulename' =>$moduledetail->name,
							// 'level' => $courses->level,		
							// 'levelname'  => $leveldetail->name,	
							// 'courseTitle'  => $courses->varTitle,
						);
						
						$payments = Payments::create($insertpayment);
						$lastInsertedId = $payments->id;

						// Payment history begin 						
						$paymenthistory['paymentid'] = $lastInsertedId;
						$paymenthistory['userid'] = $user->id;
						$paymenthistory['courseid'] = $courseid;
						$paymenthistory['total_amount'] = substr($amount, 0, -2);
						// $paymenthistory['discount_total'] = $temptotalDiscountAmount;
						$paymenthistory['grand_total'] = substr($amount, 0, -2);
						// $paymenthistory['orderid'] = $payments['orderid'];
						// $paymenthistory['receipt'] = $payments['receipt'];
						// $paymenthistory['entity'] = $payments['entity'];
						// $paymenthistory['amount'] = $payments['amount'];
						// $paymenthistory['amount_paid'] = $payments['amount_paid'];
						// $paymenthistory['amount_due'] = $payments['amount_due'];
						$paymenthistory['currency'] = $payments['currency'];
						// $paymenthistory['offer_id'] = $payments['offer_id'];
						// $paymenthistory['status'] = $payments['status'];
						// $paymenthistory['attempts'] = $payments['attempts'];
						// $paymenthistory['notes'] = $payments['notes'];
						// $paymenthistory['order_created_at'] = $payments['order_created_at'];
						// $paymenthistory['payment_id'] = $payments['payment_id'];
						// $paymenthistory['signature'] = $payments['signature'];
						// $paymenthistory['razorpay_order_id'] = $payments['razorpay_order_id'];
						$paymenthistory['payment_status'] = 'P';
						// $paymenthistory['created_at'] = $payments['created_at'];
						// $paymenthistory['updated_at'] = $payments['updated_at'];
						$paymenthistory['moduletype'] = $moduletypes;
						$paymenthistory['modulename'] = $moduledetail['name'];
						$paymenthistory['level'] = $courses['level'];
						$paymenthistory['levelname'] = $leveldetail['name'];	
						$paymenthistory['course_title'] = $courses->varTitle;
						$paymenthistory['course_duration'] = $courses->courseDuration;
						PaymentsHistory::create($paymenthistory);
						// payment history end 

						$curlresponse->imageUrl  = $imageUrl;
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

					// new code begin
					$paymentPID = $payments['id'];
					$paymenthistoryDetail = PaymentsHistory::select('grand_total','course_duration','id','courseid','course_title')->where('paymentid',$paymentPID)->where('payment_status','P')->get();

					$emailarr = array();
					foreach($paymenthistoryDetail as $paymenthiskey => $paymenthisval){
						
						// $coursedetails = Courses::select('id', 'varTitle', 'courseDuration')->where('id', $paymenthisval['courseid'])->where('is_active', '1')->where('is_delete', '0')->first();

						$id = $paymenthisval['id'];
						
						$paymenthistory = array();
						$currentdate = date('Y-m-d H:i:s');
						$paymenthistory['package_startdate'] = $currentdate;
						$paymenthistory['package_enddate'] = date('Y-m-d H:i:s', strtotime($currentdate. ' + '.$paymenthisval['course_duration'].' day'));
						$paymenthistory['payment_status'] = 'S';

						$paymenthis = PaymentsHistory::where('userid', $user->id)->where('id', $paymenthisval['id'])->update($paymenthistory);

						$emailarr[$paymenthiskey]['grandTotal'] = $paymenthisval['grand_total'];
						$emailarr[$paymenthiskey]['courseName'] = $paymenthisval['course_title'];
						$emailarr[$paymenthiskey]['packageStartDate'] = $paymenthistory['package_startdate'];
						$emailarr[$paymenthiskey]['packageEndDate'] = $paymenthistory['package_enddate'];						
					}
					// new code end

					// below code not used now 
					/* 
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
					*/					
					$to_name = $user->name;
					$to_email = $user->email;
					// $varTitle = $coursedetails['varTitle'];
					// $amount = $payments['amount'];
					$orderid = $payments['orderid'];
					// $package_startdate = $paymenthistory['package_startdate'];
					// $package_enddate = $paymenthistory['package_enddate'];
					$bodyhtml = 'Thank you for using '.env('MAIL_FROM_NAME').'. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					
					<b>Transaction Details</b><br/><br/><br/>
					<b>Order ID:</b> '.$orderid.' <br/><br/><br/>';
					foreach($emailarr as $emailkey => $emailval){
						$bodyhtml .= '<b>Course Name:</b> '.$emailval['courseName'].' <br/>
						<b>Amount:</b> '.$emailval['grandTotal'].' <br/>					
						<b>Package Start Date:</b> '.$emailval['packageStartDate'].' <br/>
						<b>Package End Date:</b> '.$emailval['packageEndDate'].' <br/><br/>';
					}
					
					$data = array('name'=>$to_name, "body" => $bodyhtml);
					
					Mail::send('emails.payment', $data, function($message) use ($to_name, $to_email) {
					$message->to($to_email, $to_name)->subject(env('MAIL_FROM_NAME').' - Payment success');
						$message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));		
					});
					
				}			
				
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

			// new code begin
			$payments = Payments::select('payments.id','payments.orderid as orderId','payments.receipt','payments.total_amount','payments.discount_total','payments.grand_total','payments.discount','payments.currency','payments.created_at as createAt')->where('payment_status','S')->where('userid',$user->id)->orderBy('payments.created_at', 'desc')->get();

			$paymentshistoryarr = array();
			foreach($payments as $paymentskey => $paymentsval){
				// $paymentshistoryarr[$paymentskey] =  $paymentsval;
				$paymentshistoryarr[$paymentskey]['id'] = $paymentsval['id'];
				$paymentshistoryarr[$paymentskey]['orderId'] = $paymentsval['orderId'];
				$paymentshistoryarr[$paymentskey]['receipt'] = $paymentsval['receipt'];
				$paymentshistoryarr[$paymentskey]['totalAmount'] = $paymentsval['total_amount'];
				$paymentshistoryarr[$paymentskey]['discountTotal'] = $paymentsval['discount_total'];
				$paymentshistoryarr[$paymentskey]['grandTotal'] = $paymentsval['grand_total'];
				$paymentshistoryarr[$paymentskey]['discount'] = $paymentsval['discount']; 
				$paymentshistoryarr[$paymentskey]['currency'] = $paymentsval['currency'];
				$paymentshistoryarr[$paymentskey]['createAt'] = $paymentsval['createAt'];

				$paymentshistory = PaymentsHistory::select('payments_history.total_amount','payments_history.discount_total','payments_history.grand_total','payments_history.discount','payments_history.currency','payments_history.course_title as courseTitle','payments_history.modulename as moduleName','payments_history.package_startdate as packageStartDate','payments_history.package_enddate as packageEndDate','payments_history.created_at as createAt','courses.coursePhotoName as photoName','courses.coursePhoto as imageName','payments_history.course_duration','payments_history.levelname')	
				->join('courses', 'courses.id', '=', 'payments_history.courseid')
				->where('payments_history.userid', $user->id)
				->where('payments_history.paymentid', $paymentsval['id'])
				->where('payments_history.payment_status', 'S')
				->orderBy('payments_history.created_at', 'desc')
				->get();
				
				$coursesarr = array();
				foreach($paymentshistory as $paymentkey => $paymentval){		
					$coursesarr[$paymentkey]['totalAmount'] = $paymentval['total_amount'];
					$coursesarr[$paymentkey]['discountTotal'] = $paymentval['discount_total'];
					$coursesarr[$paymentkey]['grandTotal'] = $paymentval['grand_total'];
					$coursesarr[$paymentkey]['discount'] = $paymentval['discount'];
					$coursesarr[$paymentkey]['currency'] = $paymentval['currency'];
					$coursesarr[$paymentkey]['courseTitle'] = $paymentval['courseTitle'];
					$coursesarr[$paymentkey]['moduleName'] = $paymentval['moduleName'];
					$coursesarr[$paymentkey]['levelName'] = $paymentval['levelname'];
					$coursesarr[$paymentkey]['courseDuration'] = $paymentval['course_duration'];
					$coursesarr[$paymentkey]['packageStartDate'] = $paymentval['packageStartDate'];
					$coursesarr[$paymentkey]['packageEndDate'] = $paymentval['packageEndDate'];
					$coursesarr[$paymentkey]['createAt'] = $paymentval['createAt'];
					// $coursesarr['photoName'] = $paymentval['photoName'];
					// $coursesarr['imageName'] = $paymentval['imageName'];

					$fileurl = "";
					if ($paymentval['imageName']!="" && file_exists(public_path('uploads/'.$paymentval['imageName']))){
						$coursesarr[$paymentkey]['PhotoName'] = $paymentval['PhotoName'];
						
						$fileurl = ResizeImageUsingImageName($paymentval['imageName'],'course',300,200);
						
						$coursesarr[$paymentkey]['imageUrl'] = $fileurl;
					}
				}				
				$paymentshistoryarr[$paymentskey]['coursesPayments'] = $coursesarr;
			}			
			// new code end

			/*			
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
			*/

			
			$response = [
				'status' => true,
				'statusCode' => 200,
				// 'data'  => $paymentshistory,
				'data'  => $paymentshistoryarr,				
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
		/*	$paymentongoing = PaymentsHistory::select('payments_history.courseid as courseId','payments_history.orderid as orderId','payments_history.receipt','payments_history.amount','payments_history.currency','payments_history.course_title as courseTitle','payments_history.modulename as moduleName','payments_history.package_startdate as packageStartDate','payments_history.package_enddate as packageEndDate','payments_history.created_at as createAt','courses.coursePhotoName as photoName','courses.coursePhoto as imageName')			
			->join('courses', 'courses.id', '=', 'payments_history.courseid')
			->where('payments_history.package_enddate', '>=', $currentdate)
			->where('payments_history.userid', $userid)
			->where('payments_history.payment_status', 'S')
			->orderBy('payments_history.created_at', 'desc')
			->get();*/
			$paymentongoing = PaymentsHistory::select('payments_history.moduletype as moduleType','payments_history.total_amount as totalAmount','payments_history.discount_total as discountTotal','payments_history.grand_total as grandTotal','payments_history.discount','payments_history.courseid as courseId','payments_history.currency','payments_history.course_title as courseTitle','payments_history.modulename as moduleName','payments_history.package_startdate as packageStartDate','payments_history.package_enddate as packageEndDate','payments_history.created_at as createAt','courses.coursePhotoName as photoName','courses.coursePhoto as imageName')			
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
				if($paymentval['moduleType'] =="2"){
				    $advisoryReportfiles = AdvisoryNotificationReports::select('reportName')->where('courseId',$paymentval['courseId'])->where('moduleId',$paymentval['moduleType'])->orderby('created_at','DESC')->first();
					if(!empty($advisoryReportfiles)){
						if ($advisoryReportfiles['reportName']!="" && file_exists(public_path('uploads/reports/'.$advisoryReportfiles['reportName']))){
							$paymentongoing[$paymentkey]['reports'] = url('uploads/reports/'.$advisoryReportfiles['reportName']);
						}
					}
				    // $paymentongoing[$paymentkey]['reports'] = url('uploads/reports/sample.pdf');
					// $paymentongoing[$paymentkey]['reports'] = url('uploads/reports/REPORT-FORMAT-FOR-MOBILE-APP.xls');
				}
			}

			/*$paymentonpast = PaymentsHistory::select('payments_history.courseid as courseId','payments_history.orderid as orderId','payments_history.receipt','payments_history.amount','payments_history.currency','payments_history.course_title as courseTitle','payments_history.modulename as moduleName','payments_history.package_startdate as packageStartDate','payments_history.package_enddate as packageEndDate','payments_history.created_at as createAt','courses.coursePhotoName as photoName','courses.coursePhoto as imageName')			
			->join('courses', 'courses.id', '=', 'payments_history.courseid')
			->where('payments_history.package_enddate', '<', $currentdate)
			->where('payments_history.userid', $userid)
			->where('payments_history.payment_status', 'S')
			->orderBy('payments_history.created_at', 'desc')
			->get();*/
			$paymentonpast = PaymentsHistory::select('payments_history.total_amount as totalAmount','payments_history.discount_total as discountTotal','payments_history.grand_total as grandTotal','payments_history.discount','payments_history.courseid as courseId','payments_history.currency','payments_history.course_title as courseTitle','payments_history.modulename as moduleName','payments_history.package_startdate as packageStartDate','payments_history.package_enddate as packageEndDate','payments_history.created_at as createAt','courses.coursePhotoName as photoName','courses.coursePhoto as imageName')			
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
	
	public function activateTrial(Request $request){
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
			$CourseDetail = Courses::select('id', 'chrIndiaFees', 'chrWorldFees', 'moduleTypes', 'level','varTitle','coursePhoto')->where('id',$courseid)->first(); 
			
			$moduletypes = $CourseDetail['moduleTypes'];
			if($moduletypes==2){
				$user = Auth::user();
				if(!empty($user)){
					if($user->isTrial == 0){						
						// Order insert begin
						$varname = str_replace(" ","",$user->name);
						$datetime = date('dmYHIs');
						$receipt = strtoupper("ORDER_TRIAL_".$user->id."".$varname."".$datetime);
						$varcountrycode = $user->varcountryCode;
						if($varcountrycode=="IN"){
							$currency = "INR";
							$amount = "0";
						}else{
							$currency = "USD";
							$amount = "0";
						}
						$orderid = 'order_trial_'.$datetime;

						$moduledetail = ModuleType::select('id', 'name')->where('id', $moduletypes)->where('is_active', '1')->where('is_delete', '0')->first();
					
						$leveldetail = Level::select('id', 'name')->where('id', $CourseDetail['level'])->where('is_active', '1')->where('is_delete', '0')->first();
				
						$currentdate = date('Y-m-d H:i:s');
						// new code begin 
						$insertpayment = array(
							'userid' => $user->id,
							'orderid' =>$orderid,
							'receipt' =>$receipt,
							'total_amount' => $amount,
							'discount_total' => $amount,
							'grand_total' => $amount,
							'discount' =>$amount,							
							'currency' =>$currency,
							'payment_status' => 'Y',
							// 'entity' => NULL,						
							// 'amount_paid' => $amount,
							// 'amount_due' => $amount,
							// 'offer_id' => NULL,
							'status' => 'created',
							// 'attempts' =>NULL,
							// 'notes' => NULL,
							// 'order_created_at' => NULL
						);									
						$payments = Payments::create($insertpayment);
						$lastInsertedId = $payments->id;
                        
                        $coursearr = array();
						$coursearr['paymentid'] = $lastInsertedId;	
						$coursearr['courseid'] = $courseid;
						$coursearr['userid'] = $user->id;	
						$coursearr['total_amount'] = $amount;
						$coursearr['discount_total'] = $amount;
						$coursearr['grand_total'] = $amount;
						$coursearr['currency'] = $currency;
						// $coursearr['discount'] = NULL;
						$coursearr['payment_status'] = 'S';
						// $coursearr['course_title'] = $courses->varTitle;
						$coursearr['course_duration'] = $CourseDetail['courseDuration'];
						$coursearr['moduletype'] = $moduletypes;
						$coursearr['modulename'] = $moduledetail['name'];
						$coursearr['level'] = $CourseDetail['level'];
						$coursearr['levelname'] = $leveldetail['name'];
						$coursearr['course_duration'] = '7';
						$coursearr['course_trial'] = '1';
						$coursearr['package_startdate'] = $currentdate;
						$coursearr['package_enddate'] = date('Y-m-d H:i:s', strtotime($currentdate. ' + 7 day'));
						$coursearr['course_title'] = $CourseDetail['varTitle'];
						PaymentsHistory::create($coursearr);			
						// new code end

						/*
						$paymenthistory = array();
						$paymenthistory['userid'] = $user->id;
						$paymenthistory['courseid'] = $courseid;
						$paymenthistory['orderid'] = $orderid;
						$paymenthistory['receipt'] = $receipt;
						$paymenthistory['entity'] = 'order';
						$paymenthistory['amount'] = $amount;
						$paymenthistory['amount_paid'] = $amount;
						$paymenthistory['amount_due'] = $amount;
						$paymenthistory['currency'] = $currency;
						$paymenthistory['offer_id'] = NULL;
						$paymenthistory['status'] = 'created';
						$paymenthistory['attempts'] = 0;
						$paymenthistory['notes'] = NULL;
						$paymenthistory['order_created_at'] = NULL;
						$paymenthistory['payment_id'] = NULL;
						$paymenthistory['signature'] = NULL;						
						$paymenthistory['payment_status'] = 'S';
						$paymenthistory['moduletype'] = $moduletypes;
						$paymenthistory['modulename'] = $moduledetail['name'];
						$paymenthistory['level'] = $CourseDetail['level'];
						$paymenthistory['levelname'] = $leveldetail['name'];					
						$paymenthistory['package_startdate'] = $currentdate;
						$paymenthistory['package_enddate'] = date('Y-m-d H:i:s', strtotime($currentdate. ' + 7 day'));
						$paymenthistory['course_title'] = $CourseDetail['varTitle'];
						$paymenthistory['course_duration'] = '7';
						$paymenthistory['course_trial'] = '1';
					//	$paymenthistory['created_at'] = $payments['created_at'];
					//	$paymenthistory['updated_at'] = $payments['updated_at'];
						PaymentsHistory::create($paymenthistory);
						// order insert end

						*/
						User::where('id',$user->id)->update(['isTrial'=>1]);

						$to_name = $user->name;
						$to_email = $user->email;
						$varTitle = $CourseDetail['varTitle'];				
						$package_startdate = $coursearr['package_startdate'];
						$package_enddate = $coursearr['package_enddate'];
						$bodyhtml = 'Thank you for using '.env('MAIL_FROM_NAME').'. Please quote your Transaction ID for any queries relating to this transaction in future.<br/><br/><br/>					
						<b>Trial Course Transaction Details</b><br/><br/><br/>
						<b>Course Name:</b> '.$varTitle.' <br/>						
						<b>Order ID:</b> '.$orderid.' <br/>
						<b>Package Start Date:</b> '.$package_startdate.' <br/>
						<b>Package End Date:</b> '.$package_enddate.' <br/>';
						$data = array('name'=>$to_name, "body" => $bodyhtml);
						
						Mail::send('emails.payment', $data, function($message) use ($to_name, $to_email) {
						$message->to($to_email, $to_name)->subject(env('MAIL_FROM_NAME').' - Payment success');
							$message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));		
						});
						
						$response = [
							'status' => true,
							'statusCode' => 200,
							'data'  => [],
							'errormessage' => [],
							'message' => 'success'
						];

					
					}else{
						$response = [
							'status' => false,
							'statusCode' => 200,
							'data'  => [],
							'errormessage' => [],
							'message' => 'You have already advisory trial completed.'
						];
					}					
				}	
			}else{
				$response = [
					'status' => false,
					'statusCode' => 200,
					'data'  => [],
					'errormessage' => [],
					'message' => 'Your course not for advisory.'
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
	
	public function getCombineOrder(Request $request){
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
			$user = Auth::user();
			if(!empty($user)){

				$coursevalarr = $request->courseId;			
				if(!empty($coursevalarr)){
					
					$totalamount = 0; 
					$discountinper = 0;
					$promocodeDetail = GeneralSettings::select('id','value')->where('name_slug','COURSE_DISCOUNT')->first();
					if(!empty($promocodeDetail)){
						$discountinper = (int) $promocodeDetail['value'];
					}
					
					$varname = str_replace(" ","",$user->name);
					$datetime = date('dmYHIs');
					$receipt = strtoupper("ORDER".$user->id."".$varname."".$datetime);
					
					$varcountrycode = $user->varcountryCode;
					if($varcountrycode=="IN"){
						$currency = "INR";						
					}else{
						$currency = "USD";						
					}

					$coursearr = array();

					foreach($coursevalarr as $coursekey => $courseval){
						if($courseval !=""){
							$courses = Courses::select('id', 'chrIndiaFees', 'chrWorldFees', 'moduleTypes', 'level','varTitle','coursePhoto', 'courseDuration')->where('id', $courseval)->where('is_active', '1')->where('is_delete', '0')->first();
							
							$moduletypes = $courses->moduleTypes;

							$moduledetail = ModuleType::select('id', 'name')->where('id', $moduletypes)->where('is_active', '1')->where('is_delete', '0')->first();
					
							$leveldetail = Level::select('id', 'name')->where('id', $courses->level)->where('is_active', '1')->where('is_delete', '0')->first();

							if($varcountrycode=="IN"){
								$totalamount += $courses->chrIndiaFees;
								$tempamount = $courses->chrIndiaFees;
							}else{
								$totalamount += $courses->chrWorldFees;
								$tempamount = $courses->chrWorldFees;
							}

							$tempDiscountPrice = $tempamount - ($tempamount * ($discountinper / 100));
							$temptotalDiscountAmount = $tempamount - $tempDiscountPrice;

							$coursearr[$coursekey]['courseid'] = $courseval;
							$coursearr[$coursekey]['userid'] = $user->id;	
							$coursearr[$coursekey]['total_amount'] = $tempamount;
							$coursearr[$coursekey]['discount_total'] = $temptotalDiscountAmount;
							$coursearr[$coursekey]['grand_total'] = $tempDiscountPrice;
							$coursearr[$coursekey]['currency'] = $currency;
							$coursearr[$coursekey]['discount'] = $discountinper;
							$coursearr[$coursekey]['payment_status'] = 'P';
							$coursearr[$coursekey]['course_title'] = $courses->varTitle;
							$coursearr[$coursekey]['course_duration'] = $courses->courseDuration;
							$coursearr[$coursekey]['moduletype'] = $moduletypes;
							$coursearr[$coursekey]['modulename'] = $moduledetail->name;
							$coursearr[$coursekey]['level'] = $courses->level;
							$coursearr[$coursekey]['levelname'] = $leveldetail->name;
							$coursearr[$coursekey]['course_trial'] = '';
						}
					}

					$DiscountPrice = $totalamount - ($totalamount * ($discountinper / 100));
					
					$totalDiscountAmount = $totalamount - $DiscountPrice;
					$amount = $DiscountPrice."00";

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

						$insertpayment = array(
							'userid' => $user->id,
							'total_amount' => $totalamount,
							'discount_total' => $totalDiscountAmount,
							'grand_total' => $DiscountPrice,
							'discount' =>$discountinper,						
							'receipt' =>$receipt,
							'currency' =>$currency,
							'orderid' =>$curlresponse->id,						
							'entity' =>$curlresponse->entity,						
							'amount_paid' =>substr($curlresponse->amount_paid, 0, -2),
							'amount_due' =>substr($curlresponse->amount_due, 0, -2),
							'offer_id' =>$curlresponse->offer_id,
							'status' =>$curlresponse->status,
							'attempts' =>$curlresponse->attempts,
							'notes' => serialize($curlresponse->notes),
							'order_created_at' =>$curlresponse->created_at	
						);
									
						$payments = Payments::create($insertpayment);
						$lastInsertedId = $payments->id;
						
						foreach($coursearr as $coursearrkey => $coursearrval){
							$coursearrval['paymentid'] = $lastInsertedId;
							PaymentsHistory::create($coursearrval);		
						}

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

			}else{
				$response = [
					'status' => false,
					'statusCode' => 200,
					'data'  => [],
					'errormessage' => [],
					'message' => 'not authorize user',
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