<?php
use App\permissions;
use App\modules;
use App\images;

function GenerateOTP($n)
{
    $generator = "0512436897";
    $result = '';
    for ($i = 1; $i <= $n; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
    }
    return $result;
}

function EmailSender($view,$data)
{
    Mail::send($view, $data, function ($m) use ($data) {

        $m->from(config('constants.MAIL_FROM_EMAIL'), config('constants.MAIL_FROM'));
        $m->sender(config('constants.MAIL_FROM_EMAIL'), config('constants.MAIL_FROM'));
        $m->to($data['mailTo'], $data['mailToName'])->subject($data['mailSubject']);

        if(isset($data['mailReplyTo']) && !empty($data['mailReplyTo'])){
            $m->replyTo($data['mailReplyTo'],config('constants.MAIL_FROM'));
        }else{
            $m->replyTo(config('constants.MAIL_REPLY_TO_EMAIL'),config('constants.MAIL_FROM'));
        }

        if(isset($data['mailCC']) && !empty($data['mailCC'])){
            $m->cc($data['mailCC'],$name = NULL);
        }

        if(isset($data['mailBCC']) && !empty($data['mailBCC'])){
            $m->bcc($data['mailBCC'],$name = NULL);
        }

        if(isset($data['mailFile']) && !empty($data['mailFile'])){
            if(is_array($data['mailFile'])){
                foreach($data['mailFile'] as $attachment){
                    $m->attach($attachment);
                }
            }else{
                $m->attach($data['mailFile']);
            }
        }
    });

    if (Mail::failures()) {
       return false;
    }
    return true;
}

function ResizeImage($imgId,$height,$width)
{
    $img = images::find($imgId);

    if(!file_exists(public_path('uploads'))){
        mkdir(public_path('uploads',0755));
    }

    if(!file_exists(public_path('uploads/caches'))){
        mkdir(public_path('uploads/caches',0755));
    }

    if(!empty($img)){

        if(!file_exists(public_path('uploads/caches/'.$img->directory))){
            mkdir(public_path('uploads/caches/'.$img->directory),0755);
        }

        if(!file_exists(public_path('uploads/caches/'.$img->directory.'/'.$height.'_'.$width))){
            mkdir(public_path('uploads/caches/'.$img->directory.'/'.$height.'_'.$width),0755);
        }

        $filePath = public_path('uploads/caches/'.$img->directory.'/'.$height.'_'.$width.'/'.$img->name);

        if(!file_exists($filePath)){
            $originalImage = public_path('uploads/files/'.$img->directory.'/'.$img->name);
            if(file_exists($originalImage)){
                $original = Image::make($originalImage);
                $original->resize($height, $width, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($filePath);
            }
        }
        return url('uploads/caches/'.$img->directory.'/'.$height.'_'.$width.'/'.$img->name);
    }

    return ReturnDefaultImage($height,$width);
}

function ReturnDefaultImage($height,$width)
{
    if(!file_exists(public_path('uploads/caches/default'))){
        mkdir(public_path('uploads/caches/default'),0755);
    }
    if(!file_exists(public_path('uploads/caches/default/'.$height.'_'.$width))){
        mkdir(public_path('uploads/caches/default/'.$height.'_'.$width),0755);
    }
    $filePath = public_path('uploads/caches/default/'.$height.'_'.$width.'/no_image.png');

    if(!file_exists($filePath)){
        $originalImage = public_path('uploads/default/no_image.png');
        $original = Image::make($originalImage);
        $original->resize($height, $width, function ($constraint) {
            $constraint->aspectRatio();
        })->save($filePath);
    }

    return url('uploads/caches/default/'.$height.'_'.$width.'/no_image.png');
}

function UploadImage($file,$dir,$module,$guard = 0)
{
    $imgId = 1;
    $lastRecord = images::latest()->first();
    if(!empty($lastRecord)){
        $imgId = $lastRecord->id;
    }

    $iname = explode('.',$file->getClientOriginalName())[0].'_'.time().'_'.date('Ymd').'_'.$imgId.'.'.$file->getClientOriginalExtension();

    $destinationPath = public_path("uploads/files/".$dir);
    
    if(!file_exists($destinationPath)){
        mkdir($destinationPath,0755);
    }
  
    $file->move($destinationPath, $iname);
    
    $record = images::create(['name'=>$iname,'module'=>$module,'directory'=>$dir,'is_admin'=>$guard]);

    return $record->id;
}

function DeleteImage($imgId)
{
    if(!empty($imgId)){
        $img = images::find($imgId);
        if(!empty($img)){
           $path = public_path('uploads/files/'.$img->directory.'/'.$img->name);
           if(file_exists($path)){
               unlink($path);
               images::destroy($imgId);
               return true;
           }
        }
    }
    return false;
}

function CheckModuleIsActiveOrNot($expression)
{
    $modules = Cache::get('modules');
    if(empty($modules)){
        $modules = modules::where('is_active',1)->get();
        Cache::forever('modules',$modules);
    }
    
    foreach($modules as $module){
        if($module->module_slug == $expression){
            return true;
        }
    }
    return false;
}

function ManagePermission($expression)
{
    if(Auth::guard('admin')->user()->role_id == 1){
        return true;
    }

    $forModule = explode('-',$expression);
    if(CheckModuleIsActiveOrNot($forModule[0])){
        
        $permissions = getPermissionArray();
    
        foreach($permissions as $permission){
            if($permission->role_id == Auth::guard('admin')->user()->role_id && $permission->per_slug == $expression){
                return true;
            }
        }
    }
    return false;
}

function getPermissionArray()
{
    $permissions = Cache::get('permissionArray');
    if(empty($permissions)){
        $permissions = permissions::join('role_permissions','role_permissions.permission_id','=','permissions.id')
                    ->select('role_permissions.role_id','permissions.per_slug')
                    ->get();
        Cache::forever('permissionArray', $permissions);
    }
    return $permissions;
}


function ResizeImageUsingImageName($imgName,$imagedir,$height,$width)
{    
    if(!file_exists(public_path('uploads'))){
        mkdir(public_path('uploads',0755));
    }

    if(!file_exists(public_path('uploads/caches'))){
        mkdir(public_path('uploads/caches',0755));
    }

    if(!empty($imgName)){

        if(!file_exists(public_path('uploads/caches/'.$imagedir))){
            mkdir(public_path('uploads/caches/'.$imagedir),0755);
        }

        if(!file_exists(public_path('uploads/caches/'.$imagedir.'/'.$height.'_'.$width))){
            mkdir(public_path('uploads/caches/'.$imagedir.'/'.$height.'_'.$width),0755);
        }

        $filePath = public_path('uploads/caches/'.$imagedir.'/'.$height.'_'.$width.'/'.$imgName);

        if(!file_exists($filePath)){
            $originalImage = public_path('uploads/'.$imgName);
            if(file_exists($originalImage)){
                $original = Image::make($originalImage);
                $original->resize($height, $width, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($filePath);
            }
        }
        return url('uploads/caches/'.$imagedir.'/'.$height.'_'.$width.'/'.$imgName);
    }

    return ReturnDefaultImage($height,$width);
}

function SendFirebaseNotification($title,$msg,$tokens,$data)
{
    $regkey = env('FIREBASE_SERVER_KEY');    
    $url = 'https://fcm.googleapis.com/fcm/send';
    $headers = array(
        'Content-Type:application/json',
        'Authorization:key=' . $regkey
    );
    
    // $headers = array(
    //     'Content-Type:application/json',
    //     'Authorization:key=' . config('constants.FIREBASE_SERVER_KEY')
    // );
    $data['title'] = $title;
    $data['body'] = $msg;

    $tokens = array_chunk($tokens,1000);
    
    foreach($tokens as $token){
        
        $payload = [
            "notification" => [
                "title" => $title,
                "body" => $msg
            ],
            'registration_ids' => $token,
            'data' => $data,
            "android" => [
                "priority" => "high"
            ]
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $result = curl_exec($ch);
        curl_close($ch);
    }
    
    return $result;
}

function languageTranslateUsingCurl($tolang,$fromlang,$titledescription)
{
    //$titlevalue = str_replace(" ","%20",$title);
    $trakey = env('GOOGLETRANSLATE_KEY');   
    $text = rawurlencode($titledescription);
    // $text = str_replace(" ","%20",$titledescription);
    $google_url = "https://www.googleapis.com/language/translate/v2?key=".$trakey."&q=".$text."&source=".$tolang."&target=".$fromlang;

    $handle = curl_init($google_url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($handle);
    $responseDecoded = json_decode($response, true);
    curl_close($handle);
    // print_r($responseDecoded);exit;
    return $responseDecoded['data']['translations'][0]['translatedText'];
}

function SendSMSNotification($number,$msg)
{
    $fullmsg = $msg." Your access code for your account - Market Mantra";
    $curlConfig = array(
        CURLOPT_URL            => "http://app.brandwoke.in/http-api.php",
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS     => array(
            'username' => 'Marketmantra',
            'password' => 'Marketmantra',
            'senderid' => 'ANKSMS',
            'route' => '1',
            'number' => $number,
            'message' => $fullmsg,
        )
    );
    
    $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);        
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt_array($ch, $curlConfig);
       // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $result = curl_exec($ch);
        curl_close($ch);
    
    return $result;
}
?>