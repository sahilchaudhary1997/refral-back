<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Language;
use App\Models\Markets;
use App\Models\Courses;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\CmsPages;

class PagesController extends Controller
{
    public function getAboutUs(Request $request)
    {
		$lanshortcode = 'en';

		$AboutusDetails = CmsPages::select('varTitle as title', 'txtDescription as description')
		->where('is_active', '1')
		->where('is_delete', '0')
		->where('id', '1')
		->first();

		if(!empty($request->userId) && $request->userId>0){
			$userid = $request->userId;
			// for language begin
			$UserLangDetail = User::select('users.id','users.intLanguageId','users.intMarketId','languages.name','languages.shortcode')	
				->join('languages', 'languages.id', '=', 'users.intLanguageId')
				->where('users.id', $userid)
				->first();
			$lanshortcode = $UserLangDetail['shortcode'];				
			// for language end
		}

		if($lanshortcode !="en"){
			$AboutusDetails['title'] = languageTranslateUsingCurl('en',$lanshortcode, $AboutusDetails['title']);
			$AboutusDetails['description'] = languageTranslateUsingCurl('en',$lanshortcode, $AboutusDetails['description']);			
		}

		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => $AboutusDetails,
			'errormessage' => [],
            'message' => ''
        ];
		
		return response()->json($response);		
	}

	public function getPrivacyPolicy(Request $request)
    {
		$lanshortcode = 'en';

		$PrivacyPolicyDetails = CmsPages::select('varTitle as title', 'txtDescription as description')
		->where('is_active', '1')
		->where('is_delete', '0')
		->where('id', '2')
		->first();		
		
		if(!empty($request->userId) && $request->userId>0){
			$userid = $request->userId;
			// for language begin
			$UserLangDetail = User::select('users.id','users.intLanguageId','users.intMarketId','languages.name','languages.shortcode')	
				->join('languages', 'languages.id', '=', 'users.intLanguageId')
				->where('users.id', $userid)
				->first();
			$lanshortcode = $UserLangDetail['shortcode'];				
			// for language end
		}

		if($lanshortcode !="en"){
			$PrivacyPolicyDetails['title'] = languageTranslateUsingCurl('en',$lanshortcode, $PrivacyPolicyDetails['title']);
			$PrivacyPolicyDetails['description'] = languageTranslateUsingCurl('en',$lanshortcode, $PrivacyPolicyDetails['description']);			
		}

		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => $PrivacyPolicyDetails,
			'errormessage' => [],
            'message' => ''
        ];
		
		return response()->json($response);		
	}
	
	public function getTermsandConditions(Request $request)
    {
		$lanshortcode = 'en';

		$TermsandConditionsDetails = CmsPages::select('varTitle as title', 'txtDescription as description')
		->where('is_active', '1')
		->where('is_delete', '0')
		->where('id', '3')
		->first();		
		
		if(!empty($request->userId) && $request->userId>0){
			$userid = $request->userId;
			// for language begin
			$UserLangDetail = User::select('users.id','users.intLanguageId','users.intMarketId','languages.name','languages.shortcode')	
				->join('languages', 'languages.id', '=', 'users.intLanguageId')
				->where('users.id', $userid)
				->first();
			$lanshortcode = $UserLangDetail['shortcode'];				
			// for language end
		}

		if($lanshortcode !="en"){
			$TermsandConditionsDetails['title'] = languageTranslateUsingCurl('en',$lanshortcode, $TermsandConditionsDetails['title']);
			$TermsandConditionsDetails['description'] = languageTranslateUsingCurl('en',$lanshortcode, $TermsandConditionsDetails['description']);			
		}

		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => $TermsandConditionsDetails,
			'errormessage' => [],
            'message' => ''
        ];
		
		return response()->json($response);		
	}
		
}
