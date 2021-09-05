<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use Mail;
use Config;

class LoginController extends Controller
{
    public function login(Request $request)
    {	
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];
		
        $rules = [
            'phoneNumber' => 'required'
        ];
		
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->fails()) {
            $digits = 4;
            $code = (rand(pow(10, $digits-1), pow(10, $digits)-1));
            $user = User::where('phoneNumber', $request->phoneNumber)->first();
            // $user = User::where('phoneNumber', $request->phoneNumber)->where('varcountryCode', $request->countryCode)->where('varcallingCode', $request->callingCode)->first();
            if ($user) {
                User::whereId($user->id)->update(['otpCode' => $code]);
				
				$to_name = $user->name;
				$to_email = $user->email;
				$bodyhtml = 'The Dynamic Access Code is : <b>'.$code.'</b><br/>
						Please Note:
						Dynamic Access Code has also been sent to your preferred mobile number registered with us.<br/>
						'.env('MAIL_FROM_NAME').' will never send you an email asking for your Login Credentials. Please do not respond to any email requesting such information.<br/>
						IMPORTANT: Please do not reply to this message. For any queries, please call our Customer Contact Number';
				$data = array('name'=>$to_name, "body" => $bodyhtml);
				
				Mail::send('emails', $data, function($message) use ($to_name, $to_email) {
				$message->to($to_email, $to_name)->subject('Dynamic Access Code');
					$message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));		
				});
								
                $response = [
                    'status' => true,
                    'statusCode' => 200,
                    'data'  => ['code' => $code],
					'errormessage' => [],
                    'message' => 'otp sent'
                ];
            } else {
                $response = [
                    'status' => false,
                    'statusCode' => 200,
                    'data'  => [],
					'errormessage' => [],
                    'message' => 'Invalid Phone Number',
                ];    
            }
            
            
        } else {
            $response = [
                'status' => false,
                'statusCode' => 200,
                'data'  => [],
				'errormessage' => $validator->messages(),
                'message' => 'Invalid data',
            ];
        }
        
        // if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
        //     return response()->json(['message' => 'Invalid Credentials']);
        // }
        return response()->json($response);
        
    }

    public function verifyOTP(Request $request)
    {
        $response = [];
        $rules = [
            'otp' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->fails()) {
            $digits = 4;
            $code = (rand(pow(10, $digits-1), pow(10, $digits)-1));
            $user = User::where('otpCode', $request->get('otp'))->first();
            if ($user && Auth::loginUsingId($user->id)) {
                $response = [
                    'status' => true,
                    'statusCode' => 200,
                    'data'  => ['accessToken' => auth()->user()->createToken('authToken')->accessToken],
					'errormessage' => [],
                    'message' => 'Login Successfully.'
                ];
                User::whereId(Auth::id())->update(['otpCode' => null]);
            } else {
                $response = [
                    'status' => false,
                    'statusCode' => 200,
                    'data'  => [],
					'errormessage' => [],
                    'message' => 'Invalid OTP',
                ];    
            }
        } else {
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
	
	public function logout(Request $request) {
		
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];
		//$token = $request->user()->token();
		//$token->revoke();
		Auth::logout();
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => 'You have been successfully logged out!'
        ];		
		
		return response()->json($response);
	}

	public function signup(Request $request)
    {
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];
        $rules = [
            'fullName' => 'required',
            'email' => 'required|email|unique:users',
            'phoneNumber' => 'required|unique:users',
            // 'countryCode' => 'required',
            // 'callingCode' => 'required',
            // 'password' => 'required',
        ];
		
		$validator = Validator::make($request->all(), $rules);
        if (!$validator->fails()) {
			
			
			$user = User::create([
					'name' => $request->fullName,
					'email' => $request->email,
					'phoneNumber' => $request->phoneNumber,
					'varcountryCode' => $request->countryCode,
					'varcallingCode' => $request->callingCode,
					// 'password' => Hash::make($request->password),					
				]);
				
			$lastInsertedId= $user->id;
			
			$response = [
                    'status' => true,
                    'statusCode' => 200,
                    'data'  => ['id' => $lastInsertedId],
					'errormessage' => [],
                    'message' => 'Sign Up Successfully.'
                ];
			// dd($user);
		
		}else {
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
