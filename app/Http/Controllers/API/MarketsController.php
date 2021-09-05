<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Language;
use App\Models\Markets;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;

class MarketsController extends Controller
{
    public function getmarkets(Request $request)
    {	
		$markets = Markets::select('name', 'id')->where('is_active', '1')->where('is_delete', '0')->orderBy('intorder','asc')->get();
		
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => $markets,
			'errormessage' => [],
            'message' => ''
        ];
		
		return response()->json($response);		
	}
	
	public function setmarket(Request $request, $id)
    {		
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];
		
		$rules = [
            'intmarketid' => 'required',            
        ];
		
		$validator = Validator::make($request->all(), $rules);
		
		if(!$validator->fails()) {
			
			if($id!="" && is_numeric($id) ){
				$intmarketval = implode(',',$request->intmarketid);
				
				$up = User::where('id', $id)->update([
					'intMarketId' => $intmarketval,				
				]);
				if($up) {
					$response = [
						'status' => true,
						'statusCode' => 200,
						'data'  => [],
						'errormessage' => [],
						'message' => 'Your market set successfully!'
					];
				} else {
					$response = [
						'status' => false,
						'statusCode' => 404,
						'data'  => [],
						'errormessage' => [],
						'message' => 'Your market not set!'
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
