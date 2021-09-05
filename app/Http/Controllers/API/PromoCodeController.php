<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
// use App\Models\Language;
// use App\Models\Markets;
// use App\Models\Courses;
// use App\Models\Payments;
// use App\Models\PaymentsHistory;
// use App\Models\ModuleType;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use DB;
// use Ixudra\Curl\Facades\Curl;
// use Razorpay\Api\Api;
// use App\Models\Level;
// use Mail;
use App\general_settings as GeneralSettings;

class PromoCodeController extends Controller
{
	public function getOffer(){
		
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];	

		$promocodeDetail = GeneralSettings::select('id','value')->where('name_slug','COURSE_DISCOUNT')->first();

		if(!empty($promocodeDetail)){
			
			$promocodearr = array('discount'=>$promocodeDetail['value']);
			$response = [
				'status' => true,
				'statusCode' => 200,
				'data'  => $promocodearr,
				'errormessage' => [],
				'message' => ''
			];
		}else{
			$response = [
				'status' => false,
				'statusCode' => 200,
				'data'  => [],
				'errormessage' => [],
				'message' => 'Discount not avaliable'
			];
		}
		

		return response()->json($response);
	}
}