<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use App\User;
use App\api_otp_requests;
use Hash;

class AuthController extends APIResponseController
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:55',
            'email' => 'required|email|string|max:100|unique:users,email',
            'phone' => 'required|string|max:10|min:10|regex:/^[0-9]+$/u|unique:users,phone',
            'password' => 'required|string|max:55|min:6',
            'username' => 'required|string|max:50|unique:users,username'
        ]);

        if($validator->fails()){
            return $this->SendResponse(null,$validator->messages()->first(),400);
        }
        
        try{
            $all = $request->all();
            $all['password'] = bcrypt($all['password']);
            $user = User::create($all);
            $user['token'] = $user->createToken(config('app.name'))->accessToken;
            unset($user['updated_at'],$user['created_at']);
            return $this->SendResponse($user,trans('api.registerSucess'),200);
        }catch(\Exception $e){
            return $this->SendResponse(null,trans('api.error'),500);
        }
    }

    function verify_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|string|max:10',
        ]);

        if($validator->fails()){
            return $this->SendResponse(null,$validator->messages()->first(),400);
        }

        try{
            $otp = api_otp_requests::where([['user_id',Auth::user()->id],['otp',$request->otp]])->orderBy('id','desc')->first();

            if(!empty($otp)){
                //User::find(Auth::user()->id)->update(['phone_verified_at'=>date('Y-m-d H:i:S')]);
                api_otp_requests::destroy($otp->id);
                return $this->SendResponse(null,trans('api.userVerify'),200);
            }else{
                return $this->SendResponse(null,trans('api.wrongOTP'),422);
            }
        }catch(\Exception $e){
            return $this->SendResponse(null,trans('api.error'),500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:55',
            'otp' => 'nullable|required_without:password|string|max:10',
            'password' => 'nullable|required_without:otp|string|max:50',
        ]);

        if ($validator->fails()) {
            return $this->SendResponse(null,$validator->messages()->first(),400);
        }

        $loginField = 'phone';
        if(filter_var($request->username, FILTER_VALIDATE_EMAIL)){
            $loginField = 'email';
        }

        try{
            if(empty($request->otp)){
                if(Auth::attempt([$loginField => request('username'), 'password' => request('password')])){
                    return $this->login_response(Auth::user());
                }else{
                    return $this->SendResponse(null,trans('api.credNotMatch'),406);
                }
            }else{
                $checkuser = User::where($loginField,$request->username)->orderby('id','desc')->first();
                if(!empty($checkuser)){
                    $otp = api_otp_requests::where([['user_id',$checkuser->id],['otp',$request->otp]])->orderby('id','desc')->first();
                    if(!empty($otp)){
                       $user = Auth::loginUsingId($checkuser->id);
                       api_otp_requests::destroy($otp->id);
                       $this->login_response(Auth::user());
                    }else{
                        return $this->SendResponse(null,trans('api.wrongOTP'),422);
                    }
                }else{
                    return $this->SendResponse(null,trans('api.userNotFound'),404);
                }
            }
        }catch(\Exception $e){
            dd($e->getMessage());
            return $this->SendResponse(null,trans('api.error'),500);
        }
    }

    private function login_response($user)
    {
        if($user->is_active == 1){
            $user['token'] = Auth::user()->createToken(config('app.name'))->accessToken;
            unset($user['updated_at'],$user['created_at'],$user['is_active'],$user['department'],$user['description'],$user['age'],$user['weight'],$user['sex'],$user['height'],$user['bodyfat'],$user['neck'],$user['shoulders'],$user['chest'],$user['bicep'],$user['waist'],$user['hips'],$user['thigh']);
            return $this->SendResponse($user,trans('api.loginSuccess'),200);
        }else{
            return $this->SendResponse(null,trans('api.accountDeactive'),403);
        }
    }

    protected function logout(Request $request)
	{
        try{
            $request->user()->token()->revoke();
            $request->user()->token()->delete();
            return $this->SendResponse('Success',trans('api.logoutSuccess'),200);
        }catch(\Exception $e){
            return $this->SendResponse(null,trans('api.error'),500);
        }
    }

    protected function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string|max:50',
            'new_password' => 'required|string|max:50',
        ]);

        if($validator->fails()) {
            return $this->SendResponse(null,$validator->messages()->first(),400);
        }

        try{
            if(Hash::check($request->old_password,Auth::user()->password)){
                User::find(Auth::user()->id)->update(["password"=>Hash::make($request->new_password)]);
                return $this->SendResponse(null,trans('api.passwordChangeSuccess'),200);
            }else{
                return $this->SendResponse(null,trans('api.oldPasswordWrong'),422);
            }
        }catch(\Exception $e){
            return $this->SendResponse(null,trans('api.error'),500);
        }
    }

    protected function request_otp(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:55',
        ]);

        if($validator->fails()) {
            return $this->SendResponse(null,$validator->messages()->first(),400);
        }

        $field = 'phone';
        if(filter_var($request->username, FILTER_VALIDATE_EMAIL)){
            $field = 'email';
        }

        try{
            $user = User::where($field,$request->username)->first();
            if(!empty($user)){
                $otp = GenerateOTP(6);
                //Update OTP in DB
                api_otp_requests::where('user_id',$user->id)->delete();
                api_otp_requests::create([
                    'user_id' => $user->id,
                    'otp' => $otp
                ]);
                //Send OTP
                $email['mailTo'] = $user->email;
                $email['mailToName'] = $user->name;
                $email['mailSubject'] = 'One Time Password';
                $email['user'] = $user;
                $email['otp'] = $otp;
                $res = EmailSender('emails.otp_request',$email);
                return $this->SendResponse(null,trans('api.otpSent'),200);
            }else{
                return $this->SendResponse(null,trans('api.recordNotFound'),404);
            }
        }catch(\Exception $e){
            return $this->SendResponse(null,trans('api.error'),500);
        }
    }

    protected function reset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:55',
            'otp' => 'required|string|max:6',
            'password' => 'required|string|max:50'
        ]);

        if($validator->fails()) {
            return $this->SendResponse(null,$validator->messages()->first(),400);
        }

        $field = 'phone';
        if(filter_var($request->username, FILTER_VALIDATE_EMAIL)){
            $field = 'email';
        }

        try{
            $user = User::where($field,$request->username)->orderby('id','desc')->first();
            if(!empty($user)){
                if($user->is_active == 1){
                    $otp = api_otp_requests::where([['user_id',$user->id],['otp',$request->otp]])->orderby('created_at','desc')->first();
                    if(!empty($otp)){
                        User::find($user->id)->update(['password'=>bcrypt($request->password)]);
                        api_otp_requests::destroy($otp->id);
                        return $this->SendResponse(null,trans('api.passwordChangeSuccess'),200);
                    }else{
                        return $this->SendResponse(null,trans('api.wrongOTP'),422);
                    }
                }else{
                    return $this->SendResponse(null,trans('api.accountDeactive'),403);
                }
            }else{
                return $this->SendResponse(null,trans('api.userNotFound'),404);
            }
        }catch(\Exception $e){
            return $this->SendResponse(null,trans('api.error'),500);
        }
    }
}
