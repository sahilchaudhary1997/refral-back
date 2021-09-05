<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\general_settings;
use Cache;
use Artisan;

class GeneralSettingController extends SystemAdminController
{
    var $breadcum = ['icon'=>'mdi mdi-settings','breadcum'=>['General Settings']];

    public function __construct()
    {
        parent::__construct();
    }
    
    public function index(Request $request)
    {
        $settings = general_settings::getList($request);
        $breadcum = $this->breadcum;
        $categories = general_settings::groupby('setting_group')->get();
        return view('admin.general_settings.general_settings',compact('settings','breadcum','categories'));
    }

    public function update(Request $request)
    {
        try{
            $settings = $request->all();
            unset($settings['_token']);

            foreach($settings['general_settings'] as $key => $value){
                general_settings::find($key)->update(['value'=>$value]);
            }

            if(isset($settings['cached'])){
                foreach($settings['cached'] as $key => $value){
                    switch($value){
                        case 'cache':
                            Artisan::call('cache:clear');
                        break;
                        case 'view':
                            Artisan::call('view:clear');
                        break;
                        case 'route':
                            Artisan::call('route:clear');
                        break;
                        case 'config':
                            Artisan::call('config:clear');
                        break;
                    }
                }
            }
        
            Cache::forget('generalSettings');

            return redirect()->back()->with('success','Settings updated successfully.');
            
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }   
    }
}
