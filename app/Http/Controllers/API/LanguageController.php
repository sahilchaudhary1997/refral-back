<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Language;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;

class LanguageController extends Controller
{
    public function getlanguage(Request $request)
    {
		// echo "Hello Hiii";exit;
		$indianlanguages = Language::select('name', 'id','shortcode')->where('chrindianlanguage', 'Y')->where('chrdelete', 'N')->orderBy('intindialanorder','asc')->get();
		$worldlanguages = Language::select('name', 'id','shortcode')->where('chractive', 'Y')->where('chrdelete', 'N')->orderBy('intdefaultorder','asc')->get();
		
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [
				[
					'title' => 'World Languages',
					'data' => $worldlanguages, 
				],
				[
					'title' => 'Indian Languages',
					'data' => $indianlanguages, 
				]
				
				//'indianlanguages' => $indianlanguages,
				//'worldlanguages' =>$worldlanguages
			],
			'errormessage' => [],
            'message' => ''
        ];
		
		
		return response()->json($response);
		
	}
	
	public function setlanguage(Request $request, $id)
    {		
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];
		
		$rules = [
            'intlanguage' => 'required',            
        ];
		
		$validator = Validator::make($request->all(), $rules);
		
		if(!$validator->fails()) {
			
			if($id!="" && is_numeric($id) ){
				$up = User::where('id', $id)->update([
					'intLanguageId' => $request->intlanguage,				
				]);
				if($up) {
					$response = [
						'status' => true,
						'statusCode' => 200,
						'data'  => [],
						'errormessage' => [],
						'message' => 'Your language set successfully!'
					];
				} else {
					$response = [
						'status' => false,
						'statusCode' => 404,
						'data'  => [],
						'errormessage' => [],
						'message' => 'Your language not set!'
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
		
		return response()->json($response);
		
	}	
}
