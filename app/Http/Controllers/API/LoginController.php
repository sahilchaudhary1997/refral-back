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
use App\Models\DeviceToken;

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
            'phoneNumber' => 'required',
            'password'    => 'required',
            'callingCode'    => 'required',
        ];
		
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->fails()) {
            $digits = 4;
            $code = (rand(pow(10, $digits-1), pow(10, $digits)-1));
            $user = User::where('phoneNumber', $request->phoneNumber)->where('varcallingCode', $request->callingCode)->first();
            // $user = User::where('phoneNumber', $request->phoneNumber)->where('varcountryCode', $request->countryCode)->where('varcallingCode', $request->callingCode)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                if(!$user->isVerified) { // if user not verified send resend
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
					SendSMSNotification($request->phoneNumber,$code);
                    $response = [
                        'status' => true,
                        'statusCode' => 200,
                        'data'  => ['isVerified' => false],
                        'errormessage' => [],
                        'message' => 'otp sent',
                    ];
                } else {
                    Auth::loginUsingId($user->id);
                    $response = [
                        'status' => true,
                        'statusCode' => 200,
                        'data'  => ['accessToken' => auth()->user()->createToken('authToken')->accessToken, 'isVerified' => true],
                        'errormessage' => [],
                        'message' => 'Login successfully.'
                    ];
                }
                
            } else {
                $response = [
                    'status' => false,
                    'statusCode' => 200,
                    'data'  => [],
					'errormessage' => [],
                    'message' => 'Invalid credentials.',
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
            'otp' => 'required',
            'phoneNumber' => 'required',
            'callingCode' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->fails()) {
            $digits = 4;
            // $code = (rand(pow(10, $digits-1), pow(10, $digits)-1));
            $user = User::where('phoneNumber', $request->phoneNumber)->where('varcallingCode', $request->callingCode)->where('otpCode', $request->get('otp'))->first();
            if ($user && Auth::loginUsingId($user->id)) {
                $response = [
                    'status' => true,
                    'statusCode' => 200,
                    'data'  => ['accessToken' => auth()->user()->createToken('authToken')->accessToken],
					'errormessage' => [],
                    'message' => 'Login Successfully.'
                ];
                User::whereId(Auth::id())->update(['otpCode' => null, 'isVerified' => 1]);
            } else {
                $response = [
                    'status' => false,
                    'statusCode' => 200,
                    'data'  => [],
					'errormessage' => [],
                    'message' => 'Invalid credentials.',
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
		
		$useremail = User::where('email', $request->email)->first();
		if(empty($useremail)){
			
			$userphone = User::where('phoneNumber', $request->phoneNumber)->first();
			if(empty($userphone)){
				
				$rules = [
					'fullName' => 'required',
					'email' => 'required|email|unique:users',
					'phoneNumber' => 'required|unique:users',
					'password'  => 'required',
					// 'countryCode' => 'required',
					// 'callingCode' => 'required',
					// 'password' => 'required',
				];
				
				$validator = Validator::make($request->all(), $rules);
				if (!$validator->fails()) {			
					
					$digits = 4;
					$code = (rand(pow(10, $digits-1), pow(10, $digits)-1));
					$user = User::create([
							'name' => $request->fullName,
							'email' => $request->email,
							'phoneNumber' => $request->phoneNumber,
							'varcountryCode' => $request->countryCode,
							'varcallingCode' => $request->callingCode,
							'password' => Hash::make($request->password),
							'otpCode' => $code,
						]);
						
					$lastInsertedId= $user->id;
					$to_name = $user->name;
					$to_email = $user->email;
					$bodyhtml = 'The Dynamic Access Code is : <b>'.$code.'</b><br/>
							Please Note:
							Dynamic Access Code has also been sent to your preferred mobile number registered with us.<br/>
							'.env('MAIL_FROM_NAME').' will never send you an email asking for your Login Credentials. Please do not respond to any email requesting such information.<br/>
							IMPORTANT: Please do not reply to this message. For any queries, please call our Customer Contact Number';
					$data = array('name'=>$to_name, "body" => $bodyhtml);
					
					Mail::send('emails.emails', $data, function($message) use ($to_name, $to_email) {
					$message->to($to_email, $to_name)->subject('Dynamic Access Code');
						$message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));		
					});
					
					SendSMSNotification($request->phoneNumber,$code);
					$response = [
							'status' => true,
							'statusCode' => 200,
							'data'  => ['id' => $lastInsertedId, 'code' => $code],
							'errormessage' => [],
							'message' => 'Sign Up Successfully.'
						];
					
				}else {
					$response = [
						'status' => false,
						'statusCode' => 200,
						'data'  => [],
						'errormessage' => $validator->messages(),
						'message' => 'Invalid data',
					];
				}
				
			}else{
				$response = [
					'status' => false,
					'statusCode' => 200,
					'data'  => [],
					'errormessage' => [],
					'message' => 'Phone number already exists.',
				];				
			}			
			
		}else{
			$response = [
				'status' => false,
				'statusCode' => 200,
				'data'  => [],
				'errormessage' => [],
				'message' => 'Email already exists.',
			];
		}
		
		return response()->json($response);
	}

    public function getOTP(Request $request)
    {
        $response = [];
        $rules = [
            // 'otp' => 'required',
            'phoneNumber' => 'required',
            'callingCode' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->fails()) {
            $digits = 4;
            $code = (rand(pow(10, $digits-1), pow(10, $digits)-1));
            $user = User::where('phoneNumber', $request->phoneNumber)->where('varcallingCode', $request->callingCode)->first();
            if ($user) {
                User::whereId($user->id)->update(['otpCode' => $code]);
                $this->sendEmailSMS($user, $code); // send email and sms
                $response = [
                    'status' => true,
                    'statusCode' => 200,
                    'data'  => [],
					'errormessage' => [],
                    'message' => 'OPT sent.'
                ];
            } else {
                $response = [
                    'status' => false,
                    'statusCode' => 200,
                    'data'  => [],
					'errormessage' => [],
                    'message' => 'Invalid phone number or calling code.',
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

    public function resetPassword(Request $request)
    {
        $response = [];
        $rules = [
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->fails()) {
            User::whereId(Auth::id())->update([
                'password' => Hash::make($request->password),
            ]);
            $response = [
                'status' => true,
                'statusCode' => 200,
                'data'  => [],
                'errormessage' => [],
                'message' => 'password has been changed successfully.'
            ];
        } else {
            $response = [
                'status' => false,
                'statusCode' => 200,
                'data'  => [],
				'errormessage' => $validator->messages(),
                'message' => 'The password field is required.',
            ];
        }
        return response()->json($response);
    }

    public function sendEmailSMS($user, $code)
    {
        $to_name = $user->name;
        $to_email = $user->email;
        $bodyhtml = 'The Dynamic Access Code is : <b>'.$code.'</b><br/>
                Please Note:
                Dynamic Access Code has also been sent to your preferred mobile number registered with us.<br/>
                '.env('MAIL_FROM_NAME').' will never send you an email asking for your Login Credentials. Please do not respond to any email requesting such information.<br/>
                IMPORTANT: Please do not reply to this message. For any queries, please call our Customer Contact Number';
        $data = array('name'=>$to_name, "body" => $bodyhtml);
        
        Mail::send('emails.emails', $data, function($message) use ($to_name, $to_email) {
        $message->to($to_email, $to_name)->subject('Dynamic Access Code');
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));		
        });
		SendSMSNotification($user->phoneNumber,$code);
    }
	
	public function registerDeviceToken(Request $request)
    {
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];	
		
		$user = Auth::user();
		
		if(!empty($user)){
			$rules = [
                'deviceToken' => 'required',            
            ];
            
            $messages = [
                'deviceToken.required' => 'device Token Required.',            
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if(!$validator->fails()) {
                $userid = $user->id;
                $deviceTokenre = DeviceToken::where('userid', $userid)->where('deviceToken', $request->deviceToken)->first();
		        if(empty($deviceTokenre)){
                    $deviceadd = DeviceToken::create([
                        'userid' => $userid,
                        'deviceToken' => $request->deviceToken                        
                    ]);

                    $response = [
                        'status' => true,
                        'statusCode' => 200,
                        'data'  => [],
                        'errormessage' => [],
                        'message' => 'Device token added Successfully.'
                    ];

                }else{
                    $response = [
                        'status' => false,
                        'statusCode' => 200,
                        'data'  => [],
                        'errormessage' => [],
                        'message' => 'device token already exists.',
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
		} 
			
		return response()->json($response);		
	}

    public function deRegisterDeviceToken(Request $request)
    {
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];	
		
		$user = Auth::user();
		
		if(!empty($user)){
			$rules = [
                'deviceToken' => 'required',            
            ];
            
            $messages = [
                'deviceToken.required' => 'device Token Required.',            
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if(!$validator->fails()) {
                $userid = $user->id;
                $deviceTokenre = DeviceToken::where('userid', $userid)->where('deviceToken', $request->deviceToken)->first();
		        if(!empty($deviceTokenre)){
                    $deltokesn = DeviceToken::where('userid',$userid)->where('deviceToken',$request->deviceToken)->delete();

                    $response = [
                        'status' => true,
                        'statusCode' => 200,
                        'data'  => [],
                        'errormessage' => [],
                        'message' => 'Device token deleted Successfully.'
                    ];

                }else{
                    $response = [
                        'status' => false,
                        'statusCode' => 200,
                        'data'  => [],
                        'errormessage' => [],
                        'message' => 'device token not found.',
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
		} 
			
		return response()->json($response);
	}
}
