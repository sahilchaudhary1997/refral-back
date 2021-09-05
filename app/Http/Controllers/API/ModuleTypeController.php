<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Language;
use App\Models\Markets;
use App\Models\ModuleType;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;

class ModuleTypeController extends Controller
{
    public function getModuleTypes(Request $request)
    {	
		$moduletypes = ModuleType::select('name', 'id')->where('is_active', '1')->where('is_delete', '0')->orderBy('intorder','asc')->get();
		
		$response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => $moduletypes,
			'errormessage' => [],
            'message' => ''
        ];
		
		return response()->json($response);		
	}		
}
