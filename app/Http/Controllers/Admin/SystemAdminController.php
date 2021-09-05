<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Crypt;
use View;
use Config;
use Image;

class SystemAdminController extends Controller
{
    public function __construct()
    {
	/*	ini_set('memory_limit', '-1');
		ini_set('upload_max_filesize', '500M');
		ini_set('post_max_size', '500M');
		ini_set('max_input_time', 5000);
		ini_set('max_execution_time', 5000);*/
		
        $this->setCookies();
    }

    public function setCookies()
    {
        //Set page records
        if(!is_null(Cookie::get('pageRecords'))){
            $record = explode('|',Crypt::decrypt(Cookie::get('pageRecords'), false));
            $record = end($record);
            View::share('pageRecords', $record);
            Config::set('constants.pageRecords', $record);
        }else{
            View::share('pageRecords', 50);
            Config::set('constants.pageRecords', 50);
        }
    }

    public function setRecords($records)
    {
        if($records > 0){
            return redirect()->back()->withCookie(Cookie::forever('pageRecords', $records));
        }
        return redirect()->back();
    }
}
