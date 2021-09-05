<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
			$fileurl = '';
			$userFileName = $user->usersPhoto;
			if ($userFileName!="" && file_exists(public_path('uploads/'.$userFileName))){				
				$fileurl = url('uploads/'.$userFileName);
			}
			
			if(!empty($user->intMarketId)){
				$intMarketId = explode(',',$user->intMarketId);
			}
			
			if(isset($intMarketId) && is_array($intMarketId) && count($intMarketId) > 0){
				// $intMarketIdarr = $intMarketId;
				foreach($intMarketId as $markey => $marval){
                    $intMarketIdarr[]  = (int) $marval; 
                }
			}else{
				$intMarketIdarr = [];
			}
			
			$response = [
                    'status' => true,
                    'statusCode' => 200,
                    'data'  => [
						'id' => $user->id,
						'fullName' => $user->name,
						'email' => $user->email,
						'phoneNumber' => $user->phoneNumber,
						'fileName' => $userFileName,
						'fileFullUrl' => $fileurl,
						'selectedLanguageId' => $user->intLanguageId,						
						'selectedMarketsId' => $intMarketIdarr,
						'countryCode' => $user->varcountryCode,
						'callingCode' => $user->varcallingCode,
					],
					'errormessage' => [],
                    'message' => ''
                ];
			// dd($user);
		}
		// echo $user->id;exit;
		return response()->json($response);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		// echo "create call";exit;
		$response = [
            'status' => false,
            'statusCode' => 404,
            'data'  => [],
			'errormessage' => [],
            'message' => 'Invalid request'
        ];
		return response()->json($response);       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		// echo "store call";exit;
        $response = [
            'status' => false,
            'statusCode' => 404,
            'data'  => [],
			'errormessage' => [],
            'message' => 'Invalid request'
        ];
		return response()->json($response); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		//echo "show call";exit;
        $response = [
            'status' => false,
            'statusCode' => 404,
            'data'  => [],
			'errormessage' => [],
            'message' => 'Invalid request'
        ];
		return response()->json($response); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		// echo "edit call";exit;
        $response = [
            'status' => false,
            'statusCode' => 404,
            'data'  => [],
			'errormessage' => [],
            'message' => 'Invalid request'
        ];
		return response()->json($response); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
            'email' => 'required|email|unique:users,email,'.$id,
            'phoneNumber' => 'required|unique:users,phoneNumber,'.$id,
			// 'countryCode' => 'required',
            // 'callingCode' => 'required',
            // 'password' => 'required',
        ];
		
		$validator = Validator::make($request->all(), $rules);
        if (!$validator->fails()) {
			if($id!=""){
				$up = User::where('id', $id)->update([
					'name' => $request->fullName,
					'email' => $request->email,
					'phoneNumber' => $request->phoneNumber,
					'varcountryCode' => $request->countryCode,
					'varcallingCode' => $request->callingCode,
				]);
				if($up) {
					$response = [
						'status' => true,
						'statusCode' => 200,
						'data'  => [],
						'errormessage' => [],
						'message' => 'Your profile has been updated!'
					];
				} else {
					$response = [
						'status' => false,
						'statusCode' => 404,
						'data'  => [],
						'errormessage' => [],
						'message' => 'Your profile has not been updated!'
					];
				}
				
			}
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
        // 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		//echo "destroy call";exit;
        $response = [
            'status' => false,
            'statusCode' => 404,
            'data'  => [],
			'errormessage' => [],
            'message' => 'Invalid request'
        ];
		return response()->json($response);
    }
	
	
	public function uploadprofile(Request $request, $id)
    {	
        $response = [
            'status' => true,
            'statusCode' => 200,
            'data'  => [],
			'errormessage' => [],
            'message' => ''
        ];
		
		$rules = [
            'file' => 'required'           
        ];
		
		$validator = Validator::make($request->all(), $rules);
        if (!$validator->fails()) {
			if($id!=""){				
				$fileName = time().'.'.$request->file->extension();   
				$request->file->move(public_path('uploads'), $fileName);
		
				$up = User::where('id', $id)->update([					
					'usersPhoto' => $fileName,
				]);
				if($up) {
					$user = User::where('id',$id)->first();
					$fileurl = '';
					$userFileName = $user->usersPhoto;
					if (file_exists(public_path('uploads/'.$userFileName))){
						// $fileurl = url('uploads/'.$userFileName);
						$fileurl = ResizeImageUsingImageName($userFileName,'users',300,200);	
					}			
						
					$response = [
						'status' => true,
						'statusCode' => 200,
						'data'  => [
								'fileName' => $userFileName,
								'fileFullUrl' => $fileurl,],
						'errormessage' => [],
						'message' => 'Your profile Image updated!'
					];
					
				} else {
					$response = [
						'status' => false,
						'statusCode' => 404,
						'data'  => [],
						'errormessage' => [],
						'message' => 'Your profile has not been updated!'
					];
				}
				
			}
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
        // 
    }
	
	
}
